<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Contractors;
use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\SORTableTwo;

class SORTableTwoController extends Controller
{
    public function __construct(ResponseRepository $response){

        $this->response = $response;
        $this->storeRules = [
            'projects_id'=> 'required',
            'contactor_id' => 'required',
            'sor_table_two_code' => 'required',
            'sor_table_two_description' => 'required',
            'sor_table_two_qunatity' => 'required',
            'sor_table_two_hours' => 'required',
            'sor_table_two_stc_cost' => 'required',
            'sor_table_two_emp_cost' => 'required',
            'contractor_cost' => 'required',
        ];
    }

    public function indexSORTableTwo() {
        return $this->response->jsonResponse(false,"SORTableTwo Detail Fetched Successfully",  SORTableTwo::with('contractorlist')->orderBy('sor_table_two_id', 'desc')->get() , 300);
    }

    public function getActiveAllSORTableTwo() {
        return $this->response->jsonResponse(false,"SORTableTwo Detail Fetched Successfully",  SORTableTwo::where('active_status',1)->orderBy('sor_table_two_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('SORTableTwo', 'store'), SORTableTwo::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('SORTableTwo', 'show'), $this->findSORTableTwo($id), 302);
    }

    public function updateSORTableTwo(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'sor_table_two_code' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('SORTableTwo', 'update'), $this->findSORTableTwo($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findSORTableTwo($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('SORTableTwo', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'SORTableTwo Not Exists', [], 305);
    }

    public function findSORTableTwo($id) {
        return SORTableTwo::find($id);
    }

    public function sorTableTwoSwitch($id) {
        $size = $this->findSORTableTwo($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'SORTableTwo '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'SORTableTwo Not Exists', [], 307);
    }

    public function searchSORTableTwo($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('SORTableTwo', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('SORTableTwo', 'search'), SORTableTwo::where('sor_table_two_code', 'LIKE', '%'.$search.'%')->get(), 911);
    }





}
