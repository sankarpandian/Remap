<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Models\lms_call_status;

class ReportController extends Controller
{
	public function __construct(home $home)
	{
		
		$this->home= $home;		
	}

 public function generalproductFunc()
 {
	   $user_id = session('usrs_userid');
	   $agent_access        = $this->home->get_dashboard_menu($user_id);
 	   return view('Report.generalproduct',array('title' => 'General Product Report', 'description' =>'General Product Report' , 'page' => 'General Product Report','get_dashborad_data' => $agent_access));
 }
 public function leadsFunc()
 {
	 $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
 	   return view('Report.generalproduct',array('title' => 'Lead Details', 'description' =>'Lead Details' , 'page' => 'Lead Details','get_dashborad_data' => $agent_access));
 }
 public function salesFunc()
 {
	 $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
 	   return view('Report.generalproduct',array('title' => 'Sales Report', 'description' =>'Sales Report' , 'page' => 'Sales Report','get_dashborad_data' => $agent_access));
 }
 public function slotavailabilityFunc()
 {
	 $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
 	   return view('Report.generalproduct',array('title' => 'Slot Availability Report', 'description' =>'Slot Availability Report' , 'page' => 'Slot Availability Report','get_dashborad_data' => $agent_access));
 }
 public function userlogFunc()
 {
	 $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
 	   return view('Report.generalproduct',array('title' => 'Log User History', 'description' =>'Log User History' , 'page' => 'Log User History','get_dashborad_data' => $agent_access));
 }
}
