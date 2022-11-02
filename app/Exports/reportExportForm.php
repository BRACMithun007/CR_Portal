<?php

namespace App\Exports;

use App\changeRequestMaster;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class reportExportForm implements FromView
{
    public $business = "false";
    public $support = "false";
    public $ongoing = "false";
    public $deployed = "false";
    public $configurable = "false";
    public $integration = "false";
    public $hasDateVal = false;
    public $deploy_start = "";
    public $deploy_end = "";

    public function __construct($business,$support,$ongoing,$deployed,$configurable,$integration,$hasDateVal,$deploy_start,$deploy_end){
        $this->business=$business;
        $this->support=$support;
        $this->ongoing=$ongoing;
        $this->deployed=$deployed;
        $this->configurable=$configurable;
        $this->integration=$integration;
        $this->hasDateVal=$hasDateVal;
        $this->deploy_start=$deploy_start;
        $this->deploy_end=$deploy_end;
    }

    public function view(): View
    {
        $query = changeRequestMaster::leftJoin('change_request_updates', function($query)
        {
            $query->on('change_request_master.id', '=', 'change_request_updates.cr_master_id')
                ->whereRaw('change_request_updates.id IN (select MAX(u2.id) from change_request_updates as u2 join change_request_master as m2 on m2.id = u2.cr_master_id group by m2.id)');
        })
            ->where('is_archived', 0)
            ->where(function ($query) {
                if ($this->business == "true") {$query->orWhere('cr_type', 'Core_Business');}
                if ($this->support == "true") {$query->orWhere('cr_type', 'Support_CR');}
                if ($this->configurable  == "true") {$query->orWhere('cr_type', 'Configurable');}
                if ($this->integration  == "true") {$query->orWhere('cr_type', 'Integration');}
            })->where(function ($query) {
                if ($this->ongoing  == "true") {$query->orWhere('cr_status', 'Ongoing');}
                if ($this->deployed  == "true") {$query->orWhere('cr_status', 'Deployed');}
            })->where(function ($query) {
                if ($this->deployed  == "true" && $this->hasDateVal == true) {
                    $query->whereBetween('completed_on', [$this->deploy_start, $this->deploy_end]);
                }
            })
            ->orderBy('PRIORITY', 'ASC')->get([
                'jira_code as jira_id',
                'cr_title as cr_item_name',
                'jira_created as jira_created',
                'priority as priority',
                'requester_team as requester_team',
                'team_name as team_name',
                'assigned_from_brac as mf_focal',
                'vendor_proposed_timeline as vendor_proposed_timeline',
                'cr_status as cr_status',
                'cr_notes as last_update'
            ]);

        return view('exports.jiraReport', [
            'reportData' => $query
        ]);
    }
}
