<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Clients;
use App\Repositories\ResponseRepository;

class ClientsController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'client_name' => 'required',
            'client_nick_name' => 'required',
        ];
    }
    public function indexClient() {
        return $this->response->jsonResponse(false," Client Details Fetched Successfully", Clients::orderBy('client_id', 'desc')->get(), 300);
    }

     public function getActiveClients() {
        return $this->response->jsonResponse(false,"Client Detail Fetched Successfully",  Clients::where('active_status',1)->orderBy('client_id', 'desc')->get() , 300);
    }

    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Client', 'store'), Clients::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Client', 'show'), $this->findClients($id), 302);
    }

    public function updateClients(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'client_name' => 'required',
            'client_nick_name' => 'required',
          
        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Client', 'update'), $this->findClients($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findClients($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Client', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Client Not Exists', [], 305);
    }

    public function findClients($id) {
        return Clients::find($id);
    }

    public function searchClients($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Client', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Client', 'search'), Clients::where('client_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }
    public function clientsSwitch($id) {
        $size = $this->findClients($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Client '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Client Not Exists', [], 307);
    }


}
