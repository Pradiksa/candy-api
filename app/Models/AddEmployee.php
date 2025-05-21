<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AddEmployee extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'employee';
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'nick_name',
        'user_id',
        'mobile_no',
        'title',
        'password',
        'emp_image',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function serviceslist() {
        return $this->hasMany('App\Models\Services', 'service_id', 'service_id');
    }

    public function remunerationlist() {
        return $this->hasMany('App\Models\Remuneration', 'employee_id', 'employee_id');
    }

    public function employeeProjectlist() {
        return $this->hasMany('App\Models\EmployeeProject', 'employee_id', 'employee_id');
    }

}
