<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('set', function () {
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    return "Optimization Cache is set";
});
Route::get('clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    //Artisan::call('composer:autoload');
    return "Optimization Cache is Cleared";
});




// Contact Details
Route::get('getContactusDetails', 'GetHomeDetailsController@getContactusDetails');


Route::get('getHomePageDetails', 'GetHomeDetailsController@getHomePageDetails');


Route::get('getActiveMenus', 'GetHomeDetailsController@getActiveMenus');

Route::post('contactUsCreate', 'ContactUsController@contactUsCreate');
// Route::get('getFooterBlock', 'FooterBlockController@getFooterBlock');

//User
Route::post('loginUser', 'UserController@loginUser');
Route::post('forgotPassword', 'UserController@forgotPassword');
Route::post('ResetPassword', 'UserController@ResetPassword');

// // Main Menu
// Route::get('getMainMenuDetails', 'GetHomeDetailsController@getMainMenuDetails');




Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('updateImage','ImageController@imageUpload');



    //ContactUs
    Route::apiResource('contactUs', 'ContactUsController');
    Route::get('getContactUsDetails', 'ContactUsController@getContactUsDetails');
    Route::get('searchContactUs/{search}', 'ContactUsController@searchContactUs');



    //Media Link
    Route::apiResource('footerBlock', 'FooterBlockController');
    Route::post('updateFooterBlock', 'FooterBlockController@updateFooterBlock');

    //User
    Route::apiResource('user', 'UserController');
    Route::get('indexUser', 'UserController@indexUser');
    Route::post('updateUsers', 'UserController@updateUsers');
    Route::get('searchUser/{search}', 'UserController@searchUser');
    Route::get('userSwitch/{id}', 'UserController@userSwitch');

    //UserTypes
    Route::apiResource('userTypes', 'UserTypesController');
    Route::get('indexUserTypes', 'UserTypesController@indexUserTypes');
    Route::post('updateUserTypes', 'UserTypesController@updateUserTypes');
    Route::get('userTypesSwitch/{id}', 'UserTypesController@userTypesSwitch');
    Route::get('getActiveUserTypes', 'UserTypesController@getActiveUserTypes');
    Route::get('searchUserTypes/{search}', 'UserTypesController@searchUserTypes');

    //Services Controller
    Route::apiResource('services', 'ServicesController');
    Route::get('indexServices', 'ServicesController@indexServices');
    Route::post('updateServices', 'ServicesController@updateServices');
    Route::get('searchServices/{search}', 'ServicesController@searchServices');
    Route::get('servicesSwitch/{id}', 'ServicesController@servicesSwitch');
    Route::get('getActiveServices', 'ServicesController@getActiveServices');



    //Clients Controller
    Route::apiResource('clients', 'ClientsController');
    Route::get('indexClient', 'ClientsController@indexClient');
    Route::post('updateClients', 'ClientsController@updateClients');
    Route::get('searchClients/{search}', 'ClientsController@searchClients');
    Route::get('clientsSwitch/{id}', 'ClientsController@clientsSwitch');
    Route::get('getActiveClients', 'ClientsController@getActiveClients');


      //Contract Controller
      Route::apiResource('contractors', 'ContractorsController');
      Route::get('indexContractor', 'ContractorsController@indexContractor');
      Route::post('updateContractors', 'ContractorsController@updateContractors');
      Route::get('contractorsSwitch/{id}', 'ContractorsController@contractorsSwitch');
      Route::get('searchContractors/{search}', 'ContractorsController@searchContractors');
      Route::get('getActiveContractors', 'ContractorsController@getActiveContractors');

       //Cost Type Controller
       Route::apiResource('costType', 'CostTypeController');
       Route::get('indexCostType', 'CostTypeController@indexCostType');
       Route::post('updateCostType', 'CostTypeController@updateCostType');
       Route::get('costTypeSwitch/{id}', 'CostTypeController@costTypeSwitch');
       Route::get('searchCostType/{search}', 'CostTypeController@searchCostType');
       Route::get('getActiveCostType', 'CostTypeController@getActiveCostType');


        //Field  Task Controller
         Route::apiResource('fieldsTask', 'FieldsTaskController');
         Route::get('indexFieldsTask', 'FieldsTaskController@indexFieldsTask');
         Route::post('updateFieldsTask', 'FieldsTaskController@updateFieldsTask');
         Route::get('fieldsTaskSwitch/{id}', 'FieldsTaskController@fieldsTaskSwitch');
         Route::get('searchFieldsTask/{search}', 'FieldsTaskController@searchFieldsTask');
         Route::get('getActiveFieldsTask', 'FieldsTaskController@getActiveFieldsTask');


             //Task Field Controller
       Route::apiResource('taskField', 'TaskFieldController');
       Route::get('indexTaskField', 'TaskFieldController@indexTaskField');
       Route::post('updateTaskField', 'TaskFieldController@updateTaskField');
       Route::get('taskFieldSwitch/{id}', 'TaskFieldController@taskFieldSwitch');
       Route::get('searchTaskField/{search}', 'TaskFieldController@searchTaskField');
       Route::get('getActiveAllTaskField', 'TaskFieldController@getActiveAllTaskField');

       //  Status Controller
    Route::apiResource('status', 'StatusController');
    Route::get('indexStatus', 'StatusController@indexStatus');
    Route::post('updateStatus', 'StatusController@updateStatus');
    Route::get('searchStatus/{search}', 'StatusController@searchStatus');
    Route::get('statusSwitch/{id}', 'StatusController@statusSwitch');


     //  Roles Controller
     Route::apiResource('roles', 'RolesController');
     Route::get('indexRoles', 'RolesController@indexRoles');
     Route::post('updateRoles', 'RolesController@updateRoles');
     Route::get('searchRoles/{search}', 'RolesController@searchRoles');
     Route::get('rolesSwitch/{id}', 'RolesController@rolesSwitch');
     Route::get('getActiveAllroles', 'RolesController@getActiveAllroles');

       //  EmploymentType Controller
       Route::apiResource('employmentType', 'EmploymentTypeController');
       Route::get('indexEmploymentType', 'EmploymentTypeController@indexEmploymentType');
       Route::post('updateEmploymentType', 'EmploymentTypeController@updateEmploymentType');
       Route::get('searchEmploymentType/{search}', 'EmploymentTypeController@searchEmploymentType');
       Route::get('employmentTypeSwitch/{id}', 'EmploymentTypeController@employmentTypeSwitch');
       Route::get('getActiveAllEmployeetype', 'EmploymentTypeController@getActiveAllEmployeetype');

       //  Roles Controller
      Route::apiResource('displayView', 'DisplayViewController');
      Route::get('indexDisplayView', 'DisplayViewController@indexDisplayView');
      Route::post('updateDisplayView', 'DisplayViewController@updateDisplayView');
      Route::get('searchDisplayView/{search}', 'DisplayViewController@searchDisplayView');
      Route::get('displayViewSwitch/{id}', 'DisplayViewController@displayViewSwitch');

      //  PRT Controller
      Route::apiResource('prt', 'PrtController');
      Route::get('indexPrt', 'PrtController@indexPrt');
      Route::post('updatePrt', 'PrtController@updatePrt');
      Route::get('searchPrt/{search}', 'PrtController@searchPrt');
      Route::get('prtSwitch/{id}', 'PrtController@prtSwitch');
      Route::get('getActiveAllPrt', 'PrtController@getActiveAllPrt');

       //  Super Controller
       Route::apiResource('superannuation', 'SuperannuationController');
       Route::get('indexSuperannuation', 'SuperannuationController@indexSuperannuation');
       Route::post('updateSuperannuation', 'SuperannuationController@updateSuperannuation');
       Route::get('searchSuperannuation/{search}', 'SuperannuationController@searchSuperannuation');
       Route::get('superannuationSwitch/{id}', 'SuperannuationController@superannuationSwitch');
       Route::get('getActiveAllSuperannuation', 'SuperannuationController@getActiveAllSuperannuation');

      //        // Projects Controller
      //  Route::apiResource('projects', 'ProjectsController');
      //  Route::get('indexadd', 'ProjectsController@indexadd');
      //  Route::post('updateProjects', 'ProjectsController@updateProjects');
      //  Route::get('projectsSwitch/{id}', 'ProjectsController@projectsSwitch');
      //  Route::get('searchProjects/{search}', 'ProjectsController@searchProjects');
      //  Route::get('getActiveAllProjects', 'ProjectsController@getActiveAllProjects');
      //  Route::get('getActiveAllProjCostType', 'ProjectsController@getActiveAllProjCostType');

      //  Route::get('getProjectName', 'ProjectsController@getProjectName');
      // Projects Controller
      Route::apiResource('projects', 'ProjectsController');
      Route::get('indexadd', 'ProjectsController@indexadd');
      Route::post('updateAddProjects', 'ProjectsController@updateAddProjects');
      Route::get('projectsSwitch/{id}', 'ProjectsController@projectsSwitch');
      Route::get('searchProjects/{search}', 'ProjectsController@searchProjects');
      Route::get('getActiveAllProjects', 'ProjectsController@getActiveAllProjects');
      Route::get('getActiveAllProjCostType', 'ProjectsController@getActiveAllProjCostType');
      Route::get('getActiveAllProjectsByType/{type}', 'ProjectsController@getActiveAllProjectsByType');
      Route::get('getActiveAllProjectsByTypeSOR/{type}', 'ProjectsController@getActiveAllProjectsByTypeSOR');

      Route::get('getProjectName', 'ProjectsController@getProjectName');

        //   Add Task  Controller
       Route::apiResource('taskAdd', 'AddTaskController');
       Route::get('indexTaskadd', 'AddTaskController@indexTaskadd');
       Route::post('updateTask', 'AddTaskController@updateTask');
       Route::get('taskSwitch/{id}', 'AddTaskController@taskSwitch');
       Route::get('searchTask/{search}', 'AddTaskController@searchTask');
       Route::get('getActiveAllTask', 'AddTaskController@getActiveAllTask');
       Route::get('getprojectalldetils', 'AddTaskController@getprojectalldetils');
       Route::get('getSORdetails', 'AddTaskController@getSORdetails');

        // // Priority Task Table  Controller
        // Route::apiResource('priorityTaskTable', 'PriorityTaskTableController');
        // Route::get('indexPriorityTaskTable', 'PriorityTaskTableController@indexPriorityTaskTable');
        // Route::post('updatePriorityTaskTable', 'PriorityTaskTableController@updatePriorityTaskTable');
        // Route::get('priorityTaskTableSwitch/{id}', 'PriorityTaskTableController@priorityTaskTableSwitch');
        // Route::get('searchPriorityTaskTable/{search}', 'PriorityTaskTableController@searchPriorityTaskTable');
        // Route::get('getActiveAllPriorityTaskTable', 'PriorityTaskTableController@getActiveAllPriorityTaskTable');

        Route::apiResource('priorityTaskTable', 'PriorityTaskTableController');
        Route::get('indexPriorityTaskTable', 'PriorityTaskTableController@indexPriorityTaskTable');
        Route::post('updatePriorityTaskTable', 'PriorityTaskTableController@updatePriorityTaskTable');
        Route::get('priorityTaskTableSwitch/{id}', 'PriorityTaskTableController@priorityTaskTableSwitch');
        Route::get('searchPriorityTaskTable/{search}', 'PriorityTaskTableController@searchPriorityTaskTable');
        Route::get('getActiveAllPriorityTaskTable', 'PriorityTaskTableController@getActiveAllPriorityTaskTable');
        Route::get('priorityTaskTable/{projectId}/{clientId}/{doe}', 'PriorityTaskTableController@taskTable');



         // SOR ADD Task  Controller
         Route::apiResource('soraddtask', 'SORAddTaskController');
         Route::get('indexSORAddTask', 'SORAddTaskController@indexSORAddTask');
         Route::post('updateSORAddTask', 'SORAddTaskController@updateSORAddTask');
         Route::get('sorAddTaskSwitch/{id}', 'SORAddTaskController@sorAddTaskSwitch');
         Route::get('searchSORAddTask/{search}', 'SORAddTaskController@searchSORAddTask');
         Route::get('getActiveAllSORAddTask', 'SORAddTaskController@getActiveAllSORAddTask');


        // SOR First Table Controller
         Route::apiResource('sortableone', 'SORTableOneController');
         Route::get('indexSORTableOne', 'SORTableOneController@indexSORTableOne');
         Route::post('updateSORTableOne', 'SORTableOneController@updateSORTableOne');
         Route::get('sorTableOneSwitch/{id}', 'SORTableOneController@sorTableOneSwitch');
         Route::get('searchSORTableOne/{search}', 'SORTableOneController@searchSORTableOne');
         Route::get('getActiveAllSORTableOne', 'SORTableOneController@getActiveAllSORTableOne');
         Route::get('getActiveAllSORTableOneproj', 'SORTableOneController@getActiveAllSORTableOneproj');


         // SOR Second Table Controller
         Route::apiResource('sortabletwo', 'SORTableTwoController');
         Route::get('indexSORTableTwo', 'SORTableTwoController@indexSORTableTwo');
         Route::post('updateSORTableTwo', 'SORTableTwoController@updateSORTableTwo');
         Route::get('sorTableTwoSwitch/{id}', 'SORTableTwoController@sorTableTwoSwitch');
         Route::get('searchSORTableTwo/{search}', 'SORTableTwoController@searchSORTableTwo');
         Route::get('getActiveAllSORTableTwo', 'SORTableTwoController@getActiveAllSORTableTwo');

           // fieldTypes Table Controller
         Route::apiResource('fieldTypes', 'FieldTypesController');
         Route::get('indexFieldTypes', 'FieldTypesController@indexFieldTypes');
         Route::post('updateFieldTypes', 'FieldTypesController@updateFieldTypes');
         Route::get('fieldTypesSwitch/{id}', 'FieldTypesController@fieldTypesSwitch');
         Route::get('searchFieldTypes/{search}', 'FieldTypesController@searchFieldTypes');
         Route::get('getActiveFieldTypes', 'FieldTypesController@getActiveFieldTypes');

         // Fields Table Controller
         Route::apiResource('fields', 'FieldsController');
         Route::get('indexFields', 'FieldsController@indexFields');
         Route::post('updateFields', 'FieldsController@updateFields');
         Route::post('bulkTaskFieldsstore', 'FieldsController@bulkTaskFieldsstore');
         Route::get('fieldsSwitch/{id}', 'FieldsController@fieldsSwitch');
         Route::get('searchFields/{search}', 'FieldsController@searchFields');
         Route::get('getActiveAllFields', 'FieldsController@getActiveAllFields');
         Route::get('getJobCoulumnId/{id}', 'FieldsController@getJobCoulumnId');
         Route::get('getActiveAllJobFields', 'FieldsController@getActiveAllJobFields');


        // Uniquejob Controller
         Route::apiResource('uniquejob', 'UniqueJobController');
         Route::get('indexUniqueJob', 'UniqueJobController@indexUniqueJob');
         Route::get('getActiveUniqueJob', 'UniqueJobController@getActiveUniqueJob');

          // Employee Table Controller
         Route::apiResource('employee', 'AddEmployeeController');
         Route::get('indexAddEmployee', 'AddEmployeeController@indexAddEmployee');
         Route::post('updateAddEmployee', 'AddEmployeeController@updateAddEmployee');
         Route::get('addEmployeeSwitch/{id}', 'AddEmployeeController@addEmployeeSwitch');
         Route::get('searchAddEmployee/{search}', 'AddEmployeeController@searchAddEmployee');
         Route::get('getActiveAddEmployee', 'AddEmployeeController@getActiveAddEmployee');
         Route::get('getEmployeeName', 'AddEmployeeController@getEmployeeName');
         Route::get('getremunerationList', 'AddEmployeeController@getremunerationList');



         Route::get('getEmployeeProjectList', 'AddEmployeeController@getEmployeeProjectList');
        //  Route::get('getRemunerationid/{remuneration_id}', 'AddEmployeeController@getRemunerationid');
         Route::get('getEmployeeId/{employee_id}', 'AddEmployeeController@getEmployeeId');

         Route::get('indexlistall', 'RemunerationController@indexlistall');


          // Employee Table Controller
         Route::apiResource('remuneration', 'RemunerationController');
         Route::get('indexRemuneration', 'RemunerationController@indexRemuneration');
         Route::post('updateRemuneration', 'RemunerationController@updateRemuneration');
         Route::get('remunerationSwitch/{id}', 'RemunerationController@remunerationSwitch');
         Route::get('searchRemuneration/{search}', 'RemunerationController@searchRemuneration');
         Route::get('getActiveAllRemuneration', 'RemunerationController@getActiveAllRemuneration');

          // Employee Projects Controller
          Route::apiResource('employeeprojects', 'EmployeeProjectController');
          Route::get('indexEmployeeProject', 'EmployeeProjectController@indexEmployeeProject');
          Route::post('updateProjects', 'EmployeeProjectController@updateProjects');
          Route::get('employeeProjectSwitch/{id}', 'EmployeeProjectController@employeeProjectSwitch');
          Route::get('employeeProjectSearch/{search}', 'EmployeeProjectController@employeeProjectSearch');
          Route::get('getActiveAllEmployeeProject', 'EmployeeProjectController@getActiveAllEmployeeProject');
          Route::get('getProjectId/{projects_id}', 'EmployeeProjectController@getProjectId');

           // Add Fields
         Route::apiResource('addFields', 'AddFieldTypeController');
         Route::get('indexAddFields', 'AddFieldTypeController@indexAddFields');
         Route::post('updateAddFieldType', 'AddFieldTypeController@updateAddFieldType');
         Route::get('addFieldTypeSwitch/{id}', 'AddFieldTypeController@addFieldTypeSwitch');
         Route::get('searchAddFieldType/{search}', 'AddFieldTypeController@searchAddFieldType');
         Route::get('getActiveAddFieldType', 'AddFieldTypeController@getActiveAddFieldType');




});
Route::get('download-job-excel/{project_id}', 'FieldsController@downloadJobsExcel');
Route::post('upload-job-excel', 'FieldsController@upload');


