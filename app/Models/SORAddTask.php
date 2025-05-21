<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SORAddTask extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'sor_task';
    protected $primaryKey = 'sor_task_id';
    protected $fillable = [
        'projects_id',
        'client_id',
        'cost_type_id',
        'sor_task_date',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function projectlist() {
        return $this->hasMany('App\Models\Projects', 'projects_id', 'projects_id');
    }
    public function clientslist() {
        return $this->hasMany('App\Models\Clients', 'client_id', 'client_id');
    }

    public function costtypelist() {
        return $this->hasMany('App\Models\CostType', 'cost_type_id', 'cost_type_id');
    }
}
