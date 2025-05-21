<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TaskField extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'task_fields';
    protected $primaryKey = 'task_field_id';
    protected $fillable = [
        'field_task_id',
        'field_name',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function fieldsTasklist() {
        return $this->hasMany('App\Models\FieldsTask', 'field_task_id', 'field_task_id');
    }
    public function fieldsTaskType() {
        return $this->hasOne('App\Models\FieldsTask', 'field_task_id', 'field_task_id')->select('field_task_id', 'field_task_name');
    }

}
