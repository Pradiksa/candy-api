<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Services;
use App\Models\Clients;
use App\Models\CostType;

use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\Projects;
use DB;



class ProjectsController extends Controller
{
    public function __construct(ResponseRepository $response)
    {

        $this->response = $response;
        $this->storeRules = [
            'service_id' => 'required',
            'client_id' => 'required',
            // 'client_name' => 'required',
            'cost_type_id' => 'required',
            // 'cost_type_name' => 'required',
            'project_name' => 'required',
        ];
    }

    // public function indexadd()
    // {
    //     // $userData = DB::select('SELECT * FROM users WHERE id > ?', [$userId]);

    //     return $this->response->jsonResponse(false, "Projects Detail Fetched Successfully",  Projects::with('serviceslist', 'clientslist', 'costtypelist', 'clienttypname', 'costtypname')->orderBy('projects_id', 'desc')->get(), 300);
    // }

    public function indexadd()
    {
        $templates = Projects::with('serviceslist','costtypelist','clienttypname','costtypname')->orderBy('projects_id', 'desc')->get();

        // Retrieve categories for each template
        foreach ($templates as $template) {
            $template->categories = $template->clientlist();
        }
        return $this->response->jsonResponse(false, "Categories Details Fetched Successfully", $templates, 300);
    }

    // public function indexadd(){
    //     $clientData = [];
    //     $projects = Projects::get();
    //     foreach($projects as $project) {
    //         $userData = DB::select('SELECT * FROM `projects` a JOIN clients b WHERE b.client_id IN ("'.$project->client_id.'") GROUP BY b.client_id');
    //         // $clientData->push($project['client_id']);
    //     }
    //     return $this->response->jsonResponse(true, "Projects Detail Fetched Successfully", $userData, 200);
    // }

    // public function indexProjects() {
    //     return $this->response->jsonResponse(false," Projects Details Fetched Successfully", Projects::orderBy('projects_id', 'desc')->get(), 300);
    // }

    public function getActiveAllProjects()
    {
        $templates = Projects::where('active_status', 1)->with('serviceslist','clienttypname','costtypname')->orderBy('projects_id', 'desc')->get();

        // Retrieve categories for each template
        foreach ($templates as $template) {
            $template->categories = $template->clientlist();
        }
        return $this->response->jsonResponse(false, "Projects Details Fetched Successfully", $templates, 300);

        // return $this->response->jsonResponse(false, "Projects Detail Fetched Successfully",  Projects::where('active_status', 1)->orderBy('projects_id', 'desc')->get(), 300);
    }


    public function getProjectName()
    {
        return $this->response->jsonResponse(false, "Projects Detail Fetched Successfully",  Projects::with('projectname')->orderBy('projects_id', 'desc')->get(), 300);
    }

    // public function store(Request $request)
    // {
    //     $validate = $this->response->validate($request->all(), $this->storeRules);
    //     if ($validate === true) {
    //         return $this->response->jsonResponse(false, $this->response->message('Projects', 'store'), Projects::create($request->all()), 301);
    //     } else {
    //         return $validate;
    //     }
    // }

    public function store(Request $request)
{
    $validate = $this->response->validate($request->all(), $this->storeRules);
    if ($validate === true) {
        $data = $request->all();
        $data['client_id'] = implode(',', $data['client_id']); // Convert array to comma-separated string
        return $this->response->jsonResponse(false, $this->response->message('Projects', 'store'), Projects::create($data), 301);
    } else {
        return $validate;
    }
}

    public function show($id)
    {
        return $this->response->jsonResponse(false, $this->response->message('Projects', 'show'), $this->findProjectsmMultiSelect($id), 302);
    }

    // public function updateProjects(Request $request)
    // {
    //     $validate = $this->response->validate($request->all(), [
    //         'project_name' => ['required'],

    //     ]);
    //     if ($validate === true) {
    //         return $this->response->jsonResponse(false, $this->response->message('Projects', 'update'), $this->findProjects($request->id)->update($request->all()), 303);
    //     } else {
    //         return $validate;
    //     }
    // }

    public function updateAddProjects(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'service_id' => 'required',
            'project_name' => ['required'],
            'cost_type_id' => 'required',
        ]);

        if($validate === true) {
            $data = $request->all();
            $data['client_id'] = implode(',', $data['client_id']); // Convert to comma-separated values

            $dishes = $this->findProjects($request->projects_id);
            $dishes->update($data);

            return $this->response->jsonResponse(false, $this->response->message('Projects', 'update'), $dishes, 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id)
    {
        $size = $this->findProjects($id);
        if ($size) {
            return $this->response->jsonResponse(false, $this->response->message('Projects', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Projects Not Exists', [], 305);
    }
    public function findProjectsmMultiSelect($id)
    {
        $Dish = Projects::find($id);
        // log::info($Dish);

        if (!$Dish) {
            // Handle the case when the template is not found
            return null;
        }
        // Retrieve categories for the template
        $Dish->categories = $Dish->clientlist();
        // log::info($Dish);

        return $Dish;
    }

    public function findProjects($id)
    {
        return Projects::find($id);
    }

    public function projectsSwitch($id)
    {
        $size = $this->findProjects($id);
        if ($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated' : 'Activated';
            return $this->response->jsonResponse(false, 'Projects ' . $msg . ' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Projects Not Exists', [], 307);
    }

    // public function searchProjects($search){
    //     if($search === "null") {
    //         return $this->response->jsonResponse(false, $this->response->message('Projects', 'search'), [], 910);
    //     }
    //     return $this->response->jsonResponse(false, $this->response->message('Projects', 'search'), Projects::where('project_name', 'LIKE', '%'.$search.'%')->get(), 911);
    // }


    public function searchProjects($search)
    {
        if ($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Projects', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Projects', 'search'), Projects::where('project_name', 'LIKE', '%' . $search . '%')->get(), 911);
    }

    public function getActiveAllProjectsByType($type)
    {
        $templates = Projects::where('cost_type_id', 6)->where('active_status', 1)->with('serviceslist','costtypelist','costtypname')->orderBy('projects_id', 'desc')->get();

        // Retrieve categories for each template
        foreach ($templates as $template) {
            $template->categories = $template->clientlist();
        }
        return $this->response->jsonResponse(false, "Projects Detail Fetched Successfully", $templates, 300);
        // return $this->response->jsonResponse(false, "Projects Detail Fetched Successfully",  Projects::, 300);
    }
    public function getActiveAllProjectsByTypeSOR($type)
    {
        return $this->response->jsonResponse(false, "Projects Detail Fetched Successfully",  Projects::where('cost_type_id', 7)->where('active_status', 1)->orderBy('projects_id', 'desc')->get(), 300);
    }
}
