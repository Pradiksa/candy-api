<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    protected $fillable = [
        'client_name',
        'client_nick_name',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
         'deleted_at'
    ];
}
