<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Remuneration extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'remuneration';
    protected $primaryKey = 'remuneration_id';
    protected $fillable = [
        'remuneration_date',
        'employement_type_id',
        'employement_type_name',
         'gross_pay',
        'superannuation_id',
        'percent_value',
        'prt_id',
        'prt_percentage	',
        'annual_djc',
        'day_djc',
        'hr_djc',
        'employee_id',
        'active_status',

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function listalls() {
        return $this->hasMany('App\Models\AddEmployee', 'employee_id', 'employee_id');
    }

    public function employementtypelist() {
        return $this->hasMany('App\Models\EmploymentType', 'employement_type_id', 'employement_type_id');
    }

    public function employmenttypname() {
        return $this->hasOne('App\Models\EmploymentType', 'employement_type_id', 'employement_type_id')->select('employement_type_id', 'employement_type_name');
    }

    public function superannuationtypelist() {
        return $this->hasMany('App\Models\Superannuation', 'superannuation_id', 'superannuation_id');
    }

    public function superannuationtypname() {
        return $this->hasOne('App\Models\Superannuation', 'superannuation_id', 'superannuation_id')->select('superannuation_id', 'percent_value');
    }

    public function prttypelist() {
        return $this->hasMany('App\Models\Prt', 'prt_id', 'prt_id');
    }

    public function prttypname() {
        return $this->hasOne('App\Models\Prt', 'prt_id', 'prt_id')->select('prt_id', 'prt_percentage');
    }


}
