<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\AddFieldType;
use App\Repositories\ResponseRepository;

class AddFieldTypeController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'add_field_type' => 'required',
        ];
    }
    public function indexAddFields() {
        return $this->response->jsonResponse(false," Fields Details Fetched Successfully", AddFieldType::orderBy('add_fields_id', 'desc')->get(), 300);

    }


    public function getActiveAddFieldType() {
        return $this->response->jsonResponse(false,"Fields Detail Fetched Successfully",  AddFieldType::where('active_status',1)->orderBy('add_fields_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Fields Detail', 'store'), AddFieldType::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Fields Detail', 'show'), $this->findAddFieldType($id), 302);
    }

    public function updateAddFieldType(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'add_field_type' => 'required',

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Fields Detail', 'update'), $this->findAddFieldType($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findAddFieldType($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Fields Detail', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Fields Detail Not Exists', [], 305);
    }

    public function findAddFieldType($id) {
        return AddFieldType::find($id);
    }

    public function addFieldTypeSwitch($id) {
        $size = $this->findAddFieldType($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Fields Detail '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Fields Detail Not Exists', [], 307);
    }

    public function searchAddFieldType($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Fields Detail', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Fields Detail', 'search'), AddFieldType::where('add_field_type', 'LIKE', '%'.$search.'%')->get(), 911);
    }


}
