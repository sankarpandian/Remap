<?php

namespace App\Http\Controllers\DuplicateRecords;

use DB;
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
use App\Models\lms_branches;

class DuplicateRecordsContoller extends Controller
{

	public function __construct(home $home,CalendarRepository $CalendarRepository,lms_customerdetails $lms_customerdetails,lms_branches $lms_branches)
	{
		$this->home= $home;
		$this->lms_customerdetails= $lms_customerdetails;
		$this->CalendarRepository=$CalendarRepository;
		$this->lms_branches=$lms_branches;

	}
    public function duplicate_records()
 	{
 	    $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
		$existing_calendar_data     = $this->CalendarRepository->lms_existing_calendar_fun();

		//Territory count

		/*$get_territory_count =$this->lms_branches
							       ->join('lms_customerdetails','lms_customerdetails.lcd_Territory', '=', 'lms_branches.lb_TerritoryId')
							       ->join('lms_calldetails', 'lms_calldetails.lld_CustomerId', '=', 'lms_customerdetails.lcd_CustomerId')
							       ->select('count(*) as user_count, lb_TerritoryId')
							       ->groupBy('lb_TerritoryId')
							       ->get();*/
							       
		$count = DB::table('lms_branches')->count();			       
							  
		print_r($count);



		$get_all_territories=$this->lms_branches->select('lb_TerritoryName')->get();
		//print_r($get_all_branches);
		return view('duplicates.duplicaterecords',array('title' => 'Territories List ', 'description' =>'Territories List' , 'page' => 'New Calendar','get_dashborad_data' => $agent_access,'existing_calendar_data'=>$existing_calendar_data,'get_all_territories' => $get_all_territories));
 	}
 	public function manage_duplicate_records()
 	{
 	    $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
		$existing_calendar_data     = $this->CalendarRepository->lms_existing_calendar_fun();
		return view('duplicates.manageduplicaterecords',array('title' => 'Duplicate Leads', 'description' =>'Duplicate Leads' , 'page' => 'New Calendar','get_dashborad_data' => $agent_access,'existing_calendar_data'=>$existing_calendar_data));
 	}
 	public function update_duplicate_records()
 	{
 	    $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
		$existing_calendar_data     = $this->CalendarRepository->lms_existing_calendar_fun();
		return view('duplicates.updateduplicaterecords',array('title' => 'Update Customer ', 'description' =>'Update Customer ' , 'page' => 'New Calendar','get_dashborad_data' => $agent_access,'existing_calendar_data'=>$existing_calendar_data));
 	}
}
