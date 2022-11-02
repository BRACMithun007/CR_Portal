<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class changeRequestComments extends Model
{
    protected $table = 'change_request_comments';
    protected $connection = 'mysql';

    protected $fillable = [
        'id',
        'cr_master_id',
        'comment_type',
        'comment',
        'comment_date',
        'comment_by',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
