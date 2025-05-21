<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CostType extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'cost_type';
    protected $primaryKey = 'cost_type_id';
    protected $fillable = [
        'cost_type_name',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
