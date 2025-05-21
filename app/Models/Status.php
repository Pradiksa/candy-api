<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
   protected $table = 'status';
   protected $primaryKey = 'status_id';
   protected $fillable = [
       'status_name',
       'active_status',
   ];
   protected $hidden = [
       'created_at',
       'updated_at',
       'deleted_at'
   ];
}
