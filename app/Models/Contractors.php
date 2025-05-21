<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Contractors extends Model

{ use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'contactors';
    protected $primaryKey = 'contactor_id';
    protected $fillable = [
        'contract_name',
        'contract_nick_name',
        'contract_type',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
