<?php

namespace App\Http\Controllers\SchedulingOutbound;

use Illuminate\Http\Request;
use App\Models\remap_users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\LoginRepository;
use Illuminate\support\Facades\Session;
use App\Http\Controllers\home;
use App\Repositories\CallerScreenRepository;
use App\Repositories\Outbound\OutboundRepository;
use App\Repositories\CalendarRepository;
use App\Calendar_Models\lms_weeks;
use App\Calendar_Models\lms_slots;
use App\Models\lms_callstatus;
use App\Repositories\ConfirmOutbound\ConfirmOutboundRepository;
class OutboundScriptFlowController extends Controller
{
     public function __construct(remap_users $remap_users,home $home,CalendarRepository $CalendarRepository,OutboundRepository $OutboundRepository,ConfirmOutboundRepository $ConfirmOutboundRepository)
	{
		$this->remap_users = $remap_users;
		$this->home= $home;
		$this->CalendarRepository = $CalendarRepository;
		$this->OutboundRepository = $OutboundRepository;
		$this->ConfirmOutboundRepository = $ConfirmOutboundRepository;
		
	}
    //
	public function OutboundScript(LoginRepository $LoginRepository,CallerScreenRepository $CallerScreenRepository)
	{
		$get_all_user_data  = Session::all();
		//print_r($get_all_user_data);
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		$agentAccessDetails  = $LoginRepository->dashborad_data($sess_user_id);
		$get_agent_access    = $LoginRepository->get_agent_access();
		$UserList_data       = $LoginRepository->UserList_function();
		$lms_callfroms_data = $CallerScreenRepository->lms_callfroms_fun();
		$lms_hdtypes_data   = $CallerScreenRepository->lms_hdtypes_fun();
		$listNonProduct      = $CallerScreenRepository->listNonProductFun();
		$lms_customerhometypes =$CallerScreenRepository->lms_customerhometypes_fun(); 
		$agent_access=$this->home->get_dashboard_menu($sess_user_id);
		
		$week_id=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekId');
		
		$start_date=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekStartDate');
		//echo $week_id."/";
		$zipcode = 30123;
		$territory_id_fet = $this->CalendarRepository->get_territory_based_zipcode($zipcode);
		 $calendar_id_fet  = $this->CalendarRepository->get_calendar_based_territory($territory_id_fet);
		$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
		$weekly_app_result = $this->CalendarRepository->weekly_app_func($slot_id,$territory_id_fet,$calendar_id_fet,$week_id);
		//$weekly_app_result['start_date'] = $start_date;
		return view('SchedulingOutbound.OutboundScriptFlow', array('title' => 'Scheduling Outbound', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access,'agentDetailsGetAccess' => $agentAccessDetails,'get_agent_access_list' => $get_agent_access,'UserData_display' => $UserList_data,'CallerScreenRepository_data'=>$lms_callfroms_data,'lms_hdtypes_data'=>$lms_hdtypes_data,'listNonProduct'=>$listNonProduct,'lms_customerhometypes'=>$lms_customerhometypes,'weekly_app_result'=>$weekly_app_result));
	}
	
	public function OutboundScriptEditFunc(LoginRepository $LoginRepository,CallerScreenRepository $CallerScreenRepository)
	{
		$customerId = $_POST['CustomerId'];
		$customerDetails = $this->OutboundRepository->GetListCustomerDetails($customerId);
	  
        // to Check whether update or create the request id
		$requestIdCheck = $this->ConfirmOutboundRepository->CheckExistRequestId($customerId);
	    if($requestIdCheck['lld_RequestId']!='')
		{
			$requestId = $requestIdCheck['lld_RequestId'];
		}
		else
		{
			$requestId = $this->ConfirmOutboundRepository->UpdateRequestIdReturnId($customerId);
		}	  

		$get_all_user_data  = Session::all();
		//print_r($get_all_user_data);
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		$agentAccessDetails  = $LoginRepository->dashborad_data($sess_user_id);
		$get_agent_access    = $LoginRepository->get_agent_access();
		// List of all users in the appointment screen
		$UserList_data       = $LoginRepository->UserList_function();
		// List of all call from details
		$lms_callfroms_data = $CallerScreenRepository->lms_callfroms_fun();
		// List all hd types
		$lms_hdtypes_data   = $CallerScreenRepository->lms_hdtypes_fun();
		// List of all non product data
		$listNonProduct      = $CallerScreenRepository->listNonProductFun();
		// List of all customer home types
		$lms_customerhometypes =$CallerScreenRepository->lms_customerhometypes_fun(); 
		// List of left menu option
		$agent_access=$this->home->get_dashboard_menu($sess_user_id);
		// Get week id from here
		$week_id=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekId');
		$lms_call_desc_data  = $CallerScreenRepository->associate_dnis_desc($call_from="");
		/*$start_date=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekStartDate');
		//echo $week_id."/";
		$zipcode = 30123;
		$territory_id_fet = $this->CalendarRepository->get_territory_based_zipcode($zipcode);
		 $calendar_id_fet  = $this->CalendarRepository->get_calendar_based_territory($territory_id_fet);
		$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
		$weekly_app_result = $this->CalendarRepository->weekly_app_func($slot_id,$territory_id_fet,$calendar_id_fet,$week_id);
		
	    */
    	$call_status=lms_callstatus::select('lls_CallStatusId','lls_CallStatus')->where('lls_StatusType','=','final')->get();
		
		//$weekly_app_result['start_date'] = $start_date;
		return view('SchedulingOutbound.OutboundScriptFlow', array('title' => 'Scheduling Outbound', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access,'agentDetailsGetAccess' => $agentAccessDetails,'get_agent_access_list' => $get_agent_access,'UserData_display' => $UserList_data,'CallerScreenRepository_data'=>$lms_callfroms_data,'lms_hdtypes_data'=>$lms_hdtypes_data,'listNonProduct'=>$listNonProduct,'lms_customerhometypes'=>$lms_customerhometypes,"customerDetails"=>$customerDetails,'week_id'=>$week_id,'lms_call_desc_data'=>$lms_call_desc_data,'call_status'=>$call_status,'requestId'=>$requestId));
	}
}
