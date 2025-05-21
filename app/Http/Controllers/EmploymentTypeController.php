<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\EmploymentType;
use App\Repositories\ResponseRepository;
class EmploymentTypeController extends Controller
{
    //

    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'employement_type_name' => 'required',
        ];
    }

    public function indexEmploymentType() {
        return $this->response->jsonResponse(false," EmploymentType Details Fetched Successfully", EmploymentType::orderBy('employement_type_id', 'desc')->get(), 300);
    }

    public function getActiveAllEmployeetype() {
        return $this->response->jsonResponse(false,"EmploymentType Detail Fetched Successfully",  EmploymentType::where('active_status',1)->orderBy('employement_type_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('EmploymentType', 'store'), EmploymentType::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('EmploymentType', 'show'), $this->findEmploymentType($id), 302);
    }

    public function updateEmploymentType(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'employement_type_name' => 'required',

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('employement_type_name', 'update'), $this->findEmploymentType($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findEmploymentType($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('EmploymentType', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'EmploymentType Not Exists', [], 305);
    }

    public function findEmploymentType($id) {
        return EmploymentType::find($id);
    }

    public function employmentTypeSwitch($id) {
        $size = $this->findEmploymentType($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'EmploymentType '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'EmploymentType Not Exists', [], 307);
    }

    public function searchEmploymentType($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('EmploymentType', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('EmploymentType', 'search'), EmploymentType::where('employement_type_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }
}
