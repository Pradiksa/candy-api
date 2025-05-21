<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddJobsColumn extends Model
{
    use HasFactory;
    protected $table = 'add_jobs_column';
    protected $primaryKey = 'id';
    protected $fillable = [
        'project_id',
    ];
    protected $casts = ['properties' => 'json'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
