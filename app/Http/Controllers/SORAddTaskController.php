<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;
use App\Models\CostType;
use App\Models\Clients;
use App\Models\Projects;
use App\Models\SORAddTask;

class SORAddTaskController extends Controller
{
    public function __construct(ResponseRepository $response){

        $this->response = $response;
        $this->storeRules = [
            'projects_id' => 'required',
            'client_id' => 'required',
            'cost_type_id' => 'required',
            'sor_task_date' => 'required',
        ];
    }

    public function indexSORAddTask() {
        return $this->response->jsonResponse(false,"SORAddTask Detail Fetched Successfully",  SORAddTask::with('projectlist','clientslist','costtypelist')->orderBy('sor_task_id', 'desc')->get() , 300);
    }

    public function getActiveAllSORAddTask() {
        return $this->response->jsonResponse(false,"SORAddTask Detail Fetched Successfully",  SORAddTask::where('active_status',1)->orderBy('sor_task_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('SORAddTask', 'store'), SORAddTask::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('SORAddTask', 'show'), $this->findSORAddTask($id), 302);
    }

    public function updateSORAddTask(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'sor_task_date' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('SORAddTask', 'update'), $this->findSORAddTask($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findSORAddTask($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('SORAddTask', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'SORAddTask Not Exists', [], 305);
    }


    public function findSORAddTask($id) {
        return SORAddTask::find($id);
    }

    public function sorAddTaskSwitch($id) {
        $size = $this->findSORAddTask($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Task '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'SORAddTask Not Exists', [], 307);
    }

    public function searchSORAddTask($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('SORAddTask', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('SORAddTask', 'search'), SORAddTask::where('sor_task_date', 'LIKE', '%'.$search.'%')->get(), 911);
    }




}
