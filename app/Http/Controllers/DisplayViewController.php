<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\DisplayView;
use App\Repositories\ResponseRepository;

class DisplayViewController extends Controller
{
    //

    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'display_view_name' => 'required',
        ];
    }

    public function indexDisplayView() {
        return $this->response->jsonResponse(false," DisplayView Details Fetched Successfully", DisplayView::orderBy('display_view_id', 'desc')->get(), 300);
    }
    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('DisplayView', 'store'), DisplayView::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('DisplayView', 'show'), $this->findDisplayView($id), 302);
    }

    public function updateDisplayView(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'display_view_name' => 'required',
          
        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('DisplayView', 'update'), $this->findDisplayView($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findDisplayView($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('DisplayView', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'DisplayView Not Exists', [], 305);
    }

    public function findDisplayView($id) {
        return DisplayView::find($id);
    }

    public function displayViewSwitch($id) {
        $size = $this->findDisplayView($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'DisplayView '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'DisplayView Not Exists', [], 307);
    }

    public function searchDisplayView($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('DisplayView', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('DisplayView', 'search'), DisplayView::where('display_view_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }



}
