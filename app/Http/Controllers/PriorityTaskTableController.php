<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Contractors;
use App\Repositories\ResponseRepository;
use Illuminate\Validation\Rule;
use App\Models\PriorityTaskTable;
use App\Models\AddTask;
use App\Models\TaskTable;

class PriorityTaskTableController extends Controller
{

    public function __construct(ResponseRepository $response)
    {

        $this->response = $response;
        $this->storeRules = [
            'contactor_id' => 'nullable',
            'priority_task_name' => 'nullable',
            'priority_task_hours' => 'nullable',
            'priority_task_cost_one' => 'nullable',
            'priority_task_cost_two' => 'nullable',
            'priority_task_emp_cost' => 'nullable',
            'contactor_cost' => 'nullable',
            'contactor_cost_two' => 'nullable',
            'contactor_cost_three' => 'nullable',
            'contactor_cost_four' => 'nullable',
            'contactor_cost_five' => 'nullable',
            'contactor_cost_six' => 'nullable',
        ];
    }

    public function indexPriorityTaskTable()
    {
        // return $this->response->jsonResponse(false,"TaskTables Detail Fetched Successfully",  PriorityTaskTable::with('contractorlist')->orderBy('priority_task_id', 'desc')->get() , 300);
        $addTasks = AddTask::where('cost_type_name', 'fixed')
            ->with('tasks')
            ->orderBy('task_id', 'desc')
            ->get();

        return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully", $addTasks, 300);
    }

    public function priorityTaskTable()
    {
        $data =  PriorityTaskTable::with('contractorlist')->orderBy('priority_task_id', 'desc')->get();
        return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully",  $data, 300);
    }

    // public function getActiveAllPriorityTaskTable() {
    //     return $this->response->jsonResponse(false,"TaskTables Detail Fetched Successfully",  PriorityTaskTable::with('sorTableOneTaskname')->orderBy('priority_task_id', 'desc')->get((['projects_id', 'priority_task_name'])) , 300);
    // }


    // public function getActiveAllPriorityTaskTable()
    // {
    //     return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully",  PriorityTaskTable::where('active_status', 1)->with('taskTablelist')->orderBy('priority_task_id', 'desc')->get((['projects_id', 'priority_task_name','task_table_id'])), 300);
    // }
//     public function getActiveAllPriorityTaskTable()
// {
//     $latestMonth = TaskTable::max('date_of_effect');

//     return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully",  PriorityTaskTable::where('active_status', 1)
//         ->with(['taskTablelist' => function($query) use ($latestMonth) {
//             $query->where('date_of_effect', 'like', date('Y-m', strtotime($latestMonth)) . '-%');
//         }])
//         ->orderBy('priority_task_id', 'desc')
//         ->get(['projects_id', 'priority_task_name','task_table_id']), 300);
// }

// public function getActiveAllPriorityTaskTable()
// {
//     $latestDate = TaskTable::max('date_of_effect');
//     log::info($latestDate);

//     $priorityTaskTables = PriorityTaskTable::where('active_status', 1)
//         ->with(['taskTablelist' => function($query) use ($latestDate) {
//             $query->where('date_of_effect', $latestDate);
//         }])
//         ->orderBy('priority_task_id', 'desc')
//         ->get();
//         log::info($priorityTaskTables);

//     $taskTableList = $priorityTaskTables->pluck('taskTablelist')->flatten();
//     log::info($taskTableList);


//     return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully", $taskTableList, 300);
// }

public function getActiveAllPriorityTaskTable()
{
    $latestDate = TaskTable::max('date_of_effect');

    $priorityTaskTables = PriorityTaskTable::where('active_status', 1)
        ->with(['taskTablelist' => function($query) use ($latestDate) {
            $query->where('date_of_effect', $latestDate);
        }])
        ->orderBy('priority_task_id', 'desc')
        ->get();

    $result = [];

    foreach ($priorityTaskTables as $priorityTaskTable) {
        $taskTablelist = $priorityTaskTable->taskTablelist->firstWhere('date_of_effect', $latestDate);
        // log::info($taskTablelist);

        if ($taskTablelist) {
            $result[] = [
                'priority_task_id' => $priorityTaskTable->priority_task_id,
                'priority_task_name' => $priorityTaskTable->priority_task_name,
                'task_table_id' => $priorityTaskTable->task_table_id,
                'task_tablelist' => $taskTablelist->toArray()
            ];
            // log::info($result);

        }
    }

    return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully", $result, 300);
}





    // public function store(Request $request)
    // {
    //     $validate = $this->response->validate($request->all(), $this->storeRules);
    //     if ($validate === true) {
    //         return $this->response->jsonResponse(false, $this->response->message('TaskTables', 'store'), PriorityTaskTable::create($request->all()), 301);
    //     } else {
    //         return $validate;
    //     }
    // }

    public function show($id)
    {
        return $this->response->jsonResponse(false, $this->response->message('TaskTables', 'show'), $this->findPriorityTaskTable($id), 302);
    }

