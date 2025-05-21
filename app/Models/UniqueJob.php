<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UniqueJob extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'unique_job';
    protected $primaryKey = 'unique_job_id';
    protected $fillable = [
        'fields_id',
        'projects_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function jobFieldslist()
    {
        // Convert the comma-separated string to an array of category IDs
        $categoryIds = explode(',', $this->attributes['fields_id']);

        // Retrieve the corresponding category names from the Categories model
        $categories = Fields::whereIn('fields_id', $categoryIds)
            ->select('fields_id', 'field_name')
            ->get();

        return $categories;
    }

}
