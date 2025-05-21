<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserTypes;
use App\Repositories\ResponseRepository;
use Illuminate\Support\Facades\Log;

class UserTypesController extends Controller
{
    public function __construct(ResponseRepository $response) {
        $this->response = $response;
        $this->storeRules = ['type_name' => 'required',];
    }

    public function indexUserTypes() {
        return $this->response->jsonResponse(false,"User Types Details Fetched Successfully", UserTypes::orderBy('id', 'desc')->get(), 900);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('User Types Details', 'store'), UserTypes::create($request->all()), 901);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('User Types Details', 'show'), $this->findUserTypes($id), 902);
    }

    public function updateUserTypes(Request $request) {
        $validate = $this->response->validate($request->all(), ['type_name' => ['required' ]]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('User Types Details', 'update'), $this->findUserTypes($request->id)->update($request->all()), 903);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findUserTypes($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('User Types Details', 'destroy'), $size->delete(), 904);
        }
        return $this->response->jsonResponse(true, 'User Types Details Not Exists', [], 905);
    }

    public function findUserTypes($id) {
        return UserTypes::find($id);
    }

    public function getActiveUserTypes() {
        return $this->response->jsonResponse(false, "User Types Details Fetched Successfully", UserTypes::where('active_status', 1)->orderBy('id', 'desc')->get(), 906);
    }

    public function userTypesSwitch($id) {
        $size = $this->findUserTypes($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'User Types Details '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 908);
        }
        return $this->response->jsonResponse(true, 'User Types Details Not Exists', [], 909);
    }

    public function searchUserTypes($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Banner', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Banner', 'search'), UserTypes::where('type_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }
}
