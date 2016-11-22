<?php
use app\Http\Middleware\Authenticate;
use Illuminate\support\Facades\session;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Login page
Route::get('/','Auth\loginController@login');
Route::get('/login','Auth\loginController@login');

// Authenticate User
Route::post('home', 'Auth\loginController@authenticate_user');

// Home page
Route::get('home', 'home@index');

//Logout user with Session Destroy.
Route::get('/logout', function () {
	Session::flush(); 
    return view('Auth.login',array('title' => 'Login', 'description' => 'you are logged out Successfully.', 'page' => 'login'));
});

// 	Data entry
Route::get('/dataentry',['uses' => 'Dataentry\DataentryController@display_content','as' => 'Data Entry']);

Route::post('/dataentry',['uses' => 'Dataentry\DataentryController@display_content','as' => 'Data Entry']);
//Data Details
Route::get('/dataentry_cusdetails',['uses' => 'Dataentry\DataentryController@display_content1','as' => 'Data Entry']);
Route::post('/dataentry_cusdetails',['uses' => 'Dataentry\DataentryController@display_content1','as' => 'Data Entry']);

Route::post('/dataentry_cusdetails1',['uses' => 'Dataentry\DataentryController@create_newlead', 
									  'as' => 'Data Entry'
                                     ]
		   );
// Create Lead
Route::get('/createlead',['uses' => 'Createlead\CreateleadController@display_content', 
						  'as' => 'home'
	                     ]
		   );
Route::post('/createlead',['uses' => 'Createlead\CreateleadController@display_content', 
						   'as' => 'home'
						  ]
		   );
Route::get('/createlead_cusdetails',['uses' => 'Createlead\CreateleadController@display_content1', 
									 'as' => 'home'
									]
		  );
Route::post('/createlead_cusdetails',['uses' => 'Createlead\CreateleadController@display_content1', 
									 'as' => 'home'
									]
		  );
Route::post('/createlead_cusdetails1',['uses' => 'Createlead\CreateleadController@create_newlead', 
										'as' => 'home'
									  ]
		   );
// Agent management		 
Route::get('/agent_mgt','Agent_MGT\Agent_MGTController@agentAccessFun');
Route::post('/agent_mgt',['uses' => 'Agent_MGT\agentAllDetailController@InsertAgentAllDetails', 
	'as' => 'home'
]);	

//Update Agent management
Route::post('Edit_access_mgt', 'Agent_MGT\agentAllDetailController@access_mgt_fun');

Route::get('call_from_ajax', 'Ajax_Process\AjaxProcessController@call_from_ajax_fun');
// Weekly Appointment Request for Calendar Mgt
Route::get('weekly_app', 'Ajax_Process\AjaxProContrWeeklyApp@week_app_ajax_fun');

// Weekly Appointment Request for Sales Manager
Route::get('salesManWeeklyApp', 'Ajax_Process\SalesManagerAjaxProContrWeeklyApp@SalesManagerWeeklyAppoint');


Route::get('ajax_appointment_date', 'Ajax_Process\AjaxProcessController@ajax_appointment_date');

Route::get('ajax_call_from', 'Ajax_Process\AjaxProcessController@ajax_call_from');

Route::get('ajax_zipcode', 'Ajax_Process\AjaxProcessController@ajax_zipcode');


	
Route::post('/Delete_access_mgt','Agent_MGT\agentAllDetailController@Delete_access_mgt');

Route::get('/shed_inbound','caller_screen\callerScreenController@callerScreen');
// insert of scheduling inbound
Route::get('insertCallerScreen', 'Ajax_Process\AjaxProcessController@insertCallerScreen_fun');

Route::get('/customerLookup','caller_screen\callerScreenController@customerLookup');
//New Calendar
Route::get('/new_calendar','Dynamic_Calendar\newCalendarController@newCalendarFun');
Route::get('/add_calendar','Dynamic_Calendar\newCalendarController@addCalendarFun');
Route::post('/add_calendar','Dynamic_Calendar\newCalendarController@addBranchForCalendarFun');
//Route::post('add_calendar', ['as' => 'delete', 'uses' => 'Dynamic_Calendar\newCalendarController@new_branch']);
//Route::post('add_calendar', ['as' => 'delete', 'uses' => 'Dynamic_Calendar\newCalendarController@add_new_branch_for_calr']);

