<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ResponseRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'user_type_id'=> 'required',
            'user_name' => 'required|unique:users,user_name,NULL,id',
            'password' => 'required',
        ];
    }

    public function indexUser(){
        return $this->response->jsonResponse(false, $this->response->message('User', 'index'), User::with('usertypes')->orderby('id','desc')->get(), 200);
    }

    public function store(Request $request){
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            $input = $request->all();
            // Log::info('input =='. $request);
            $input['password'] = Hash::make($input['password']);
            return $this->response->jsonResponse(false, $this->response->message('User', 'store'), User::create($input), 200);
        } else {
            return $validate;
        }
    }

    public function show($id){
        return $this->response->jsonResponse(false, $this->response->message('User', 'show'), $this->findUser($id), 200);
    }

    public function updateUsers(Request $request){
        $validate = $this->response->validate($request->all(), [
            'user_name' => 'required',
            'user_type_id' => 'required'
        ]);
        if($validate === true) {
            $data = User::where('id', $request->id)->update(
                ['user_type_id'=>$request->user_type_id,'user_name'=>$request->user_name,'user_email'=>$request->user_email,'password'=>\Hash::make($request->password)]
            );
            return $this->response->jsonResponse(false, $this->response->message('User Details', 'update'),$data, 200);
        } else {
            return $validate;
        }
    }

    public function destroy($id){
        $user = $this->findUser($id);
        if($user) {
            return $this->response->jsonResponse(false, $this->response->message('User', 'destroy'), $user->delete(), 200);
        }
            return $this->response->jsonResponse(true, 'User Not Exists',[], 201);
    }

    public function findUser($id){
        return User::with('usertypes')->find($id);
    }

    public function searchUser($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('User', 'search'), [], 200);
        }
        return $this->response->jsonResponse(false, $this->response->message('User', 'search'), User::where('user_name', 'LIKE', '%'.$search.'%')->orWhere('user_email', 'LIKE', '%'.$search.'%')->with('usertypes')->get(), 201);
    }

    public function userSwitch($id){
        $size = $this->findUser($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'User Types Details '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 200);
        }
        return $this->response->jsonResponse(true, 'User Details Not Exists',[], 201);
    }

    public function loginUser(Request $request){
        $user= User::with('usertypes')->where('user_name', $request->user_name)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->response->jsonResponse(true, 'Sorry! Invalid Credentials',[], 201);
        }
        $checkActiveStatus = User::where('user_name', $request->user_name)->select('active_status')->first();
        if ((int)$checkActiveStatus['active_status'] === 1) {
            $user['token'] =  $user->createToken($user)->plainTextToken;
            return $this->response->jsonResponse(false, ucfirst($request->user_name).' Logged in Successfully',$user, 201);
        }
        return $this->response->jsonResponse(true, 'This user has been deactivated',[], 201);
    }

    public function forgotPassword(Request $request) {
        $customer = User::orWhere('user_name', $request->user_name_or_email)->orWhere('user_email', $request->user_name_or_email)->where('active_status', 1)->first();
        // Log::info("reser==== ". $customer);
        if($customer) {
         return $this->response->jsonResponse(false,'Hey '. ucfirst($customer->user_name) .' You Can Change New Password',[], 201);
        }
        return $this->response->jsonResponse(true, 'Invalid User Name Or Email',[], 201);
    }

    public function ResetPassword(Request $request) {
        $customer = User::orWhere('user_name', $request->user_name_or_email)->orWhere('user_email', $request->user_name_or_email)->where('active_status', 1)->first();
        // Log::info("resetcustomer ==== ". $customer);
        if($customer) {
           $data = User::orWhere('user_name', $request->user_name_or_email)->orWhere('user_email', $request->user_name_or_email)->update(['password'=>\Hash::make($request->password)]);
           return $this->response->jsonResponse(false, ucfirst($customer->user_name).' Your Password Is Update Successfully',[], 201);
        }
            return $this->response->jsonResponse(true, 'Invalid User Name Or Email',[], 201);
    }
}
