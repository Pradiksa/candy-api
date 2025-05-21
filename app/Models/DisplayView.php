<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DisplayView extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
   protected $table = 'display_view';
   protected $primaryKey = 'display_view_id';
   protected $fillable = [
       'display_view_name',
       'active_status',
   ];
   protected $hidden = [
       'created_at',
       'updated_at',
       'deleted_at'
   ];

}
