<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Superannuation extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'superannuation';
    protected $primaryKey = 'superannuation_id';
    protected $fillable = [
        'from_date',
        'to_date',
        'year',
        'percent_value',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
