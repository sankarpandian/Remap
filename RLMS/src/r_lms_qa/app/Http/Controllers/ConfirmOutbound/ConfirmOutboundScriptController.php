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
		
		$call_status=lms_callstatus::select('lls_CallStatusId','lls_CallStatus')->where('lls_StatusType','=','final')->get();
		
		// product updated to scheduing inbound
		$productCode='B';
		$ScriptCabinet = $CallerScreenRepository->ScriptDetailsFun($bucketId=8,$productCode);
		
		$productCodeG='G';
		$ScriptGarbage = $CallerScreenRepository->ScriptDetailsFun($bucketId=8,$productCodeG);
		$productCodeO='O';
		$ScriptCloset = $CallerScreenRepository->ScriptDetailsFun($bucketId=8,$productCodeO);
		// Associate Page
		$ScriptAssociate = $CallerScreenRepository->ScriptQuestionFun($bucketId=9,$ScreenId=29);
		// Greeting page 
		$ScriptGreetings = $CallerScreenRepository->ScriptQuestionFun($bucketId=9,$ScreenId=30);
		// Customer info left page 
		$ScriptCustomerInfo = $CallerScreenRepository->ScriptQuestionFun($bucketId=8,$ScreenId=26);
		//Appointment Page
		$appointmentInfoAll = $CallerScreenRepository->ScriptQuestionFun($bucketId=8,$ScreenId=27);
		//Review page
		$reviewInfoAll = $CallerScreenRepository->ScriptQuestionFun($bucketId=8,$ScreenId=28);
		
		return view('ConfirmationOutbound.ConfirmationOutboundScriptFlow', array('title' => 'Confirmation Outbound', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access,'agentDetailsGetAccess' => $agentAccessDetails,'get_agent_access_list' => $get_agent_access,'UserData_display' => $UserList_data,'CallerScreenRepository_data'=>$lms_callfroms_data,'lms_hdtypes_data'=>$lms_hdtypes_data,'listNonProduct'=>$listNonProduct,'lms_customerhometypes'=>$lms_customerhometypes,"ConfirmCustomerDetails"=>$customerDetails,'week_id'=>$week_id,'lms_call_desc_data'=>$lms_call_desc_data,'call_status'=>$call_status,'requestId'=>$requestId,'ScriptAssociate'=>$ScriptAssociate,'ScriptGreetings'=>$ScriptGreetings));
	}
}
