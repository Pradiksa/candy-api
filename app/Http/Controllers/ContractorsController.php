<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Contractors;
use App\Repositories\ResponseRepository;

class ContractorsController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'contract_name' => 'required',
            'contract_nick_name' => 'required',
            'contract_type' => 'required',
        ];
    }

    public function indexContractor() {
        return $this->response->jsonResponse(false," Contractor Details Fetched Successfully", Contractors::orderBy('contactor_id', 'desc')->get(), 300);
    }
    public function getActiveContractors() {
        return $this->response->jsonResponse(false,"Services Detail Fetched Successfully",  Contractors::where('active_status',1)->orderBy('contactor_id', 'desc')->get() , 300);
    }
    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Contractor', 'store'), Contractors::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Contractor', 'show'), $this->findContractors($id), 302);
    }

    public function updateContractors(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'contract_name' => 'required',
            'contract_nick_name' => 'required',
            'contract_type' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Contractor', 'update'), $this->findContractors($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findContractors($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Contractor', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Contractor Not Exists', [], 305);
    }

    public function findContractors($id) {
        return Contractors::find($id);
    }

    public function contractorsSwitch($id) {
        $size = $this->findContractors($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Contractor '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Contractor Not Exists', [], 307);
    }

    public function searchContractors($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Contractors', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Contractors', 'search'), Contractors::where('contract_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}