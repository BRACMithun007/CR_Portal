<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class changeRequestMaster extends Model
{
    protected $table = 'change_request_master';
    protected $connection = 'mysql';

    protected $fillable = [
        'id',
        'cr_title',
        'cr_details',
        'cr_doc_link',
        'jira_code',
        'jira_created',
        'initial_requirement_shared_from_mf',
        'approved_billable_effort',
        'team_name',
        'category',
        'cr_locked_by_vendor',
        'vendor_name',
        'mf_expect_timeline',
        'vendor_proposed_timeline',
        'requester_team',
        'priority',
        'cr_type',
        'cr_status',
        'completed_on',
        'business_analyst',
        'assigned_from_brac',
        'uat_instance',
        'uat_credential',
        'summary',
        'satisfactory_level',
        'is_archived',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
