<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'services';
    protected $primaryKey = 'service_id';
    protected $fillable = [
        'service_name',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
