<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Repositories\ResponseRepository;

class StatusController extends Controller
{
    //

    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'status_name' => 'required',
        ];
    }

    public function indexStatus() {
        return $this->response->jsonResponse(false," Status Details Fetched Successfully", Status::orderBy('status_id', 'desc')->get(), 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Status', 'store'), Status::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Status', 'show'), $this->findStatus($id), 302);
    }

    public function updateStatus(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'status_name' => 'required',
          
        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Status', 'update'), $this->findStatus($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findStatus($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Status', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Status Not Exists', [], 305);
    }

    public function findStatus($id) {
        return Status::find($id);
    }

    public function statusSwitch($id) {
        $size = $this->findStatus($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Status '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Status Not Exists', [], 307);
    }

    public function searchStatus($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Status', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Status', 'search'), Status::where('status_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }
}
