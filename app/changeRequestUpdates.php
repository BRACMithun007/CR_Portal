<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class changeRequestUpdates extends Model
{
    protected $table = 'change_request_updates';
    protected $connection = 'mysql';

    protected $fillable = [
        'id',
        'cr_master_id',
        'cr_update',
        'note_type',
        'cr_notes',
        'note_date',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