Route::get('add_calendar/{id}','Dynamic_Calendar\newCalendarController@add_new_branch_for_calr');
Route::post('add_calendar/{id}','Dynamic_Calendar\newCalendarController@add_new_branch_for_calr');
/*Calendar Management */
Route::get('/calendar_mgt','Calendar_Mgt\Callendar_Mgt_Controller@Callendar_Mgt_Fun');
Route::post('/calendar_mgt','Calendar_Mgt\Callendar_Mgt_Controller@addBranchForCalendarFun');
// Weekly appointment Request using agent mgt
Route::get('/weekly_appoint','Calendar_Mgt\Callendar_Mgt_Controller@weeklyAppointRequestFun');
Route::post('/weekly_appoint','Calendar_Mgt\Callendar_Mgt_Controller@weeklyAppointRequestFun');

// Customer Lookup
Route::get('/gridview','Customer_Lookup\customerLookupController@gridview_fun');

Route::get('/leads_import_api','LeadsImportApi\LeadsImportApiController@leads_import_api');

Route::post('/leads_import_api','LeadsImportApi\LeadsImportApiController@leads_import_api');

Route::get('inbound_ajax_zipcode', 'Ajax_Process\AjaxProcessController@inbound_ajax_zipcode');

Route::get('/outbound','Outbound\outboundScreenController@outboundScreen');

// Skip Lead
Route::get('/skip_lead/{id}','Scheduling_Outbound\SchedulingOutboundController@skip_lead');
Route::get('ajax_skip_lead', 'Ajax_Process\AjaxProcessController@ajax_skip_lead');
Route::get('ajax_comment', 'Ajax_Process\AjaxProcessController@ajax_comment');



// Scheduling Outbound
Route::get('/Shedoutboundcallerscreen','SchedulingOutbound\OutboundCallerScreenController@scheduling_outbound');

Route::post('/Scheduleoutboundscriptflow','SchedulingOutbound\OutboundScriptFlowController@OutboundScriptEditFunc');
// Confirmation Outbound
Route::get('/Confirmoutboundcallerscreen','ConfirmOutbound\ConfirmOutboundController@confirmOutbound');
Route::post('/Confirmationoutboundscriptflow','ConfirmOutbound\ConfirmOutboundScriptController@ConfirmOutboundScript');
Route::get('/Confirmationoutboundscriptflow/{cusomer_id}','ConfirmOutbound\ConfirmOutboundScriptController@ConfirmOutboundScript');
// Rescheduling Outbound
Route::get('/Rescheduleoutboundcallerscreen','ReschedulingOutbound\RescheduleOutboundController@RescheduleOutbound');
Route::post('/Rescheduleoutboundscriptflow','ReschedulingOutbound\RescheduleOutboundScriptController@RescheduleOutboundScript');


//Update Outbound data
Route::get('/updateoutbounddata','Ajax_Process\OutboundAjaxProcessController@OutboundUpdateProcess');

//Update Confirmation outbound data
Route::get('/updateconfimoutbounddata','Ajax_Process\ConfirmOutboundAjaxProcessController@ConfirmOutboundUpdateProcess');


//Update reschedule outbound data
Route::get('/updaterescheduleoutbounddata','Ajax_Process\RescheduleOutboundAjaxProcessController@RescheduleOutboundUpdateProcess');
//Report
Route::get('/generalproduct','Report\ReportController@generalproductFunc');
Route::get('/leads','Report\ReportController@leadsFunc');
Route::get('/sales','Report\ReportController@salesFunc');
Route::get('/slotavailability','Report\ReportController@slotavailabilityFunc');
Route::get('/userlog','Report\ReportController@userlogFunc');

// Sales Manager dashboard

Route::get('/smrequest','SalesManager\SalesManagerController@SalesManagerDashboard');
// Sales Manager Weekly Appointment Request
Route::post('/salesmanagerweeklyrequest','SalesManager\SalesManagerController@SalesManagerWeeklyRequestFn');

