<?php

namespace App\Http\Controllers\Createlead;

use Illuminate\Http\Request;

use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use App\Http\Controllers\home;
use App\Models\lms_customerslots;
use App\Calendar_Models\lms_weeks;
use App\Calendar_Models\lms_slots;
use App\Calendar_Models\lms_timemasters;
use App\Models\lms_times;
use App\Calendar_Models\lms_slotrelations;
use App\Models\lms_callfroms;
use App\Models\lms_customerhometypes;
use App\Repositories\CalendarRepository;
use App\Repositories\CallerScreenRepository;
// uses the server side validation
use Validator;
class CreateleadController extends Controller
{ 
     public function __construct(home $home,CalendarRepository $CalendarRepository,CallerScreenRepository $CallerScreenRepository)
	{
		$this->home= $home;		
		$this->CalendarRepository = $CalendarRepository;
		$this->CallerScreenRepository = $CallerScreenRepository; 

	}
	public function display_content()
	{	  
	    $user_id = session('usrs_userid');
        $list_dashborad_data = $this->home->get_dashboard_menu($user_id); 
		$message=array('title' => 'Create Lead',  'description' => "" , 'page' => 'dataentry2','get_dashborad_data' => $list_dashborad_data);
		$call_froms=lms_callfroms::all();
		return view("createlead/createlead",$message)->with(array("call_froms"  => $call_froms));		
	}
	public function display_content1()
	{	
        $user_id = session('usrs_userid');
        $list_dashborad_data = $this->home->get_dashboard_menu($user_id);

		$message=array('title' => 'Data Entry',  'description' => "" , 'page' => 'dataentry2','get_dashborad_data' => $list_dashborad_data);
		if(isset($_POST['lld_Calldesc']))
		{
		$calldescription=$_POST['lld_Calldesc'].date('my');
	}
		//echo $lld_Calldesc;
		$hometypes=lms_customerhometypes::all();
		$agent_user_list = $this->CallerScreenRepository->list_lms_agent_users();
		return view("createlead/createlead1",$message)->with(array("hometypes"  => $hometypes))
		->with(array("lld_CallFromId"=>$_POST['lld_CallFromId'],"calldescription"=>$calldescription,"lld_AssociateId"=>$_POST['lld_AssociateId'],"lld_StoreId"=>$_POST['lld_StoreId'],"hd_type_id"=>$_POST['hd_type_id'],"lld_calldescription"=>$_POST['lld_Calldesc']))
		->with('agent_user_list',$agent_user_list);
	}
	public function create_newlead(Request $request)
	{
		$cd_CellPhone        = "";
		$lld_calldescription = "";
		extract($_POST);
		$this->request = $request;
		$data          =  $this->request->all();
	    $lms_customerdetails = new lms_customerdetails; 
		$rules = array(
						'lcd_FirstName'=> 'required',
						'lcd_LastName'=> 'required',
						'lcd_HomePhone'=> 'required',
						'lcd_Zipcode'=> 'required|numeric',
						'lcd_OwnerTypeId'=> 'required',
						'lcd_Address'=> 'required',
						'lcd_City'=> 'required',
						'lcd_County'=> 'required',
						'appointment_time'=> 'required',
						'appointment_datetime'=> 'required',
						'tsr_number'=> 'required',
						'lcd_State'=> 'required',
						 );
        // used to check the server validation						 
	    $validator = Validator::make($data, $rules);
		 if ($validator->passes()) {
		$lms_customerdetails->lcd_Presence    = '1';
		$lms_customerdetails->lcd_CallById    = '0';
		$lms_customerdetails->lcd_Title       = 'Mr';
		$lms_customerdetails->lcd_FirstName   = $lcd_FirstName;
		$lms_customerdetails->lcd_LastName    = $lcd_LastName;
		$lms_customerdetails->lcd_Zipcode     = $lcd_Zipcode;
		$lms_customerdetails->lcd_OwnerTypeId = $lcd_OwnerTypeId;
		$lms_customerdetails->lcd_HomeTypeId  = $lcd_HomeTypeId;  //
		if(isset($lcd_CoownerName))
		{
		$lms_customerdetails->lcd_CoownerName = $lcd_CoownerName;
		}
		else
		{
		$lms_customerdetails->lcd_CoownerName = '';
		}
		$lms_customerdetails->lcd_Address     = $lcd_Address;
		$lms_customerdetails->lcd_CrossStreet = $lcd_CrossStreet;
		$lms_customerdetails->lcd_City        = $lcd_City;
		$lms_customerdetails->lcd_County      = $lcd_County;
		$lms_customerdetails->lcd_State       = $lcd_State;
		if(isset($lcd_AptUnit))
		{
			$lms_customerdetails->lcd_AptUnit = $lcd_AptUnit;  // 
		}
		else
		{
		    $lms_customerdetails->lcd_AptUnit = '0';  // 
		}
		$lms_customerdetails->lcd_HousecColor   = $lcd_HousecColor;
		$lms_customerdetails->lcd_EmailAddress  = $lcd_EmailAddress;
		$lms_customerdetails->lcd_Community     = $lcd_Community; //
		$lms_customerdetails->lcd_HomePhone     = $lcd_HomePhone;
		$lms_customerdetails->lcd_WPTitle       = $lcd_WPTitle;
		$lms_customerdetails->lcd_WorkPhone     = $lcd_WorkPhone;
		$lms_customerdetails->lcd_CPTitle       = $lcd_CPTitle;
		$lms_customerdetails->lcd_CellPhone     = $cd_CellPhone; //
		$lms_customerdetails->lcd_Territory     = 1; //
		$lms_customerdetails->lcd_Comments      = $lcd_Comments;
		
		$lms_customerdetails->save();
		$CustomerId                      = $lms_customerdetails->lcd_CustomerId;
		$lms_calldetails                  = new lms_calldetails;
		$lms_calldetails->lld_CustomerId  = $CustomerId;
		$lms_calldetails->lld_ProductCode = $lld_ProductCode;
		if(!empty($lld_CallFromId))
		{
		$lms_calldetails->lld_CallFromId = $lld_CallFromId;
		}
		if(!empty($lld_ProsepctId))
		{
		 $lms_calldetails->lld_ProsepctId = $lld_ProsepctId;
		}
		
		$lms_calldetails->lld_SlotId      = 0; //
		$lms_calldetails->lld_CallbackId  = 0; //
		$lms_calldetails->lld_VerificationCode = 0; //
		if(!empty($lld_StoreId))
		{
		$lms_calldetails->lld_StoreId    = $lld_StoreId;
		}
		if(!empty($lld_AssociateId))
		{
		$lms_calldetails->lld_AssociateId = $lld_AssociateId;
		}
		if(isset($appointment_date) && $appointment_date!="")
		{
			$lms_calldetails->lld_CallStatusId     =2;
		}
		else
		{
			$lms_calldetails->lld_CallStatusId     =33;
		}
		
		$lms_calldetails->lld_NonProductId   = 0;
		$lms_calldetails->lld_AgentCreatedBy = $tsr_number;
		$lms_calldetails->lld_AgentUpdatedBy = $conf_number;
		$lms_calldetails->lld_AssignedBy     = '0';
		$lms_calldetails->lld_ResultedBy     = '0';
		$lms_calldetails->lld_CallTypeId     = '0'; 
		$lms_calldetails->lld_OriginSourceId = '0';
		$lms_calldetails->lld_LiveStatus     = '';
		$lms_calldetails->lld_LeadBucketID   = '2'; //
		$lms_calldetails->lld_RepAssigned    = '0';
		$lms_calldetails->lld_RepResulted     = '0';
		$lms_calldetails->lld_PriorityOrder   = '0';
		$lms_calldetails->lld_PrioritySetDate   = date('Y-m-d H:i:s');
		$lms_calldetails->lld_FinishCallButton  = 1;
		$lms_calldetails->lld_CallDateTime      = date('Y-m-d H:i:s');
		$lms_calldetails->lld_RecordCreatedDateTime     = date('Y-m-d H:i:s');
		$lms_calldetails->lld_RescheduleCreatedDateTime = date('Y-m-d H:i:s');
		$lms_calldetails->lld_LastModifiedDate          = date('Y-m-d H:i:s');;
		$lms_calldetails->save();
	
		$appdate          = $appointment_date;
		$apptime          = $appointment_time;
		
		
		$actual = $this->CalendarRepository->slotDetailsForAllLeads($appdate,$apptime,$lcd_Zipcode,$CustomerId,$territory_id);  

		
		//->whereRaw('lms_slotrelations.lsr_Actual-lms_slotrelations.lsr_Allocated > 0')
		//echo $actual."/";
     if($actual=='success')  
	 {
		return redirect('gridview'); 
	 }
		
	
	 }
	 else 
	 {
		$messages = $validator->messages();
		return Redirect::to('createlead')->withErrors($validator); 
	 }
		
   }
}
