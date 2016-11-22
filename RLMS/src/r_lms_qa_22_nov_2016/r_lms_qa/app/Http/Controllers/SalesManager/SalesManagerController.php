<?php

namespace App\Http\Controllers\SalesManager;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Session;
use App\Http\Controllers\home;
use App\Http\Controllers\Controller;
use App\Repositories\SalesManager\SalesManagerRepository;
use App\Repositories\CalendarRepository;
class SalesManagerController extends Controller
{
     public function __construct(home $home,SalesManagerRepository $SalesManagerRepository,CalendarRepository $CalendarRepository)
	{
		$this->home= $home;
		$this->SalesManagerRepository = $SalesManagerRepository;
		$this->CalendarRepository     = $CalendarRepository;
	}
    //
	public function SalesManagerDashboard()
	{
	   $user_id = session('usrs_userid');
	   $agent_access        = $this->home->get_dashboard_menu($user_id);
	   $SmDashboardResult   = $this->SalesManagerRepository->SalesManagerDashboardSlot();
	   return view('SalesManager.SalesManager',array('title' => 'Slot Dashboard', 'description' =>'Slot Dashboard ' , 'page' => 'Slot Dashboard','get_dashborad_data' => $agent_access,'SmDashboardResult'=>$SmDashboardResult));
	}
	
	public function SalesManagerWeeklyRequestFn()
	{
		$slot_id             = trim($_REQUEST['slot_id']);
		$territory_id        = trim($_REQUEST['territory_id']);
		$calen_id            = trim($_REQUEST['calendar_id']);
		$get_week_id         = trim($_REQUEST['week_id']);
		$get_all_user_data   = Session::all();
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		
		
		$agent_access        = $this->home->get_dashboard_menu($sess_user_id);
		//$get_week_id         = $this->CalendarRepository->get_lw_WeekId_func($slot_id,$territory_id,$calen_id);
		//$get_week_id = $get_week_id[0]['lw_WeekId'];
		// Calendar View
		$slot_relation_det   = $this->CalendarRepository->getSlotBySlotId_func($slot_id,$territory_id,$calen_id);
		
        $week_start_date 	= $slot_relation_det[0]['lw_WeekStartDate'];
	    $week_end_date 		= $slot_relation_det[0]['lw_WeekEndDate'];
	    $date_count = 0;
        $lms_datemasters    = $this->CalendarRepository->lms_datemasters_fun();
		$weekly_app_result = $this->CalendarRepository->weekly_app_func($slot_id,$territory_id,$calen_id,$get_week_id);
		
		return view('SalesManager/salesmanagerweeklyappoint',array('title' => 'Weekly Appointment Request', 'description' =>'Calendar Management' , 'page' => 'Calendar Management','get_dashborad_data' => $agent_access,'get_week_id'=>$get_week_id,'get_week_request'=>$_REQUEST,'slot_relation_det'=>$slot_relation_det,'weekly_app_result'=>$weekly_app_result));
	}
}
