<?php

namespace App\Exports;

use App\changeRequestMaster;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class reportExportForm implements FromView
{
    public $fap = "false";
    public $ea = "false";
    public $ongoing = "false";
    public $deployed = "false";
    public $tbd = "false";
    public $halt = "false";
    public $PendingDeployment = "false";

    public function __construct($fap,$ea,$ongoing,$deployed,$tbd,$halt,$PendingDeployment){
        $this->fap=$fap;
        $this->ea=$ea;
        $this->ongoing=$ongoing;
        $this->deployed=$deployed;
        $this->tbd=$tbd;
        $this->halt=$halt;
        $this->PendingDeployment=$PendingDeployment;
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
                if ($this->fap == "true") {$query->orWhere('team_name', 'FAP');}
                if ($this->ea  == "true") {$query->orWhere('team_name', 'EA');}
            })->where(function ($query) {
                if ($this->ongoing  == "true") {$query->orWhere('cr_status', 'Ongoing');}
                if ($this->tbd  == "true") {$query->orWhere('cr_status', 'TBD');}
                if ($this->halt  == "true") {$query->orWhere('cr_status', 'Halt');}
                if ($this->deployed  == "true") {$query->orWhere('cr_status', 'Deployed');}
                if ($this->PendingDeployment  == "true") {$query->orWhere('cr_status', 'PendingDeployment');}
            })
            ->orderBy('PRIORITY', 'ASC')->get([
                'jira_code as jira_id',
                'cr_title as cr_item_name',
                'jira_created as jira_created',
                'priority as priority',
                'requester_team as requester_team',
                'team_name as team_name',
                'vendor_proposed_timeline as vendor_proposed_timeline',
                'cr_status as cr_status',
                'cr_notes as last_update'
            ]);

        return view('exports.formView', [
            'reportData' => $query
        ]);
    }
}
