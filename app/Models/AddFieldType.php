<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AddFieldType extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'add_fields';
    protected $primaryKey = 'add_fields_id';
    protected $fillable = [
        'add_field_type',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}

