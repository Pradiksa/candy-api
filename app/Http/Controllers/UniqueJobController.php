<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\UniqueJob;
use App\Repositories\ResponseRepository;

class UniqueJobController extends Controller
{
    public function __construct(ResponseRepository $response){
        $this->response = $response;
        $this->storeRules = [
            'fields_id' => 'required',
            'projects_id' => 'required',

        ];
    }

    public function indexUniqueJob()
    {
        $templates = UniqueJob::orderBy('categories_id', 'desc')->get();

        // Retrieve categories for each template
        foreach ($templates as $template) {
            $template->categories = $template->jobFieldslist();
        }
        return $this->response->jsonResponse(false, "UniqueJob Details Fetched Successfully", $templates, 300);
    }

    public function getActiveUniqueJob() {
        return $this->response->jsonResponse(false,"UniqueJob Detail Fetched Successfully",  UniqueJob::where('active_status',1)->orderBy('unique_job_id', 'desc')->get() , 300);
    }
    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            $data = $request->all();
            log::info($data);
            $data['fields_id'] = implode(',', $data['fields_id']); // Convert array to comma-separated string
            log::info($data);
            return $this->response->jsonResponse(false, $this->response->message('Categories', 'store'), UniqueJob::create($data), 301);
        } else {
            return $validate;
        }
    }
    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('UniqueJob', 'show'), $this->findUniqueJob($id), 302);
    }
    public function findUniqueJob($id) {
        return UniqueJob::find($id);
    }
    public function findUniqueJobes($id)
    {
    $Dish = UniqueJob::find($id);
    if (!$Dish) {
    // Handle the case when the template is not found
    return null;
    }
    // Retrieve categories for the template
    $Dish->categories = $Dish->jobFieldslist();
    return $Dish;
    }
}
