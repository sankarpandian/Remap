<?php

namespace App\Http\Controllers\Dynamic_Calendar;
use Illuminate\support\Facades\Session;
use App\Http\Controllers\home;
use App\Http\Controllers\Controller;
use App\Repositories\CalendarRepository;
class newCalendarController extends Controller
{
    //
	public function __construct(home $home,CalendarRepository $CalendarRepository)
	{
		$this->home= $home;
		$this->CalendarRepository=$CalendarRepository;
	}
	public function newCalendarFun()
	{
		//echo 'hihi';
		$get_all_user_data   = Session::all();
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		$agent_access        = $this->home->get_dashboard_menu($sess_user_id);
		$existing_calendar_data     = $this->CalendarRepository->lms_existing_calendar_fun();
		return view('calendar.new_calendar',array('title' => 'New Calendar', 'description' =>'New Calendar' , 'page' => 'New Calendar','get_dashborad_data' => $agent_access,'existing_calendar_data'=>$existing_calendar_data));
	}
	
	public function addCalendarFun()
	{
		$get_all_user_data   = Session::all();
	    $sess_user_id        = $get_all_user_data['usrs_userid'];
		$agent_access        = $this->home->get_dashboard_menu($sess_user_id);
		$lms_branch_data     = $this->CalendarRepository->lms_branches_fun();
		$lms_date_master_data     = $this->CalendarRepository->lms_datemasters_fun();
		
		return view('calendar.add_calendar',array('title' => 'Add Calendar', 'description' =>'Add Calendar' , 'page' => 'Add Calendar','get_dashborad_data' => $agent_access,'lms_branch_data'=>$lms_branch_data,'lms_date_master_data'=>$lms_date_master_data));
	}
	public function addBranchForCalendarFun()
	{
		//for view in add calendar page
		$get_all_user_data     = Session::all();
	    $sess_user_id          = $get_all_user_data['usrs_userid'];
		$agent_access          = $this->home->get_dashboard_menu($sess_user_id);
		$lms_branch_data       = $this->CalendarRepository->lms_branches_fun();
		$lms_date_master_data  = $this->CalendarRepository->lms_datemasters_fun();
		
		// post data from add calendar page
		$territory_array = "";
		$calendar_name   = trim($_POST['calendar_name']);
		$company_id      = trim($_POST['company_id']);
		$territory_imploded = implode(',',$_POST['territory_code']);
		//$terr_bran_submit= trim($_POST['submit']);
		//List Of lime slot function in add calendar page 
		$calenadr_id  = $this->CalendarRepository->get_calendar_id($calendar_name);
		$appointment_slot_data = $this->CalendarRepository->appointment_slot_function($calenadr_id);
		
		$lms_cal_terr_check     = $this->CalendarRepository->lms_ins_territory_branch_fun($calenadr_id,$company_id,$_POST['territory_code']);
		if($lms_cal_terr_check!='not_exist')
		{
			return view('calendar.add_calendar',array('title' => 'Add Calendar', 'description' =>'Add Calendar' , 'page' => 'Add Calendar','get_dashborad_data' => $agent_access,'lms_branch_data'=>$lms_branch_data,'lms_date_master_data'=>$lms_date_master_data,'lms_cal_terr_check'=>$lms_cal_terr_check,'appointment_slot_data'=>$appointment_slot_data));
		}
		else
		{
			return view('calendar.add_calendar',array('title' => 'Add Calendar', 'description' =>'Add Calendar' , 'page' => 'Add Calendar','get_dashborad_data' => $agent_access,'lms_branch_data'=>$lms_branch_data,'lms_date_master_data'=>$lms_date_master_data,'appointment_slot_data'=>$appointment_slot_data));
		}
		
	}
	
	public function add_new_branch_for_calr($calen_id)
	{		
		// created calendar and Territory
		$get_all_ter_cal_detail= $this->CalendarRepository->getTerritoryCalen_fun($calen_id);
		$territory_code_get = array();
		if(count($get_all_ter_cal_detail)>0)
		{
			$lms_calendar_id     = $get_all_ter_cal_detail[0]['lc_CalendarId'];
			$lms_company_id      = $get_all_ter_cal_detail[0]['lct_CompanyId'];
		    $lms_calendar_name   = $get_all_ter_cal_detail[0]['lc_CalendarName'];
			
			for($i=0;$i<count($get_all_ter_cal_detail);$i++)
			{
				$territory_code_get[] = $get_all_ter_cal_detail[$i]['lct_TerritoryId'];
			}	
		}
		
		//for view in add calendar page
		$get_all_user_data     = Session::all();
	    $sess_user_id          = $get_all_user_data['usrs_userid'];
		$agent_access          = $this->home->get_dashboard_menu($sess_user_id);
		$lms_branch_data       = $this->CalendarRepository->lms_branches_fun();
		$lms_date_master_data  = $this->CalendarRepository->lms_datemasters_fun();
		
		
		
		
		// created calendar and Territory
		if(count($territory_code_get)>0)
		{
		 //List Of time slot function in add calendar page 
		$appointment_slot_data = $this->CalendarRepository->appointment_slot_function($lms_calendar_id);
		
		$lms_cal_terr_check     = $this->CalendarRepository->lms_ins_territory_branch_fun($lms_calendar_id,$lms_company_id,$territory_code_get);
		
		return view('calendar.add_calendar',array('title' => 'Add Calendar', 'description' =>'Add Calendar' , 'page' => 'Add Calendar','get_dashborad_data' => $agent_access,'lms_branch_data'=>$lms_branch_data,'lms_date_master_data'=>$lms_date_master_data,'lms_cal_terr_check'=>$lms_cal_terr_check,'appointment_slot_data'=>$appointment_slot_data,'calendar_name_from_edit'=>$lms_calendar_name,'territory_code_from_edit'=>$territory_code_get));
		}
		else
		{
		return view('calendar.add_calendar',array('title' => 'Add Calendar', 'description' =>'Add Calendar' , 'page' => 'Add Calendar','get_dashborad_data' => $agent_access,'lms_branch_data'=>$lms_branch_data,'lms_date_master_data'=>$lms_date_master_data));	
		}
		
		
		
		
	}
	
}
