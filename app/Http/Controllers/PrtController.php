<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Prt;
use App\Repositories\ResponseRepository;

class PrtController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'prt_date' => 'required',
            'prt_percentage' => 'required',
        ];
    }

    public function indexPrt() {
        return $this->response->jsonResponse(false," Prt Details Fetched Successfully", Prt::orderBy('prt_id', 'desc')->get(), 300);
    }
    public function getActiveAllPrt() {
        return $this->response->jsonResponse(false,"Prt Detail Fetched Successfully",  Prt::where('active_status',1)->orderBy('prt_id', 'desc')->get() , 300);
    }
    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Prt', 'store'), Prt::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Prt', 'show'), $this->findPrt($id), 302);
    }

    public function updatePrt(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'prt_date' => 'nullable',
            'prt_percentage' => ['required'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Prt', 'update'), $this->findPrt($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findPrt($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Prt', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Prt Not Exists', [], 305);
    }

    public function findPrt($id) {
        return Prt::find($id);
    }

    public function prtSwitch($id) {
        $size = $this->findPrt($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Prt '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Prt Not Exists', [], 307);
    }

    public function searchPrt($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Prt', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Prt', 'search'), Prt::where('prt_date', 'LIKE', '%'.$search.'%')->get(), 911);
    }

}
