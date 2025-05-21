<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\FieldsTask;

use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\TaskField;

class TaskFieldController extends Controller
{
    //
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'field_task_id' => 'required',
            // 'field_task_name' => 'required',
            'field_name' => 'required',
        ];
    }

    public function indexTaskField() {
        return $this->response->jsonResponse(false,"TaskField Detail Fetched Successfully",  TaskField::with('fieldsTasklist','fieldsTaskType')->orderBy('task_field_id', 'desc')->get() , 300);
    }

    public function getActiveAllTaskField() {
        return $this->response->jsonResponse(false,"TaskField Detail Fetched Successfully",  TaskField::where('active_status',1)->orderBy('task_field_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('TaskField', 'store'), TaskField::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('TaskField', 'show'), $this->findTaskField($id), 302);
    }

    // public function updateTaskField(Request $request) {
    //     $validate = $this->response->validate($request->all(), [
    //         'field_name' => ['required'],
    //         'field_task_id' => ['required'],
    //         'field_task_name' => ['required'],

    //     ]);
    //     if($validate === true) {
    //         return $this->response->jsonResponse(false, $this->response->message('TaskField', 'update'), $this->findTaskField($request->id)->update($request->all()), 303);
    //     } else {
    //         return $validate;
    //     }
    // }

    public function updateTaskField(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'field_name' => 'required',

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('TaskField', 'update'), $this->findTaskField($request->task_field_id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }



    public function destroy($id) {
        $size = $this->findTaskField($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('TaskField', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'TaskField Not Exists', [], 305);
    }

    public function findTaskField($id) {
        return TaskField::find($id);
    }

    public function taskFieldSwitch($id) {
        $size = $this->findTaskField($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'TaskField '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'TaskField Not Exists', [], 307);
    }



    public function searchTaskField($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('TaskField', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('TaskField', 'search'), TaskField::where('field_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}
