<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldsTask extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'field_task';
    protected $primaryKey = 'field_task_id';
    protected $fillable = [
        'field_task_name',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
