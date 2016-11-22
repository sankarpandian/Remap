<?php

namespace App\Http\Controllers\SchedulingOutbound;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Models\lms_callstatus;

class OutboundCallerScreenController extends Controller
{
    public function __construct(home $home)
	{
		
		$this->home= $home;		
	}

 public function scheduling_outbound()
 {
 	 $user_id = session('usrs_userid');
 	//$user_id =1;
    $list_dashborad_data = $this->home->get_dashboard_menu($user_id);

	$message=array('title' => 'Scheduling Outbound',  'description' => "" , 'page' => 'Scheduling Outbound','get_dashborad_data' => $list_dashborad_data);
 	//$call_status=lms_callstatus::whereIn('lls_CallStatusId',[21,22,31,23,27])->get();
 	$customer_details= lms_customerdetails::join('lms_calldetails','lms_customerdetails.lcd_CustomerId','=','lms_calldetails.lld_CustomerId')
 	->join('lms_branches','lms_customerdetails.lcd_Territory','=','lms_branches.lb_TerritoryId')
 	->join('lms_products','lms_calldetails.lld_ProductCode','=','lms_products.lp_ProductCode')
 	->whereIn('lms_calldetails.lld_CallStatusId',[21,22,31,23,27,33,1])
	//->orWhere('lms_calldetails.lld_CallStatusId', '=', 1)
	->first();
	
	if(count($customer_details)==0)
	{
		//$customer_details = array('null');
	}
    // Caller Screen Content
	
	$get_all_user_data  = Session::all();
	$sess_user_id       = $get_all_user_data['usrs_userid'];
	$agent_access=$this->home->get_dashboard_menu($sess_user_id);
    return view('SchedulingOutbound.OutboundCallerScreen',array('title' => 'Scheduling Outbound', 'description' =>'Scheduling Outbound' , 'page' => 'Scheduling Outbound','get_dashborad_data' => $agent_access,'customer_details'=>$customer_details));

 	
 	
 }
}
