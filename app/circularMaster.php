<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class circularMaster extends Model
{
    protected $table = 'circular_master';
    protected $connection = 'mysql';

    protected $fillable = [
        'id',
        'cr_master_id',
        'title',
        'details',
        'category',
        'circular_number',
        'sign_date',
        'circular_type',
        'effective_date',
        'jira_code',
        'status',
        'requester_team',
        'request_by',
        'request_on',
        'circular_doc',
        'mf_expect_timeline',
        'remarks',
        'is_archived',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
