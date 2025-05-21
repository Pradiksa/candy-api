<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Repositories\ResponseRepository;

class RolesController extends Controller
{
    //

    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'role_name' => 'required',
        ];
    }
    public function indexRoles() {
        return $this->response->jsonResponse(false," Roles Details Fetched Successfully", Roles::orderBy('role_id', 'desc')->get(), 300);
    }

    public function getActiveAllroles() {
        return $this->response->jsonResponse(false,"Roles Detail Fetched Successfully",  Roles::where('active_status',1)->orderBy('role_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Roles', 'store'), Roles::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Roles', 'show'), $this->findRoles($id), 302);
    }

    public function updateRoles(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'role_name' => 'required',

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Roles', 'update'), $this->findRoles($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findRoles($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Roles', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Roles Not Exists', [], 305);
    }

    public function findRoles($id) {
        return Roles::find($id);
    }

    public function rolesSwitch($id) {
        $size = $this->findRoles($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Roles '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Roles Not Exists', [], 307);
    }

    public function searchRoles($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Roles', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Roles', 'search'), Roles::where('role_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}

