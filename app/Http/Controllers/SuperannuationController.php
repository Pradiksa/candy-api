<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use App\Models\Category;
use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\Superannuation;

class SuperannuationController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'from_date' => 'nullable',
            'to_date' => 'nullable',
            'percent_value' => 'required',
        ];
    }

    public function indexSuperannuation() {
        return $this->response->jsonResponse(false,"Superannuation Detail Fetched Successfully",  Superannuation::orderBy('superannuation_id', 'desc')->get() , 300);
    }
    public function getActiveAllSuperannuation() {
        return $this->response->jsonResponse(false,"Superannuation Detail Fetched Successfully",  Superannuation::where('active_status',1)->orderBy('superannuation_id', 'desc')->get() , 300);
    }

    // public function store(Request $request) {
    //     $validate = $this->response->validate($request->all(), $this->storeRules);
    //     if ($validate === true) {
    //         $request['year'] = $this->response->generateSlug($request['to_date']);

    //         // Extract year from date
    //         $date = $request['date'];  // Assuming 'date' is the key for the date value
    //         $year = date('Y', strtotime($date));
    //         $request['year'] = $year;

    //         return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'store'), Superannuation::create($request->all()), 301);
    //     } else {
    //         return $validate;
    //     }
    // }

    // public function store(Request $request) {
    //     $validate = $this->response->validate($request->all(), $this->storeRules);
    //     if ($validate === true) {
    //         $request['year'] = $this->response->generateSlug($request['to_date']);

    //         // Extract year from date
    //         $date = $request['date'];  // Assuming 'date' is the key for the date value
    //         $dateTime = new \DateTime($date); // Use the fully qualified name
    //         $year = $dateTime->format('Y');
    //         $request['year'] = $year;

    //         return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'store'), Superannuation::create($request->all()), 301);
    //     } else {
    //         return $validate;
    //     }
    // }


    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if ($validate === true) {
            $request['year'] = $this->response->generateSlug($request['to_date']);

            // Extract year from to_date
            $to_date = $request['to_date'];
            $dateTime = new \DateTime($to_date);
            $year = $dateTime->format('Y');
            $request['year'] = $year;

            return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'store'), Superannuation::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'show'), $this->findSuperannuation($id), 302);
    }

    // public function updateSuperannuation(Request $request) {
    //     $validate = $this->response->validate($request->all(), $this->storeRules);
    //     if ($validate === true) {
    //         $request['year'] = $this->response->generateSlug($request['to_date']);

    //         // Extract year from date
    //         $date = $request['date'];  // Assuming 'date' is the key for the date value
    //         $year = date('Y', strtotime($date));
    //         $request['year'] = $year;

    //         $category = $this->findSuperannuation($request->superannuation_id);
    //         $category->update($request->all());

    //         return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'update'), $category, 303);
    //     } else {
    //         return $validate;
    //     }
    // }

    public function updateSuperannuation(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if ($validate === true) {
            $request['year'] = $this->response->generateSlug($request['to_date']);

            // Extract year from date
            $date = $request['from_date'];  // Assuming 'from_date' is the key for the date value
            $dateTime = new \DateTime($date);
            $year = $dateTime->format('Y');
            $request['year'] = $year;

            $superannuation = $this->findSuperannuation($request->id);
            if ($superannuation) {
                $superannuation->update($request->all());
                return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'update'), $superannuation, 303);
            } else {
                return $this->response->jsonResponse(true, 'Superannuation not found', null, 404);
            }
        } else {
            return $validate;
        }
    }





    public function destroy($id) {
        $size = $this->findSuperannuation($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Superannuation Not Exists', [], 305);
    }

    public function findSuperannuation($id) {
        return Superannuation::find($id);
    }

    public function superannuationSwitch($id) {
        $size = $this->findSuperannuation($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Superannuation '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Superannuation Not Exists', [], 307);
    }


    public function searchSuperannuation($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Superannuation', 'search'), Superannuation::where('from_date', 'LIKE', '%'.$search.'%')->get(), 911);
    }



}
