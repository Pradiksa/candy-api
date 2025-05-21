<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldTypes extends Model
{

    protected $table = 'field_types';
    protected $primaryKey = 'field_types_id';
    protected $fillable = [
        'field_types_name',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