    public function updatePriorityTaskTable(Request $request)
    {
        $validate = $this->response->validate($request->all(), [
            'priority_task_name' => ['nullable'],

        ]);
        if ($validate === true) {
            return $this->response->jsonResponse(false, $this->response->message('TaskTables', 'update'), $this->findPriorityTaskTable($request->id)->update($request->all()), 303);
        } else {
            return $validate;
        }
    }

    public function destroy($id)
    {
        $size = $this->findPriorityTaskTable($id);
        if ($size) {
            return $this->response->jsonResponse(false, $this->response->message('TaskTables', 'destroy'), $size->delete(), 304);
        }
        return $this->response->jsonResponse(true, 'TaskTables Not Exists', [], 305);
    }

    public function findPriorityTaskTable($id)
    {
        return PriorityTaskTable::find($id);
    }

    public function priorityTaskTableSwitch($id)
    {
        $size = $this->findPriorityTaskTable($id);
        if ($size) {
            $value = $size->active_status === 1 ? 0 : 1;
            $msg = $value === 0 ? 'Deactivated' : 'Activated';
            return $this->response->jsonResponse(false, 'TaskTables ' . $msg . ' SuccessFully', $size->update(['active_status' => $value]), 306);
        }
        return $this->response->jsonResponse(true, 'TaskTables Not Exists', [], 307);
    }

    public function searchPriorityTaskTable($search)
    {
        if ($search === "null") {
            return $this->response->jsonResponse(false, $this->response->message('TaskTables', 'search'), [], 910);
        }
        return $this->response->jsonResponse(false, $this->response->message('TaskTables', 'search'), PriorityTaskTable::where('priority_task_name', 'LIKE', '%' . $search . '%')->get(), 911);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $projectId = $data['project_id'];
        $clientId = $data['client_id'];
        $dateOfEffect = $data['date_of_effect'];
        foreach ($data['tables'] as $table) {
            $taskTableId = $table['task_table_id'];
            Log::info('taskTableId '.$taskTableId);
            // if ($taskTableId) {
            $taskTable = TaskTable::find($taskTableId);
            Log::info('taskTable '.$taskTable);
            if (!$taskTable) {

                $taskTable = new TaskTable();
                $taskTable->project_id = $projectId;
                $taskTable->client_id = $clientId;
                $taskTable->date_of_effect = $dateOfEffect;
                $taskTable->save();
            }


            foreach ($table['rows'] as $row) {
                // Check if the priority task already exists
                $priorityTaskId = $row['priorityTaskId'];
                if (!empty($priorityTaskId )) {
                    $priorityTask = PriorityTaskTable::find($priorityTaskId);
                    Log::info('1 ');
                    if (!$priorityTask) {

                        return $this->response->jsonResponse(true, 'Priority task not found', '', 404);
                    }

                } else {
                    Log::info('2 ');
                    Log::info('3 = '  .$taskTable->task_table_id);
                    $priorityTask = new PriorityTaskTable();
                    $priorityTask->task_table_id = $taskTable->task_table_id;
                }

                $priorityTask->priority = $row['priority'];
                $priorityTask->projects_id = $data['project_id'];
                $priorityTask->priority_task_name = $row['taskName'];
                $priorityTask->priority_task_hours = $row['hours'];
                $priorityTask->with_stc_cost = $row['stcCostWithReduction'];
                $priorityTask->no_stc_cost = $row['stcCostNoReduction'];
                $priorityTask->emp_cost = $row['empCost'];

                $contractors = $row['contractors'];
                $contractorKeys = array_keys($contractors);

                for ($i = 0; $i <= 5; $i++) {
                    //contractor cost
                    $contractorNameKey = 'contractor_name_' . $i + 1;
                    if (isset($contractors['contractor_cost_' . $i])) {
                        $contractorCost = $contractors['contractor_cost_' . $i];
                    } else {
                        $contractorCost = null;
                    }
                    if (isset($contractors['contractor_id_' . $i])) {

                        $contractorId = $contractors['contractor_id_' . $i];
                    } else {
                        $contractorId = null;
                    }
                    if (isset($contractors[$contractorNameKey])) {
                        $contractorName = $contractors[$contractorNameKey];
                    } else {
                        $contractorName = null;
                    }
                    $priorityTask->{'contractor_cost_' . $i + 1} = $contractorCost;
                    $priorityTask->{'contractor_id_' . $i + 1} = $contractorId;
                    $priorityTask->$contractorNameKey =  $contractorName;
                }

                $priorityTask->active_status = 1;

                $priorityTask->save();
            }
        }

        return $this->response->jsonResponse(false, 'Task table created successfully', '', 200);
    }


    public function taskTable($projectId, $clientId, $doe)
    {
        if ($projectId || $clientId) {
            $data = TaskTable::with('priorityTasks','clientslist')->where('project_id', $projectId)->where('client_id', $clientId);
            if (empty($doe)) {
                $data->where('date_of_effect', $doe);
            }
            return $this->response->jsonResponse(false, "TaskTables Detail Fetched Successfully",  $data->orderBy('date_of_effect', 'desc')->orderBy('task_table_id', 'desc')->get(), 300);
        } else {
            return $this->response->jsonResponse(false, "Invalid Parameters", '', 301);
        }
    }
}
