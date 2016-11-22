<?php

namespace App\Http\Controllers\ReschedulingOutbound;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\remap_users;
use App\Repositories\CalendarRepository;
use App\Http\Controllers\home;
use App\Calendar_Models\lms_weeks;
use App\Calendar_Models\lms_slots;
use App\Repositories\CallerScreenRepository;
use App\Repositories\LoginRepository;
use App\Repositories\RescheduleOutbound\RescheduleOutboundRepository;
use App\Repositories\ConfirmOutbound\ConfirmOutboundRepository;
use App\Models\lms_callstatus;
class RescheduleOutboundScriptController extends Controller
{
    public function __construct(remap_users $remap_users,home $home,CalendarRepository $CalendarRepository,RescheduleOutboundRepository $RescheduleOutboundRepository,ConfirmOutboundRepository $ConfirmOutboundRepository)
	{
		$this->remap_users = $remap_users;
		$this->home= $home;
		$this->CalendarRepository = $CalendarRepository;
		$this->RescheduleOutboundRepository = $RescheduleOutboundRepository;
		 $this->ConfirmOutboundRepository   = $ConfirmOutboundRepository;
	}
	
	public function RescheduleOutboundScript(LoginRepository $LoginRepository,CallerScreenRepository $CallerScreenRepository)
	{
		$customerId = $_POST['CustomerId'];
		$get_all_user_data  = Session::all();
		$sess_user_id        = $get_all_user_data['usrs_userid'];
		$agentAccessDetails  = $LoginRepository->dashborad_data($sess_user_id);
		$get_agent_access    = $LoginRepository->get_agent_access();
		// get the user list for appointmant page
		$UserList_data       = $LoginRepository->UserList_function();
		// Get the list of call from data
		$lms_callfroms_data  = $CallerScreenRepository->lms_callfroms_fun();
		// Get the list of hd types data
		$lms_hdtypes_data    = $CallerScreenRepository->lms_hdtypes_fun();
		// Get the list of non product data
		$listNonProduct      = $CallerScreenRepository->listNonProductFun();
		//list lms customer home types data
		$lms_customerhometypes =$CallerScreenRepository->lms_customerhometypes_fun(); 
		//left menu dashboard
		$agent_access=$this->home->get_dashboard_menu($sess_user_id);
		// get the week_id from here
		$week_id=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekId');
		
		/*$start_date=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekStartDate');
		//echo $week_id."/";
		$zipcode = 30123;
		$territory_id_fet = $this->CalendarRepository->get_territory_based_zipcode($zipcode);
		$calendar_id_fet  = $this->CalendarRepository->get_calendar_based_territory($territory_id_fet);
		$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
		$weekly_app_result = $this->CalendarRepository->weekly_app_func($slot_id,$territory_id_fet,$calendar_id_fet,$week_id);*/
		
		$customerDetails = $this->RescheduleOutboundRepository->GetListCustomerDetails($customerId);
	    
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
		$call_status=lms_callstatus::select('lls_CallStatusId','lls_CallStatus')->where('lls_StatusType','=','final')->get();
		$lms_call_desc_data  = $CallerScreenRepository->associate_dnis_desc($call_from="");
		return view('ReschedulingOutbound.ReschedulingOutboundScriptFlow', array('title' => 'Caller Screen', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access,'agentDetailsGetAccess' => $agentAccessDetails,'get_agent_access_list' => $get_agent_access,'UserData_display' => $UserList_data,'CallerScreenRepository_data'=>$lms_callfroms_data,'lms_hdtypes_data'=>$lms_hdtypes_data,'listNonProduct'=>$listNonProduct,'lms_customerhometypes'=>$lms_customerhometypes,'RescheduleCustdetails'=>$customerDetails,'week_id'=>$week_id,'lms_call_desc_data'=>$lms_call_desc_data,'call_status'=>$call_status,'requestId'=>$requestId));
	}
}
