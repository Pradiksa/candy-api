<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Prt extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'prt';
    protected $primaryKey = 'prt_id';
    protected $fillable = [
       'prt_date',
       'prt_percentage',
       'active_status',
   ];
   protected $hidden = [
       'created_at',
       'updated_at',
       'deleted_at'
   ];
}
