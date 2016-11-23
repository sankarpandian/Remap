<?php

namespace App\Http\Controllers\Calendar_Mgt;
use Illuminate\support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Models\lms_branches;
use App\Repositories\CalendarRepository;
use App\Calendar_Models\lms_slotrelations;
class Callendar_Mgt_Controller extends Controller
{
    //
	public function __construct(home $home,lms_branches $lms_branches,CalendarRepository $CalendarRepository,lms_slotrelations $lms_slotrelations)
	{
		$this->home          = $home;
		$this->lms_branches  = $lms_branches;
		$this->CalendarRepository = $CalendarRepository;
		$this->lms_slotrelations = $lms_slotrelations;
	}
	
	public function Callendar_Mgt_Fun()
	{
		$get_all_user_data   = Session::all();
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		
		
		$agent_access        = $this->home->get_dashboard_menu($sess_user_id);
		$get_all_branch      = $this->CalendarRepository->get_all_branch_fun();
		$get_week_id         = $this->CalendarRepository->get_lw_WeekId_func();
		return view('calendar_mgt/calendar_mgt_con',array('title' => 'Calendar Management', 'description' =>'Calendar Management' , 'page' => 'Calendar Management','get_dashborad_data' => $agent_access,'get_all_branch'=>$get_all_branch,'get_week_id'=>$get_week_id));
	}
	
	public function weeklyAppointRequestFun()
	{
		//echo 'hihihi';
		//print_r($_REQUEST);
		$slot_id             = trim($_REQUEST['slot']);
		$branch_id           = trim($_REQUEST['branch']);
		$territory_id        = trim($_REQUEST['territory']);
		$calen_id            = trim($_REQUEST['calen']);
		$get_all_user_data   = Session::all();
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		
		
		$agent_access        = $this->home->get_dashboard_menu($sess_user_id);
		$get_week_id         = $this->CalendarRepository->get_lw_WeekId_func($slot_id,$territory_id,$calen_id);
		$get_week_id = $get_week_id[0]['lw_WeekId'];
		// Calendar View
		$slot_relation_det   = $this->CalendarRepository->getSlotBySlotId_func($slot_id,$territory_id,$calen_id);
		
        $week_start_date 	= $slot_relation_det[0]['lw_WeekStartDate'];
	    $week_end_date 		= $slot_relation_det[0]['lw_WeekEndDate'];
	    $date_count = 0;
        $lms_datemasters    = $this->CalendarRepository->lms_datemasters_fun();
		/*
		for($i=0;$i<count($lms_datemasters);$i++)
		{
			
			echo $week_day		= $lms_datemasters[$i]['lmsdm_date_master'];
	        $week_day_id	    = $lms_datemasters[$i]['lmsdm_date_master_id'];
			$date_display	    = date( "m/d/Y", strtotime("$week_start_date + $date_count day") );
			$TimeByDate     = $this->CalendarRepository->getTimeByDate($week_day_id,$calen_id,$territory_id);
			
			for($j=0;$j<count($TimeByDate);$j++)
			{  
		       // echo $slot_relation_det[0]['lmss_slot_id'];echo '<br>';
				  $date_master_id 	= $TimeByDate[$j]['lmstm_date_master_id'];
				  $time_master_id 	= $TimeByDate[$j]['lmstm_time_master_id']; 
				echo  $time_master    	= $TimeByDate[$j]['lmst_time_master']; 
				  $lms_datemasters[$i]['lmst_time_master']=$time_master;
				  
				$result_slot_r = $this->lms_slotrelations->select('*')
		                      ->where("lmssr_slot_id","=",$slot_relation_det[0]['lmss_slot_id'])  
							  ->where("lmssr_date_master_id","=",$date_master_id)
							  ->where("lmssr_time_master_id","=",$time_master_id)
							  ->get();
							  
				for($k=0;$k<count($result_slot_r);$k++)
				{
					echo $result_slot_r[$k]['lmssr_manager_request'];
					echo'<br>';
					echo'<br>';
				}
			}
			
		}
		*/
		$weekly_app_result = $this->CalendarRepository->weekly_app_func($slot_id,$territory_id,$calen_id,$get_week_id);
		//echo count($weekly_app_result);
        //exit;
		return view('calendar_mgt/weekly_appoint',array('title' => 'Weekly Appointment Request', 'description' =>'Calendar Management' , 'page' => 'Calendar Management','get_dashborad_data' => $agent_access,'get_week_id'=>$get_week_id,'get_week_request'=>$_REQUEST,'slot_relation_det'=>$slot_relation_det,'weekly_app_result'=>$weekly_app_result));
	}
}
