<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
   protected $table = 'employement_type';
   protected $primaryKey = 'employement_type_id';
   protected $fillable = [
       'employement_type_name',
       'active_status',
   ];
   protected $hidden = [
       'created_at',
       'updated_at',
       'deleted_at'
   ];
}
