<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clients;
class Projects extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'projects';
    protected $primaryKey = 'projects_id';
    protected $fillable = [
        'service_id',
        'client_id',
         'cost_type_id',
        'project_name',
        'active_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    // public function getClientAttribute($value)
    // {
    //     $clients = [];
    //     if( strpos($value, ',') !== false ) {
    //         // return explode(',', $value);
    //         foreach(explode(',', $value) as $client_id) {
    //             array_push($clients, ['id' => (int)$client_id, 'itemName' => Clients::find($client_id)->client_name]);
    //         }
    //     } elseif ($value) {
    //         array_push($clients, ['id' => (int)$value, 'itemName' => Clients::find($value)->client_name]);
    //     }
    //     return $clients;
    // }
    public function clientlist()
    {
        // Convert the comma-separated string to an array of category IDs
        $categoryIds = explode(',', $this->attributes['client_id']);

        // Retrieve the corresponding category names from the Categories model
        $categories = Clients::whereIn('client_id', $categoryIds)
            ->select('client_id', 'client_name')
            ->get();

        return $categories;
    }



    public function serviceslist() {
        return $this->hasMany('App\Models\Services', 'service_id', 'service_id');
    }
    // public function allProj() {
    //     return $this->hasMany('App\Models\Clients', 'client_id', 'client_id');
    // }

    // public function clientslist() {
    //     return $this->hasMany('App\Models\Clients', 'client_id', 'client_id');
    // }

    public function costtypelist() {
        return $this->hasMany('App\Models\CostType', 'cost_type_id', 'cost_type_id');
    }


    public function clienttypname() {
        return $this->hasOne('App\Models\Clients', 'client_id', 'client_id')->select('client_id', 'client_name');
    }

    public function costtypname() {
        return $this->hasOne('App\Models\CostType', 'cost_type_id', 'cost_type_id')->select('cost_type_id', 'cost_type_name');
    }

    public function projectname() {
        return $this->hasOne('App\Models\Projects', 'projects_id', 'projects_id')->select('projects_id', 'project_name');
    }
    // public function serviceslist() {
    //     return $this->hasOne('App\Models\Services', 'service_id', 'service_id')->select('service_id', 'service_name');
    // }

        // public function servicesList() {
    //     return $this->hasMany('App\Models\Services', 'service_id', 'service_id')->where('active_status', 1)->orderBy('service_id', 'desc');
    // }

    // public function clientList() {
    //     return $this->hasMany('App\Models\Clients', 'client_id', 'client_id')->where('active_status', 1)->orderBy('client_id', 'desc');
    // }

    // public function costTypeList() {
    //     return $this->hasMany('App\Models\CostType', 'cost_type_id', 'cost_type_id')->where('active_status', 1)->orderBy('cost_type_id', 'desc');
    // }
}




