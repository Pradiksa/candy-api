<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Roles;

class EmployeeProject extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'emp_project';
    protected $primaryKey = 'emp_project_id';
    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'projects_id',
        'project_name',
        'client_id',
        'client_name',
        'role_id',
        'role_name',
        'employement_type_id',
        'employement_type_name',
        'emp_project_date',
        'emp_project_end_date',
        'active_status',

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function roleslist() {
        return $this->hasMany('App\Models\Roles', 'role_id', 'role_id');
    }

    public function employeetype() {
        return $this->hasMany('App\Models\Remuneration', 'employee_id', 'employee_id');
    }

    public function employeename() {
        return $this->hasMany('App\Models\AddEmployee', 'employee_id', 'employee_id');
    }





}
