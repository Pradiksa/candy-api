<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserTypes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'user_name',
        'user_email',
        'user_type_id',
        'password',
        'active_status'
    ];
    protected $hidden = [
        'password',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function usertypes() {
        return $this->hasMany('App\Models\UserTypes', 'id', 'user_type_id')->select('id', 'type_name');
    }
}
