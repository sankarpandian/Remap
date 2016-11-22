<?php

namespace App\Http\Controllers\ConfirmOutbound;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\remap_users;
use App\Repositories\CalendarRepository;
use App\Http\Controllers\home;
use App\Calendar_Models\lms_weeks;
use App\Calendar_Models\lms_slots;
use App\Models\lms_callstatus;
use App\Repositories\CallerScreenRepository;
use App\Repositories\LoginRepository;
use App\Repositories\ConfirmOutbound\ConfirmOutboundRepository;

class ConfirmOutboundScriptController extends Controller
{
    public function __construct(remap_users $remap_users,home $home,CalendarRepository $CalendarRepository,ConfirmOutboundRepository $ConfirmOutboundRepository)
	{
		$this->remap_users = $remap_users;
		$this->home= $home;
		$this->CalendarRepository = $CalendarRepository;
		$this->ConfirmOutboundRepository = $ConfirmOutboundRepository;
	}
	
	public function ConfirmOutboundScript(LoginRepository $LoginRepository,CallerScreenRepository $CallerScreenRepository)
	{
		
		if(isset($_POST['CustomerId']))
		{
		 $customerId = $_POST['CustomerId'];
		}
		$customerDetails = $this->ConfirmOutboundRepository->GetListCustomerDetails($customerId);
		
		
		$get_all_user_data  = Session::all();
		//print_r($get_all_user_data);
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		$agentAccessDetails  = $LoginRepository->dashborad_data($sess_user_id);
		$get_agent_access    = $LoginRepository->get_agent_access();
		$UserList_data       = $LoginRepository->UserList_function();
		// Call From Data
		$lms_callfroms_data = $CallerScreenRepository->lms_callfroms_fun();
		// Call decription data
		$lms_call_desc_data  = $CallerScreenRepository->associate_dnis_desc($call_from="");
		// Hd types
		$lms_hdtypes_data   = $CallerScreenRepository->lms_hdtypes_fun();
		// List of all non product
		$listNonProduct      = $CallerScreenRepository->listNonProductFun();
		// Customer Home types
		$lms_customerhometypes =$CallerScreenRepository->lms_customerhometypes_fun(); 
		// Left side menu display
		$agent_access=$this->home->get_dashboard_menu($sess_user_id);
		
		$week_id=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekId');
		
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
		
			/*$start_date=lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekStartDate');
		//echo $week_id."/";
		$zipcode = 30123;
		$territory_id_fet = $this->CalendarRepository->get_territory_based_zipcode($zipcode);
		 $calendar_id_fet  = $this->CalendarRepository->get_calendar_based_territory($territory_id_fet);
		$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
		$weekly_app_result = $this->CalendarRepository->weekly_app_func($slot_id,$territory_id_fet,$calendar_id_fet,$week_id);
		*/
		$call_status=lms_callstatus::select('lls_CallStatusId','lls_CallStatus')->where('lls_StatusType','=','final')->get();
		
		return view('ConfirmationOutbound.ConfirmationOutboundScriptFlow', array('title' => 'Confirmation Outbound', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access,'agentDetailsGetAccess' => $agentAccessDetails,'get_agent_access_list' => $get_agent_access,'UserData_display' => $UserList_data,'CallerScreenRepository_data'=>$lms_callfroms_data,'lms_hdtypes_data'=>$lms_hdtypes_data,'listNonProduct'=>$listNonProduct,'lms_customerhometypes'=>$lms_customerhometypes,"ConfirmCustomerDetails"=>$customerDetails,'week_id'=>$week_id,'lms_call_desc_data'=>$lms_call_desc_data,'call_status'=>$call_status,'requestId'=>$requestId));
	}
}
