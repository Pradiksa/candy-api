<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\CostType;
use App\Models\Clients;
use App\Models\Projects;
use App\Models\AddTask;

use App\Repositories\ResponseRepository;

class AddTaskController extends Controller
{
    public function __construct(ResponseRepository $response){

        $this->response = $response;
        $this->storeRules = [
            'projects_id' => 'required',
            'project_name'=> 'required',
            'client_id' => 'required',
            'client_name' => 'required',
            'cost_type_id' => 'required',
            'cost_type_name' => 'required',
            'task_date' => 'required',
        ];


    }

    // public function indexTaskadd() {

    //     return $this->response->jsonResponse(false,"TaskTables Detail Fetched Successfully",  AddTask::with('tasks')->orderBy('task_id', 'desc')->get() , 300);

    // }
    // return $this->response->jsonResponse(false,"Task Detail Fetched Successfully",  AddTask::with('projectlist','clientslist','costtypelist','clienttypname','costtypname','projectname')->orderBy('task_id', 'desc')->get() , 300);

        // return $this->response->jsonResponse(false,"Task Detail Fetched Successfully",  AddTask::where('active_status',1)->orderBy('task_id', 'desc')->get() , 300);

        // public function indexTaskadd()
        // {
        //     $addTasks = AddTask::with(['tasks' => function ($query) {
        //         $query->where('cost_type_name', 'fixed');
        //     }])
        //         ->orderBy('task_id', 'desc')
        //         ->get();

        //     return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully", $addTasks, 300);
        // }
        // public function indexTaskadd()
        // {
        //     $addTasks = AddTask::whereHas('tasks', function ($query) {
        //         $query->where('cost_type_name', 'fixed');
        //     })
        //     ->orderBy('task_id', 'desc')
        //     ->get();

        //     return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully", $addTasks, 300);
        // }
        public function indexTaskadd()
        {
        $addTasks = AddTask::where('cost_type_name', 'fixed')
        ->with('tasks')
        ->orderBy('task_id', 'desc')
        ->get();

            return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully", $addTasks, 300);
        }

        public function getSORdetails()
        {
        $sortask = AddTask::where('cost_type_name', 'SOR')
        ->with('tasksorone','tasksortwo')
        ->orderBy('task_id', 'desc')
        ->get();

            return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully", $sortask, 300);
        }






    public function getprojectalldetils() {
        return $this->response->jsonResponse(false,"Projects Detail Fetched Successfully",  Projects::with('serviceslist','clientslist','costtypelist',)->orderBy('projects_id', 'desc')->get() , 300);
    }


    public function getActiveAllTask() {
        return $this->response->jsonResponse(false,"Task Detail Fetched Successfully",  AddTask::where('active_status',1)->orderBy('task_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Task', 'store'), AddTask::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Task', 'show'), $this->findTask($id), 302);
    }

    public function updateTask(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'task_date' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Task', 'update'), $this->findTask($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findTask($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Task', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Task Not Exists', [], 305);
    }

    public function findTask($id) {
        return AddTask::find($id);
    }

    public function taskSwitch($id) {
        $size = $this->findTask($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Task '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Task Not Exists', [], 307);
    }

    public function searchTask($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Task', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Task', 'search'), AddTask::where('task_date', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}
