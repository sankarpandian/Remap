<?php

namespace App\Http\Controllers\ReschedulingOutbound;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Models\lms_callstatus;

class RescheduleOutboundController extends Controller
{
	public function __construct(home $home)
	{
		
		$this->home= $home;		
	}

 public function RescheduleOutbound()
 {
 	$user_id = session('usrs_userid');
 	$get_all_user_data  = Session::all();
	$sess_user_id       = $get_all_user_data['usrs_userid'];
	$agent_access=$this->home->get_dashboard_menu($sess_user_id);
	
	$customer_details= lms_customerdetails::join('lms_calldetails','lms_customerdetails.lcd_CustomerId','=','lms_calldetails.lld_CustomerId')
 	->join('lms_branches','lms_customerdetails.lcd_Territory','=','lms_branches.lb_TerritoryId')
 	->join('lms_products','lms_calldetails.lld_ProductCode','=','lms_products.lp_ProductCode')
 	->where('lms_calldetails.lld_CallStatusId','=',20)
	->orWhere('lms_calldetails.lld_CallStatusId', '=', 19)->first();
	
	
    return view('ReschedulingOutbound.ReschedulingCallerScreen',array('title' => 'Rescheduling Outbound', 'description' =>'Rescheduling Outbound' , 'page' => 'Rescheduling Outbound','get_dashborad_data' => $agent_access,'customer_details'=>$customer_details));

 	
 	
 }
}
