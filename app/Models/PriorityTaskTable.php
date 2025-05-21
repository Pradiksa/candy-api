<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PriorityTaskTable extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'priority_task_table';
    protected $primaryKey = 'priority_task_id';
    protected $fillable = [
        'priority',
        'projects_id',
        'task_table_id',
        'priority_task_name',
        'priority_task_hours',
        'with_stc_cost',
        'no_stc_cost',
        'emp_cost',
        'contractor_id_1',
        'contractor_name_1',
        'contractor_cost_1',
        'contractor_id_2',
        'contractor_name_2',
        'contractor_cost_2',
        'contractor_id_3',
        'contractor_name_3',
        'contractor_cost_3',
        'contractor_id_4',
        'contractor_name_4',
        'contractor_cost_4',
        'contractor_id_5',
        'contractor_name_5',
        'contractor_cost_5',
        'contractor_id_6',
        'contractor_name_6',
        'contractor_cost_6',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function contractorlist()
    {
        return $this->hasMany('App\Models\AddTask', 'projects_id', 'projects_id');
    }

    public function taskTablelist()
    {
        return $this->hasMany('App\Models\TaskTable', 'task_table_id', 'task_table_id');
    }

    public function sorTableOneTaskname()
    {
        return $this->hasMany('App\Models\SORTableOne', 'projects_id', 'projects_id')->select('projects_id', 'sor_table_task_name');
    }

    public function addTasklist()
    {
        return $this->hasMany('App\Models\AddTask', 'task_id', 'task_id');
    }
}
