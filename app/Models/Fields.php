<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'fields';
    protected $primaryKey = 'fields_id';
    protected $fillable = [
        'projects_id',
        'field_name',
        'add_fields_id',
        // 'task_field_id',
        'field_task_id',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function Projecttypname() {
        return $this->hasOne('App\Models\Projects', 'projects_id', 'projects_id')->select('projects_id', 'project_name');
    }
    public function fieldTypeList() {
        return $this->hasOne('App\Models\AddFieldType', 'add_fields_id', 'add_fields_id')->select('add_fields_id', 'add_field_type');
    }
    public function taskFieldList() {
        return $this->hasOne('App\Models\TaskField', 'task_field_id', 'task_field_id')->select('task_field_id', 'field_name');
    }
    public function fieldsTaskType() {
        return $this->hasOne('App\Models\FieldsTask', 'field_task_id', 'field_task_id')->select('field_task_id', 'field_task_name');
    }

    // public function fieldtypelist() {
    //     return $this->hasMany('App\Models\FieldTypes', 'field_types_id', 'field_types_id');
    // }

}
