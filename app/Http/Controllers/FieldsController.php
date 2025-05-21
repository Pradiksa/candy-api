<?php

namespace App\Http\Controllers;

use App\Exports\JobsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\FieldTypes;
use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\Fields;
use App\Models\UniqueJob;
use App\Models\TaskField;
use App\Models\AddJobsColumn;
use Maatwebsite\Excel\Facades\Excel;



class FieldsController extends Controller
{
    public function __construct(ResponseRepository $response){

        $this->response = $response;
        $this->storeRules = [
             'projects_id' => 'nullable',
            'field_name' => 'nullable',
             'add_fields_id' => 'nullable',

        ];
    }

    public function indexFields() {
        return $this->response->jsonResponse(false,"Fields Detail Fetched Successfully",  Fields::with('Projecttypname','fieldTypeList','fieldsTaskType')->orderBy('fields_id', 'desc')->get() , 300);
    }

    public function getActiveAllFields() {
        return $this->response->jsonResponse(false,"Fields Detail Fetched Successfully",  Fields::where('active_status',1)->with('Projecttypname','fieldTypeList')->orderBy('fields_id', 'desc')->get() , 300);
    }
    public function getActiveAllJobFields() {
        return $this->response->jsonResponse(false,"Fields Detail Fetched Successfully",  Fields::where('active_status',1)->with('Projecttypname','fieldTypeList','fieldsTaskType')->orderBy('fields_id', 'desc')->get() , 300);
    }

    public function getJobCoulumnId($id)
{
    $data = AddJobsColumn::select('id', 'project_id', 'properties')->where('project_id', $id)->get();
    log::info($data);

    $excelData = [];

    foreach ($data as $row) {
        $propertiesArray = $row->properties;

        foreach ($propertiesArray[0] as $key => $object) {
            $excelData[] = array_merge(['id' => $row->id, 'project_id' => $row->project_id], (array)$object);
        }
                log::info($excelData);

    }

    return $this->response->jsonResponse(false, "JobFields Details Fetched Successfully", $excelData, 300);
}


    public function store(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Fields', 'store'), Fields::create($request->all()), 301);
        } else {
            return $validate;
        }
    }

    public function getActiveAllTaskField() {
        return $this->response->jsonResponse(false,"TaskField Detail Fetched Successfully",  TaskField::where('active_status',1)->orderBy('task_field_id', 'desc')->get() , 300);
    }
    // public function getActiveAllTaskFieldData() {
    //     $taskFields = $this->getActiveAllTaskField();

    //     if (!empty($taskFields)) {
    //         $fieldTask = $taskFields[0]; // Assuming you want to take the first task field

    //         return [
    //             'task_field_id' => $fieldTask['task_field_id'],
    //             'field_task_id' => $fieldTask['field_task_id'],
    //         ];
    //     }

    //     return null;
    // }

    public function bulkTaskFieldsstore(Request $request) {
        $validate = $this->response->validate($request->all(), $this->storeRules);
        if($validate === true) {
            $fieldsData = $request->only('priority_task_id', 'projects_id');
            $response = $this->getActiveAllTaskField(); // Assuming this returns JSON
            $taskFieldData = $response->getData(true)['data'];
            log::info($taskFieldData);

            foreach ($taskFieldData as $field) {
                $fieldsData['field_name'] = $field['field_name'];
                $fieldsData['field_task_id'] = $field['field_task_id'];

                Fields::create($fieldsData);
            }

            return $this->response->jsonResponse(false, $this->response->message('Fields', 'store'), null, 301); // Assuming you want to return null after successful creation
        } else {
            return $validate;
        }
    }






    public function show($id) {
        return $this->response->jsonResponse(false, $this->response->message('Fields', 'show'), $this->findFields($id), 302);
    }

    public function updateFields(Request $request) {
        $validate = $this->response->validate($request->all(), [
            'project_name' => ['nullables'],

        ]);
        if($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('Fields', 'update'), $this->findFields($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id) {
        $size = $this->findFields($id);
        if($size) {
            return $this->response->jsonResponse(false, $this->response->message('Fields', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'Fields Not Exists', [], 305);
    }

    public function findFields($id) {
        return Fields::find($id);
    }

    public function fieldsSwitch($id) {
        $size = $this->findFields($id);
        if($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated': 'Activated';
            return $this->response->jsonResponse(false, 'Fields '.$msg.' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'Fields Not Exists', [], 307);
    }

    public function searchFields($search){
        if($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('Fields', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('Fields', 'search'), Fields::where('field_name', 'LIKE', '%'.$search.'%')->get(), 911);
    }


    public function downloadJobsExcel($project_id)
    {
        return Excel::download(new JobsExport($project_id), 'jobs_excel.xlsx');
    }


    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
        'projects_id' => [
            'required',
            'exists:projects,projects_id',
        ],
        // 'templates_id' => 'required',
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $projectId = $request->projects_id;
        // $templatesId = $request->templates_id;

        $data = Excel::toArray(new JobsExport($projectId), $file);

        // Extract unique_job_ids from UniqueJob table
        $uniqueJobIds = UniqueJob::where('projects_id', $projectId)
            ->pluck('fields_id')
            ->toArray();

        $properties = [];

        foreach ($data as $key => $item) {
            foreach ($item as $index => $column) {
                $column['job_id'] = $index + 1;
                // $column['templates_id'] = $templatesId;
                $column['fields_id'] = $uniqueJobIds[0] ?? null; // Set the same unique_job_id for all rows
                $properties[] = $column;
            }
        }

        if (count($properties) > 0) {
            $existance = AddJobsColumn::where('project_id', $projectId);
            if ($existance->exists()) {
                $existance->update(['properties' => [$properties]]);
            } else {
                $jobs = new AddJobsColumn();
                $jobs->project_id = $projectId;
                $jobs->properties = [$properties];
                $jobs->save();
            }

            return $this->response->jsonResponse(false, 'Data uploaded successfully', [], 200);
        } else {
            return $this->response->jsonResponse(false, 'No Excel Data', [], 201);
        }
    }

    return response()->json(['message' => 'No file provided'], 400);
}


}
