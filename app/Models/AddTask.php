<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AddTask extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'tasks';
    protected $primaryKey = 'task_id';
    protected $fillable = [
        'projects_id',
        'project_name',
        'client_id',
        'client_name',
        'cost_type_id',
        'cost_type_name',
        'task_date',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function tasks() {
        return $this->hasMany('App\Models\PriorityTaskTable', 'projects_id', 'projects_id');
    }

    // public function tasks() {
    //     return $this->hasMany('App\Models\AddTask', 'task_id', 'task_id')->select('task_id', 'cost_type_name') ->where('cost_type_name', 'fixed');
    // }

    public function tasksorone() {
        return $this->hasMany('App\Models\SORTableOne', 'projects_id', 'projects_id');
    }

    public function tasksortwo() {
        return $this->hasMany('App\Models\SORTableTwo', 'projects_id', 'projects_id');
    }



    public function projectlist() {
        return $this->hasMany('App\Models\Projects', 'projects_id', 'projects_id');
    }
    public function clientslist() {
        return $this->hasMany('App\Models\Clients', 'client_id', 'client_id');
    }

    public function costtypelist() {
        return $this->hasMany('App\Models\CostType', 'cost_type_id', 'cost_type_id');
    }

    public function clienttypname() {
        return $this->hasOne('App\Models\Clients', 'client_id', 'client_id')->select('client_id', 'client_name');
    }

    public function costtypname() {
        return $this->hasOne('App\Models\CostType', 'cost_type_id', 'cost_type_id')->select('cost_type_id', 'cost_type_name');
    }

    public function projectname() {
        return $this->hasOne('App\Models\Projects', 'projects_id', 'projects_id')->select('projects_id', 'project_name');
    }
}
