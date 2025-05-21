<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\FieldTypes;
use App\Repositories\ResponseRepository;

class FieldTypesController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'field_types_name' => 'required',
        ];
    }

    public function indexFieldTypes() {
        return $this->response->jsonResponse(false," FieldTypes Details Fetched Successfully", FieldTypes::orderBy('field_types_id', 'desc')->get(), 300);
    }

    public function getActiveFieldTypes() {
        return $this->response->jsonResponse(false,"FieldTypes Detail Fetched Successfully",  FieldTypes::where('active_status',1)->orderBy('field_types_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('FieldTypes', 'store'), FieldTypes::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('FieldTypes', 'show'), $this->findFieldTypes($id), 302);
    }

    public function updateFieldTypes(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'field_types_name' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('FieldTypes', 'update'), $this->findFieldTypes($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findFieldTypes($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('FieldTypes', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'FieldTypes Not Exists', [], 305);
    }

    public function findFieldTypes($id) {
        return FieldTypes::find($id);
    }

    public function fieldTypesSwitch($id) {
        $size = $this->findFieldTypes($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'FieldTypes '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'FieldTypes Not Exists', [], 307);
    }

    public function searchFieldTypes($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('FieldTypes', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('FieldTypes', 'search'), FieldTypes::where('field_types_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}
