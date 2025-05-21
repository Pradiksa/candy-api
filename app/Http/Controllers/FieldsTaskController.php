<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\FieldsTask;
use App\Repositories\ResponseRepository;

class FieldsTaskController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'field_task_name' => 'required',
        ];
    }

    public function indexFieldsTask() {
        return $this->response->jsonResponse(false," FieldsTask Details Fetched Successfully", FieldsTask::orderBy('field_task_id', 'desc')->get(), 300);
    }
    public function getActiveFieldsTask() {
        return $this->response->jsonResponse(false,"FieldsTask Detail Fetched Successfully",  FieldsTask::where('active_status',1)->orderBy('field_task_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('FieldsTask', 'store'), FieldsTask::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('FieldsTask', 'show'), $this->findFieldsTask($id), 302);
    }

    public function updateFieldsTask(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'field_task_name' => 'required',
          
        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('FieldsTask', 'update'), $this->findFieldsTask($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findFieldsTask($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('FieldsTask', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'FieldsTask Not Exists', [], 305);
    }

    public function findFieldsTask($id) {
        return FieldsTask::find($id);
    }

    public function fieldsTaskSwitch($id) {
        $size = $this->findFieldsTask($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'FieldsTask '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'FieldsTask Not Exists', [], 307);
    }

    public function searchFieldsTask($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('FieldsTask', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('FieldsTask', 'search'), FieldsTask::where('field_task_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}
