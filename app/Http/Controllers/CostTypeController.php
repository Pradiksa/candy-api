<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\CostType;
use App\Repositories\ResponseRepository;

class CostTypeController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'cost_type_name' => 'required',
        ];
    }

    public function indexCostType() {
        return $this->response->jsonResponse(false," CostType Details Fetched Successfully", CostType::orderBy('cost_type_id', 'desc')->get(), 300);
    }

    public function getActiveCostType() {
        return $this->response->jsonResponse(false,"CostType Detail Fetched Successfully",  CostType::where('active_status',1)->orderBy('cost_type_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('CostType', 'store'), CostType::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('CostType', 'show'), $this->findCostType($id), 302);
    }

    public function updateCostType(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'cost_type_name' => 'required',
          
        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('CostType', 'update'), $this->findCostType($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findCostType($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('CostType', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'CostType Not Exists', [], 305);
    }

    public function findCostType($id) {
        return CostType::find($id);
    }
    
    public function costTypeSwitch($id) {
        $size = $this->findCostType($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'CostType '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'CostType Not Exists', [], 307);
    }

    public function searchCostType($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('CostType', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('CostType', 'search'), CostType::where('cost_type_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }
}
