<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Services;
use App\Models\Clients;
use App\Models\CostType;

use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\EmployeeProject;


class EmployeeProjectController extends Controller
{
    public function __construct(ResponseRepository $response){

        $this->response = $response;
        $this->storeRules = [
             'employee_id' => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'projects_id' => 'required',
             'project_name' => 'required',
            'client_id' => 'required',
            'client_name' => 'required',
            'role_id' => 'required',
            'role_name' => 'required',

            'employement_type_id' => 'required',
            'employement_type_name' => 'required',
            'emp_project_date' => 'required',
            'emp_project_end_date' => 'required',

            // 'contract_name_four' => 'required',
            // 'contactor_cost_four' => 'required',
            // 'contract_name_five' => 'required',
            // 'contactor_cost_five' => 'required',

            // 'contract_name_six' => 'required',
            // 'contactor_cost_six' => 'required',

        ];
    }

    public function indexEmployeeProject() {
        return $this->response->jsonResponse(false," Project Detail Fetched Successfully", EmployeeProject::where('active_status',1)->orderBy('emp_project_id', 'desc')->get() , 300);
        // return $this->response->jsonResponse(false,"Project Detail Fetched Successfully",  EmployeeProject::where('active_status',1)->orderBy('emp_project_id', 'desc')->get() , 300);
    }



    public function getActiveAllEmployeeProject() {
        return $this->response->jsonResponse(false,"Project Detail Fetched Successfully",  EmployeeProject::where('active_status',1)->orderBy('emp_project_id', 'desc')->get() , 300);
    }

    public function getProjectId($projects_id) {
        return $this->response->jsonResponse(false, 'Project id Details Fetched SuccessFully', EmployeeProject::where('projects_id', $projects_id)->orderBy('emp_project_id', 'desc')->get() , 300);
    }


    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Projects', 'store'), EmployeeProject::create($request->all()), 301);
        }else {
            return $validate;
        }
    }


    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Projects', 'show'), $this->findProjects($id), 302);
    }

    public function updateProjects(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'project_name' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Projects', 'update'), $this->findProjects($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findProjects($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Projects', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Projects Not Exists', [], 305);
    }
    public function findProjects($id) {
        return EmployeeProject::find($id);
    }

    public function employeeProjectSwitch($id) {
        $size = $this->findProjects($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Projects '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Projects Not Exists', [], 307);
    }

    public function employeeProjectSearch($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Projects', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Projects', 'search'), EmployeeProject::where('project_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}
