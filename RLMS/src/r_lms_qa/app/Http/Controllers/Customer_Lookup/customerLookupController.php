<?php

namespace App\Http\Controllers\Customer_Lookup;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Repositories\CalendarRepository;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Models\lms_callstatus;
use App\Models\lms_products;
use App\Models\lms_customerhometypes;
use App\Repositories\CallerScreenRepository;
class customerLookupController extends Controller
{
    //
	public function __construct(home $home,CalendarRepository $CalendarRepository,lms_customerdetails $lms_customerdetails,CalendarRepository $CalendarRepository,lms_customerdetails $lms_customerdetails,CallerScreenRepository $CallerScreenRepository)
	{
		$this->home                   = $home;
		$this->lms_customerdetails    = $lms_customerdetails;
		$this->CalendarRepository     = $CalendarRepository;
        $this->CallerScreenRepository = $CallerScreenRepository;
	}
	 public function gridview_fun()
		 {
			 $cust_det      = lms_customerdetails::all();
			 // echo $cust_det;
			 $call_det      = lms_calldetails::all();
			 //echo $call_det;
			 $cust_slot     = lms_customerslots::all();
			 $cust_status   = lms_callstatus::all();
			 $cust_products = lms_products::all();

     //print_r($cust_status);
     //echo $cust_slot;
     $cust_lookup_res= $this->lms_customerdetails
     			 ->join('lms_calldetails', 'lms_calldetails.lld_CustomerId', '=', 'lms_customerdetails.lcd_CustomerId')
     			 ->leftjoin('lms_customerslots', 'lms_customerslots.lcs_CustomerId', '=', 'lms_customerdetails.lcd_CustomerId')
     			 ->join('lms_products', 'lms_calldetails.lld_ProductCode', '=', 'lms_products.lp_ProductCode')
     			 ->join('lms_callstatus', 'lms_calldetails.lld_CallStatusId', '=', 'lms_callstatus.lls_CallStatusId')
     			 ->join('lms_branches', 'lms_branches.lb_TerritoryId', '=', 'lms_customerdetails.lcd_Territory')
     			 ->get();

    //return view('gridview')->with(array("cust"  => $cust));	
       $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
		$existing_calendar_data     = $this->CalendarRepository->lms_existing_calendar_fun();
		return view('cust_lookup.gridview',array('title' => 'Customer Lookup', 'description' =>'Customer Lookup' , 'page' => 'New Calendar','get_dashborad_data' => $agent_access,'cust_lookup'=>$cust_lookup_res,'existing_calendar_data'=>$existing_calendar_data));
}
 public function cust_lookup()
 {
 	    $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
		$existing_calendar_data     = $this->CalendarRepository->lms_existing_calendar_fun();
		return view('customer_lookup.customer_lookup_popup',array('title' => 'Customer Lookup', 'description' =>'Customer Lookup' , 'page' => 'New Calendar','get_dashborad_data' => $agent_access,'existing_calendar_data'=>$existing_calendar_data));
 }

 public function customer_full_view()
	{
		//print_r($_POST);exit;
	    $cust_id=$_POST["CustomerId"];
		$cust_detail = lms_customerdetails::join('lms_calldetails', 'lms_calldetails.lld_CustomerId', '=', 'lms_customerdetails.lcd_CustomerId')
		->where('lcd_CustomerId',$cust_id)->get();
		$hometypes=lms_customerhometypes::all();
		$agent_user_list = $this->CallerScreenRepository->list_lms_agent_users();
		$user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
		$existing_calendar_data     = $this->CalendarRepository->lms_existing_calendar_fun();
		return view('cust_lookup.fullview',array('title' => 'Customer Lookup', 'description' =>'Customer Lookup' , 'page' => 'New Calendar','get_dashborad_data' => $agent_access,'existing_calendar_data'=>$existing_calendar_data))->with(array("hometypes"  => $hometypes))->with('agent_user_list',$agent_user_list)->with(array("cust_detail"  => $cust_detail));
	}
	
 public function update_custdetails(Request $request)
	{		
		extract($_POST);
		$lms_customerdetails = lms_customerdetails::find($lcd_CustomerId);
		
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
		$lms_customerdetails->lcd_CPTitle = $lcd_CPTitle;
		//$lms_customerdetails->lcd_CPTitle = $lcdreatelead_cusdetails_CPTitle;
		$lms_customerdetails->lcd_CellPhone     = $lcd_CellPhone; //
		$lms_customerdetails->lcd_Territory     = '1'; //
		$lms_customerdetails->lcd_Comments      = $lcd_Comments;
		$lms_customerdetails->save();
		
		$lms_calldetail_id = lms_calldetails::where('lld_CustomerId',$lcd_CustomerId)->value('lld_CallDetailId');
		$lms_calldetails = lms_calldetails::find($lms_calldetail_id);
		$lms_calldetails->lld_ProductCode = $lld_ProductCode;
		if(!empty($lld_ProsepctId))
		{
		//$lms_calldetails->lld_ProsepctId = $lld_ProsepctId.date('my').$lld_ProductCode;
		$lms_calldetails->lld_ProsepctId = $lld_ProsepctId;
		}
		if(!empty($lld_calldescription))
		{
		//$lms_calldetails->lld_ProsepctId = $lld_ProsepctId.date('my').$lld_ProductCode;
		$lms_calldetails->lld_calldescription = $lld_calldescription;
		}
		$lms_calldetails->lld_SlotId           = 0; 
		$lms_calldetails->lld_CallbackId       = 0; 
		$lms_calldetails->lld_VerificationCode = 0; 
		
		$lms_calldetails->lld_NonProductId     = 0;
		$lms_calldetails->lld_AgentCreatedBy   = $tsr_number;
		$lms_calldetails->lld_AgentUpdatedBy   = $conf_number;
		$lms_calldetails->lld_AssignedBy       = '0';
		$lms_calldetails->lld_ResultedBy       = '0';
		$lms_calldetails->lld_CallTypeId       = '0'; 
		$lms_calldetails->lld_OriginSourceId   = '0';
		$lms_calldetails->lld_LiveStatus       = '';
		$lms_calldetails->lld_LeadBucketID     = '2'; 
		$lms_calldetails->lld_RepAssigned      = '0';
		$lms_calldetails->lld_RepResulted      = '0';
		$lms_calldetails->lld_PriorityOrder    = '0';
		$lms_calldetails->lld_PrioritySetDate  = date('Y-m-d H:i:s');
		$lms_calldetails->lld_FinishCallButton = 1;
		$lms_calldetails->lld_CallDateTime     = date('Y-m-d H:i:s');
		$lms_calldetails->lld_RecordCreatedDateTime     = date('Y-m-d H:i:s');
		$lms_calldetails->lld_RescheduleCreatedDateTime = date('Y-m-d H:i:s');
		$lms_calldetails->lld_LastModifiedDate          = date('Y-m-d H:i:s');
		
		$lms_calldetails->save();
		$user_id = session('usrs_userid');
        $list_dashborad_data = $this->home->get_dashboard_menu($user_id);

		$message=array('title' => 'Data Entry',  'description' => "Created Lead Successfully." , 'page' => 'dataentry','get_dashborad_data' => $list_dashborad_data);
		return redirect('gridview');
	}
}