// Admin Bucket route
Route::get('/bucket','Admin\Bucket\BucketController@BucketFunction');
// Admin Bucket route - After Submiting the form
Route::post('/bucket','Admin\Bucket\BucketController@BucketInsertFunction');
// Admin Srceen route
Route::get('/screen','Admin\Screen\ScreenController@ScreenFunction');
// Admin Srceen route - After Submiting the form
Route::post('/screen','Admin\Screen\ScreenController@ScreenInsertFunction');
// Admin Script route
Route::get('/script','Admin\Script\ScriptController@ScriptFunction');
// Admin script route - After Submiting the form
Route::post('/script','Admin\Script\ScriptController@ScriptInsertFunction');
// Admin script route - After Submiting the form
Route::get('/BucketIdAjaxGetScreenData','Ajax_Process\AdminAjaxProController@ScreenDataFromBucket');

Route::get('/ProductAjaxGetScript','Ajax_Process\AdminAjaxProController@ProductAjaxGetScript');
//Getting the script list
Route::get('/AjaxGetScript','Ajax_Process\AdminAjaxProController@AjaxGetScript');

//quick result update
Route::get('/slotValidateSalesManeger','Ajax_Process\SalesManagerAjaxProContrWeeklyApp@slotValidateSalesManFun');
//oot and non product
Route::get('ajax_oot', 'Ajax_Process\AjaxProcessController@ajax_oot');
Route::get('ajax_non_product', 'Ajax_Process\AjaxProcessController@ajax_non_product');
//oot and non product inbound
Route::get('ajax_oot_inbound', 'Ajax_Process\AjaxProcessController@ajax_oot_inbound');
Route::get('ajax_non_product_inbound', 'Ajax_Process\AjaxProcessController@ajax_non_product_inbound');

// Weekly appointment schedule slot validation
Route::get('/scheduleslot', 'Ajax_Process\AjaxProContrWeeklyApp@SheduleSlotValidation');

// Weekly appointment Confirmation slot validation
Route::get('/confrimslot', 'Ajax_Process\AjaxProContrWeeklyApp@confirmSlotValidation');

// Microsite for time slot with lock functionality
Route::get('/calenmicrosite', 'CalenMicrosite\CalenMicrositeController@micrositeFunc');

// time slot with lock functionality to all bucket
Route::get('/lockTimeSlot', 'CalenMicrosite\CalenMicrositeController@lockTimeSlotFunc');

// Display Customer information 
Route::post('/customerfullview','Customer_Lookup\customerLookupController@customer_full_view');
Route::post('/update_custdetails','Customer_Lookup\customerLookupController@update_custdetails');

//quick result update
Route::post('/quickresult_result','Ajax_Process\AjaxProcessController@quickresult_result');

//quick result update
Route::get('/quickresult_inbound','Ajax_Process\AjaxProcessController@quickresult_inbound');

//Home Phone Number Check
Route::get('/dup_homephone','Ajax_Process\AjaxProcessController@dup_homephone');


//Duplicates Gridview

Route::get('/Duplicates','DuplicateRecords\DuplicateRecordsContoller@duplicate_records');


//Test 2nd Duplicates page
Route::get('/Territory','DuplicateRecords\DuplicateRecordsContoller@manage_duplicate_records');

//Test 3rd Duplicates page

Route::get('/Update_dupes','DuplicateRecords\DuplicateRecordsContoller@update_duplicate_records');

// Dynamic product script
Route::get('/productScript','DuplicateRecords\DuplicateRecordsContoller@update_duplicate_records');

// Dynamic script - manage Field
Route::get('/managefield','Admin\Script\ScriptController@ManageFieldFunction');

Route::post('/managefield','Admin\Script\ScriptController@ManageFieldInsertFunction');


Route::get('/getmanagefield','caller_screen\callerScreenController@GetmanageFieldFunction');

Route::get('/ListOfAllDataSelect','Ajax_Process\CommonAjaxProcessController@ListOfAllDataSelectFun');

