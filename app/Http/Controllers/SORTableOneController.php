<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\SORTableOne;

class SORTableOneController extends Controller
{
    public function __construct(ResponseRepository $response){

        $this->response = $response;
        $this->storeRules = [

            'projects_id'=> 'required',
            'sor_table_task_name' => 'required',
            'sor_table_one_hours' => 'required',
            'sor_table_one_percentage' => 'required',
        ];
    }

    public function indexSORTableOne() {
        return $this->response->jsonResponse(false,"SORTable Detail Fetched Successfully",  SORTableOne::orderBy('sor_table_one_id', 'desc')->get(), 300);
    }

    public function getActiveAllSORTableOne() {
        return $this->response->jsonResponse(false,"SORTable Detail Fetched Successfully",  SORTableOne::where('active_status',1)->orderBy('sor_table_one_id', 'desc')->get() , 300);
    }

    public function getActiveAllSORTableOneproj() {
        return $this->response->jsonResponse(false,"SORTable Detail Fetched Successfully",  SORTableOne::where('active_status',1)->orderBy('sor_table_one_id', 'desc')->get((['projects_id', 'sor_table_task_name'])) , 300);
    }


    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('SORTable', 'store'), SORTableOne::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('SORTable', 'show'), $this->findSORTableOne($id), 302);
    }

    public function updateSORTableOne(Request $request) {
        $validate = $this->response->validate($request->all(), [

            'sor_table_task_name' => ['required'],
            'sor_table_one_hours' => ['required'],
            'sor_table_one_percentage' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('SORTable', 'update'), $this->findSORTableOne($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findSORTableOne($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('SORTable', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'SORTable Not Exists', [], 305);
    }

    public function findSORTableOne($id) {
        return SORTableOne::find($id);
    }

    public function sorTableOneSwitch($id) {
        $size = $this->findPriorityTaskTable($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'SORTable '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'SORTable Not Exists', [], 307);
    }

    public function searchSORTableOne($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('SORTable', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('SORTable', 'search'), SORTableOne::where('sor_table_task_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }



}
