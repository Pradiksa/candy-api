<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'roles';
   protected $primaryKey = 'role_id';
   protected $fillable = [
       'role_name',
       'active_status',
   ];
   protected $hidden = [
       'created_at',
       'updated_at',
       'deleted_at'
   ];
}
