<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestCR extends Model
{
    protected $table = 'cr_requests';
    protected $connection = 'mysql';

    protected $fillable = [
        'id',
        'cr_title',
        'cr_details',
        'cr_doc_link',
        'jira_code',
        'jira_created',
        'initial_requirement_shared_from_mf',
        'team_name',
        'category',
        'mf_expect_timeline',
        'cr_status',
        'summary',
        'is_archived',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
