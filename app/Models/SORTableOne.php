<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SORTableOne extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'sor_table_one';
    protected $primaryKey = 'sor_table_one_id';
    protected $fillable = [
        'sor_table_task_name',
        'sor_table_one_hours',
        'sor_table_one_percentage',
        'projects_id',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
