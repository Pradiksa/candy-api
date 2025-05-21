<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTable extends Model
{
    protected $table = 'task_tables';
    protected $primaryKey = 'task_table_id';
    protected $fillable = [
        'project_id',
        'client_id',
        'date_of_effect'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $appends = ['project_details'];
    public function priorityTasks()
    {
        return $this->hasMany('App\Models\PriorityTaskTable', 'task_table_id', 'task_table_id');
    }
    public function getProjectDetailsAttribute()
    {
        return Projects::select('client_id', 'project_name')->find($this->project_id);
    }
    public function clientslist() {
        return $this->hasMany('App\Models\Clients', 'client_id', 'client_id');
    }
}