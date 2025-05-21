<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    protected $table = 'user_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type_name',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
