<?php

namespace App\Http\Controllers\caller_screen;

use Illuminate\Http\Request;
use App\Models\remap_users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\LoginRepository;
use Illuminate\support\Facades\Session;
use App\Http\Controllers\home;
use App\Repositories\CallerScreenRepository;
use App\Repositories\CalendarRepository;
use App\Calendar_Models\lms_weeks;
use App\Calendar_Models\lms_slots;
use App\Models\lms_callstatus;
use App\Models\lms_managefields;
class callerScreenController extends Controller
{
	 public function __construct(remap_users $remap_users,home $home,CalendarRepository $CalendarRepository,lms_managefields $lms_managefields)
	{
		$this->remap_users = $remap_users;
		$this->home= $home;
		$this->CalendarRepository = $CalendarRepository;
        $this->lms_managefields    = $lms_managefields;
	}
    //
	public function callerScreen(LoginRepository $LoginRepository,CallerScreenRepository $CallerScreenRepository)
	{
		$get_all_user_data     = Session::all();
		$sess_user_id          = $get_all_user_data['usrs_userid'];
		$usrs_company_id       = $get_all_user_data['usrs_company_id'];
		                      
		$agentAccessDetails    = $LoginRepository->dashborad_data($sess_user_id);
		$get_agent_access      = $LoginRepository->get_agent_access();
		$UserList_data         = $LoginRepository->UserList_function();
		$lms_callfroms_data    = $CallerScreenRepository->lms_callfroms_fun();
		$lms_hdtypes_data      = $CallerScreenRepository->lms_hdtypes_fun();
		$listNonProduct        = $CallerScreenRepository->listNonProductFun();
		$lms_customerhometypes = $CallerScreenRepository->lms_customerhometypes_fun(); 
		$quickresult           = $LoginRepository->getCallStatus(); 
		$agent_access          = $this->home->get_dashboard_menu($sess_user_id);
		
		$week_id=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekId');
		
		$start_date=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekStartDate');
		
		
		// product updated to scheduing inbound
		$productCode='K';
		$ScriptCabinet = $CallerScreenRepository->ScriptDetailsFun($bucketId=7,$productCode);
		
		$productCodeG='G';
		$ScriptGarbage = $CallerScreenRepository->ScriptDetailsFun($bucketId=7,$productCodeG);
		$productCodeO='O';
		$ScriptCloset = $CallerScreenRepository->ScriptDetailsFun($bucketId=7,$productCodeO);
		
		
		// Associate Page
		$ScriptAssociate = $CallerScreenRepository->ScriptQuestionFun($bucketId=7,$ScreenId=17);
		// Greeting page 
		$ScriptGreetings = $CallerScreenRepository->ScriptQuestionFun($bucketId=7,$ScreenId=18);
		// Customer info left page 
		$ScriptCustomerInfoLeft = $CallerScreenRepository->ScriptQuestionFun($bucketId=7,$ScreenId=20);
		//Appointment Page
		$appointmentInfoAll = $CallerScreenRepository->ScriptQuestionFun($bucketId=7,$ScreenId=21);
		//Review page
		$reviewInfoAll = $CallerScreenRepository->ScriptQuestionFun($bucketId=7,$ScreenId=22);
		//echo $ScriptGreetings; exit;
		$call_status=lms_callstatus::select('lls_CallStatusId','lls_CallStatus')->where('lls_StatusType','=','final')->get();
		
		return view('caller_screen.caller_screen_mgt', array('title' => 'Caller Screen', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access,'agentDetailsGetAccess' => $agentAccessDetails,'get_agent_access_list' => $get_agent_access,'UserData_display' => $UserList_data,'CallerScreenRepository_data'=>$lms_callfroms_data,'lms_hdtypes_data'=>$lms_hdtypes_data,'listNonProduct'=>$listNonProduct,'lms_customerhometypes'=>$lms_customerhometypes,'week_id'=>$week_id,'quickresult'=>$quickresult,'ScriptCabinet'=>$ScriptCabinet,'ScriptGarbage'=>$ScriptGarbage,'ScriptCloset'=>$ScriptCloset,'call_status'=>$call_status,'ScriptAssociate'=>$ScriptAssociate,'ScriptGreetings'=>$ScriptGreetings,'ScriptCustomerInfoLeft'=>$ScriptCustomerInfoLeft,'appointmentInfoAll'=>$appointmentInfoAll,'reviewInfoAll'=>$reviewInfoAll,'company_id'=>$usrs_company_id));
	}
	
	public function customerLookup()
	{
		$get_all_user_data  = Session::all();
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		$agent_access=$this->home->get_dashboard_menu($sess_user_id);
		return view('customer_lookup.customer_lookup',array('title' => 'Customer Lookup', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access));
	}

    public function GetmanageFieldFunction()
    {
		$screenId = $_REQUEST['screenId'];
		$lms_managefields = new  lms_managefields;
        $result = $lms_managefields->select('*')->where("lm_ScreenId","=",$screenId)->get();
        return $result;
    }
}
