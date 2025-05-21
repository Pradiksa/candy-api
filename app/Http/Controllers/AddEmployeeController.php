<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\AddEmployee;
use App\Repositories\ResponseRepository;

class AddEmployeeController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'nick_name' => 'required',
            'user_id' => 'required',
            'mobile_no' => 'required',
            'title' => 'required',
            'password' => 'required',
        ];
    }

    public function indexAddEmployee() {
        return $this->response->jsonResponse(false," Employee Details Fetched Successfully", AddEmployee::orderBy('employee_id', 'desc')->get(), 300);
    }

    public function getremunerationList() {
        return $this->response->jsonResponse(false," Remuneration Detail Fetched Successfully", AddEmployee::with('remunerationlist')->orderBy('employee_id', 'desc')->get() , 300);
    }

    public function getEmployeeProjectList() {
        return $this->response->jsonResponse(false," Employee Projects Detail Fetched Successfully", AddEmployee::with('employeeProjectlist')->orderBy('employee_id', 'desc')->get() , 300);
    }

    public function getActiveAddEmployee() {
        return $this->response->jsonResponse(false,"Employee Detail Fetched Successfully",  AddEmployee::where('active_status',1)->orderBy('employee_id', 'desc')->get() , 300);
    }


    public function getEmployeeId($employee_id) {
        return $this->response->jsonResponse(false, 'Employee Details Fetched SuccessFully', AddEmployee::where('employee_id', $employee_id)->with('remunerationlist')->first(), 201);
    }


    public function getEmployeeName() {
        return $this->response->jsonResponse(false,"Employee Detail Fetched Successfully",  AddEmployee::where('active_status', 1)->orderBy('employee_id', 'desc')->pluck('first_name'), 300);
    }

    // public function store(Request $request) {
    //     $validate = $this->response->validate($request->all(), $this->storeRules);
    //     if($validate === true) {
    //         return $this->response->jsonResponse(false, $this->response->message('Employee', 'store'), AddEmployee::create($request->all()), 301);
    //     } else {
    //         return $validate;
    //     }
    // }
    public function store(Request $request)
    {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if ($validate === true) {
            if ($request->hasFile('emp_image')) {
                $uploadUrl = $this->response->cloudinaryImage($request->file('emp_image'), 'employeimage', 'emp_image');
                $data = $request->all();
                $data['emp_image'] = $uploadUrl;
                $request->merge(['emp_image' => $uploadUrl]);
                return $this->response->jsonResponse(false, $this->response->message('Employee', 'store'), AddEmployee::create($data), 301);
            } else {
                return $this->response->jsonResponse(true, 'Image not found', [], 203);
            }
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Employee', 'show'), $this->findAddEmployee($id), 302);
    }

    public function updateAddEmployee(Request $request)
    {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if ($validate === true) {
            if ($request->hasFile('emp_image')) {
                $uploadUrl = $this->response->cloudinaryImage($request->file('emp_image'), 'employeimage', 'emp_image');
                $data = $request->all();
                $data['emp_image'] = $uploadUrl;
                $request->merge(['emp_image' => $uploadUrl]);
                return $this->response->jsonResponse(false, $this->response->message('Employee', 'update'), $this->findAddEmployee($request->id)->update($request->all()), 303);
            } else {
                return $this->response->jsonResponse(true, 'Image not found', [], 203);
            }
        } else {
            return $validate;
        }
    }



    // public function updateAddEmployee(Request $request) {
    //     $validate = $this->response->validate($request->all(), [
    //         'emp_image' => ['required'],

    //     ]);
    //     if($validate === true) {
    //         return $this->response->jsonResponse(false, $this->response->message('Projects', 'update'), $this->findAddEmployee($request->id)->update($request->all()), 303);
    //     } else {
    //         return $validate;
    //     }
    // }

    // public function updateAddEmployee(Request $request) {
    //     $validate = $this->response->validate($request->all(), $this->storeRules); 
    //     if ($validate === true) {
    //         if ($request->hasFile('emp_image')) {
    //             $uploadUrl = $this->response->cloudinaryImage($request->file('emp_image'), 'employeimage', 'emp_image');
    //             $data = $request->all();
    //             $data['emp_image'] = $uploadUrl;
    //             $request->merge(['emp_image' => $uploadUrl]);
    //             return $this->response->jsonResponse(false, $this->response->message('Employee', 'update'), $this->findAddEmployee($request->id)->update($request->all()), 303);
    //         } else {
    //             return $this->response->jsonResponse(true, 'Image not found', [], 203);
    //         }
    //     } else {
    //         return $validate;
    //     }
    //     // if($validate === true) {
    //     //     return $this->response->jsonResponse(false, $this->response->message('Employee', 'update'), $this->findAddEmployee($request->id)->update($request->all()), 303);
    //     // } else {
    //     //     return $validate;
    //     // }
    // }
    public function destroy($id) {
        $size = $this->findAddEmployee($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Employee', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Employee Not Exists', [], 305);
    }

    public function findAddEmployee($id) {
        return AddEmployee::find($id);
    }

    public function addEmployeeSwitch($id) {
        $size = $this->findAddEmployee($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Employee '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Employee Not Exists', [], 307);
    }

    public function searchAddEmployee($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Employee', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Employee', 'search'), AddEmployee::where('first_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }


}
