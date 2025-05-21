<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SORTableTwo extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'sor_table_two';
    protected $primaryKey = 'sor_table_two_id';
    protected $fillable = [
        'projects_id',
        'contactor_id',
        'sor_table_two_code',
        'sor_table_two_description',
        'sor_table_two_qunatity',
        'sor_table_two_hours',
        'sor_table_two_stc_cost',
        'sor_table_two_emp_cost',
        'contractor_cost',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function contractorlist() {
        return $this->hasMany('App\Models\Contractors', 'contactor_id', 'contactor_id');
    }
}
