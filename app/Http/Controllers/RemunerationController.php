<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\EmploymentType;
use App\Models\Superannuation;
use App\Models\Prt;

use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\Remuneration;

class RemunerationController extends Controller
{
    public function __construct(ResponseRepository $response){

        $this->response = $response;
        $this->storeRules = [
             'remuneration_date' => 'required',
            'employement_type_id' => 'required',
            'employement_type_name' => 'required',
             'gross_pay' => 'required',
            'superannuation_id' => 'required',
            'percent_value' => 'required',
            'prt_id' => 'required',
            'prt_percentage' => 'required',
            'annual_djc' => 'required',
            'day_djc' => 'required',
            'hr_djc' => 'required',
            'employee_id'=> 'required',
        ];
    }

    public function indexRemuneration() {
        return $this->response->jsonResponse(false,"Remuneration Detail Fetched Successfully",  Remuneration::with('employementtypelist','employmenttypname','superannuationtypelist','superannuationtypname','prttypelist','prttypname')->orderBy('remuneration_id', 'desc')->get() , 300);
    }

    public function indexlistall() {
        return $this->response->jsonResponse(false,"Remuneration Detail Fetched Successfully",  Remuneration::with('listalls')->orderBy('remuneration_id', 'desc')->get() , 300);
    }


    public function getActiveAllRemuneration() {
        return $this->response->jsonResponse(false,"Remuneration Detail Fetched Successfully",  Remuneration::where('active_status',1)->orderBy('remuneration_id', 'desc')->get() , 300);
    }

    public function getRemunerationid($remuneration_id) {
        return $this->response->jsonResponse(false, 'Remuneration Details Fetched SuccessFully', Remuneration::where('remuneration_id', $remuneration_id)->with('employementtypelist')->first(), 201);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Remuneration', 'store'), Remuneration::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Remuneration', 'show'), $this->findRemuneration($id), 302);
    }

    public function updateRemuneration(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'gross_pay' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Remuneration', 'update'), $this->findRemuneration($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findRemuneration($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Remuneration', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Remuneration Not Exists', [], 305);
    }

    public function findRemuneration($id) {
        return Remuneration::find($id);
    }

    public function remunerationSwitch($id) {
        $size = $this->findRemuneration($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Remuneration '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Remuneration Not Exists', [], 307);
    }

    public function searchRemuneration($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Remuneration', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Remuneration', 'search'), Remuneration::where('employement_type_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}
