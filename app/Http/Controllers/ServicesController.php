<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Repositories\ResponseRepository;

class ServicesController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'service_name' => 'required',
        ];
    }
    public function indexServices() {
        return $this->response->jsonResponse(false," Services Details Fetched Successfully", Services::orderBy('service_id', 'desc')->get(), 300);
    }

    public function getActiveServices() {
        return $this->response->jsonResponse(false,"Services Detail Fetched Successfully",  Services::where('active_status',1)->orderBy('service_id', 'desc')->get() , 300);
    }
    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Services', 'store'), Services::create($request->all()), 301);
        } else {
            return $validate;
        }
    }
    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Services', 'show'), $this->findServices($id), 302);
    }

    public function updateServices(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'service_name' => 'required'

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Services', 'update'), $this->findServices($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findServices($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Services', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Services Not Exists', [], 305);
    }
    public function findServices($id) {
        return Services::find($id);
    }

    public function servicesSwitch($id) {
        $size = $this->findServices($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Services '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Services Not Exists', [], 307);
    }


    public function searchServices($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Services', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Services', 'search'), Services::where('service_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }





}
