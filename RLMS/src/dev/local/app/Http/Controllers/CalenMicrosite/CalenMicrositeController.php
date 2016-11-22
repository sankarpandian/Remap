<?php

namespace App\Http\Controllers\CalenMicrosite;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Repositories\CalendarRepository;
use App\Calendar_Models\lms_weeks;
use App\Calendar_Models\lms_slots;
use App\Calendar_Models\lms_slotrelations;
use App\Calendar_Models\lms_timemasters;
use App\Calendar_Models\lms_times;
use App\Calendar_Models\lms_datemasters;
use App\Models\lms_scheduleappointslots;
class CalenMicrositeController extends Controller
{
    public function __construct(home $home,CalendarRepository $CalendarRepository)
	{
		$this->CalendarRepository  = $CalendarRepository;
		$this->home= $home;		
	}

 public function micrositeFunc()
 {
 	 $user_id = session('usrs_userid');
 	//$user_id =1;
    $list_dashborad_data = $this->home->get_dashboard_menu($user_id);
    $lms_scheduleappointslots = new lms_scheduleappointslots();
	//echo 'hihi';
	//$zipcode = '30123';
	
	//$date    = date('Y-m-d');
	
         $date        = $_REQUEST['date'];
         $zipcode     = $_REQUEST['zipcode'];
		 $timezone    = $_REQUEST['timezone'];
		 $companyid   = $_REQUEST['companyid'];
		 $requestid   = $_REQUEST['requestid'];
		 $conformlead = $_REQUEST['conformlead'];
		
		 if(isset($_REQUEST['timemasterid']))
		 {
			$timemasterid = $_REQUEST['timemasterid'];
			$lms_scheduleappointslots
			->where('lsa_RequestId',$requestid)
			->where('lsa_TimeMasterId',$timemasterid)
			->where('lsa_LoackStatus','Active')
			->update(['lsa_LoackStatus' =>'Lock']);
			
			$lms_scheduleappointslots
			->where('lsa_RequestId',$requestid)
			->where('lsa_LoackStatus','Active')
			->update(['lsa_LoackStatus' =>'InActive']); 
		$lms_times = new lms_times();	
		$result = $lms_times
			->select('lt_TimeMaster')
			->where('lt_TimeId',$timemasterid)
			->first();
			echo '<div><br> <br><b>'.$result['lt_TimeMaster'].'</b> The record has been submited';
			echo '</div>';
		 }
		 else
		 {
			 $territory_id_fet = $this->CalendarRepository->get_territory_based_zipcode($zipcode);
			 $calendar_id_fet  = $this->CalendarRepository->get_calendar_based_territory($territory_id_fet);
			//echo $date;
			$week_id=lms_weeks::where('lw_WeekStartDate','<=',$date)->where('lw_WeekEndDate','>=',$date)->value('lw_WeekId');
			  $slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
			//echo $slot_id;
			$date_master_id=date('w',strtotime($date));

			//echo $time_master_id;
			//return json_encode($time_master_id);

			$time=lms_timemasters::select('lms_times.lt_TimeMaster','lms_timemasters.ltm_TimeMasterId','lms_times.lt_TimeId','lms_slotrelations.lsr_SlotRelationId')->join('lms_slotrelations','lms_timemasters.ltm_TimeMasterId', '=', 'lms_slotrelations.lsr_TimeMasterId')
			->join('lms_times', 'lms_timemasters.ltm_TimeId', '=','lms_times.lt_TimeId')
			->where('lms_timemasters.ltm_DateMasterId',$date_master_id)->where('lms_timemasters.ltm_CalenProduct',$calendar_id_fet)
			->where('lms_slotrelations.lsr_SlotId',$slot_id)->where('lms_slotrelations.lsr_DateMasterId',$date_master_id)->get();
			//->whereRaw('lms_slotrelations.lsr_Actual - lms_slotrelations.lsr_Allocated > 0')
			//	return json_encode($time);
			  
			if(count($time)>0)
			{
			echo '<div align="center" style="margin-top:200px">';
			echo '<form method="GET" action="calenmicrosite">';
			echo '<input type="hidden" name="date" value="'.$date.'">';
			echo '<input type="hidden" name="zipcode" value="'.$zipcode.'">';
			echo '<input type="hidden" name="timezone" value="'.$timezone.'">';
			echo '<input type="hidden" name="companyid" value="'.$companyid.'">';
			echo '<input type="hidden" name="requestid" value="'.$requestid.'">';
			echo '<input type="hidden" name="conformlead" value="'.$conformlead.'">';
			echo '<select name="timemasterid" id="timemasterid">';
			for($i=0;$i<count($time);$i++)
			{
			$getTime   = $time[$i]['lt_TimeMaster']; 
			$lt_TimeMasterId = $time[$i]['lt_TimeId']; 
			echo '<option value="'.$lt_TimeMasterId.'">'.$getTime.'</option>';
			}

			echo '</select>';
			echo '<input type="submit" name="submit">';
			echo '</form>';
            echo '</div>';
			if(isset($requestid) & $requestid!='')
			  {
				  
				$result =  $lms_scheduleappointslots->select('lsa_RequestId')
							->where("lsa_RequestId","=",$requestid)
							->get();
				if(count($result)>0)
				{
					$lms_scheduleappointslots
					->where('lsa_RequestId',$requestid)
					->update(['lsa_LoackStatus' =>'Inactive']);
				}
			  }
			for($j=0;$j<count($time);$j++)
			{
			$lt_TimeMasterId = $time[$j]['lt_TimeId']; 
			$lms_scheduleappointslots->insert([
			['lsa_RequestId' => $requestid, 'lsa_SlotId' => $slot_id,'lsa_DateMasterId' => $date_master_id, 'lsa_TimeMasterId' =>$lt_TimeMasterId, 'lsa_TimeZone' =>$timezone, 'lsa_LoackStatus' =>'Active']
			]);
			}



			}
			else
			{
			echo 'NO slot';  
			}
	
    }
  }
  
  public function lockTimeSlotFunc()
  {
	  $lms_scheduleappointslots = new lms_scheduleappointslots();
	  extract($_REQUEST);
	 print_r($_REQUEST);
	  $result = $lms_scheduleappointslots
	            ->select('*')
				->where('lsa_SlotId',$slot_id)
				->where('lsa_LoackStatus','Lock')
				->where('lsa_RequestId',$requestId)
				->get();
	 if(count($result)>0)	
	 {
		 //Inactive for old one
 $lms_scheduleappointslots
->where('lsa_RequestId',$requestId)
->update(['lsa_LoackStatus' =>'Inactive']);
// Insert new lock details		
$lms_scheduleappointslots->lsa_RequestId        =  $requestId;
$lms_scheduleappointslots->lsa_SlotId           =  $slot_id;
$lms_scheduleappointslots->lsa_DateMasterId     =  $dateMasterId;
$lms_scheduleappointslots->lsa_TimeMasterId     =  $timeMasterId;
$lms_scheduleappointslots->lsa_TimeZone         =  $timezone;
$lms_scheduleappointslots->lsa_LoackStatus      =  'Lock';
$lms_scheduleappointslots->lsa_LockCalenStatus  =  $schedule_confirm_value;
$lms_scheduleappointslots->save();
	 }
	 else
	 {
$lms_scheduleappointslots->lsa_RequestId        =  $requestId;
$lms_scheduleappointslots->lsa_SlotId           =  $slot_id;
$lms_scheduleappointslots->lsa_DateMasterId     =  $dateMasterId;
$lms_scheduleappointslots->lsa_TimeMasterId     =  $timeMasterId;
$lms_scheduleappointslots->lsa_TimeZone         =  $timezone;
$lms_scheduleappointslots->lsa_LoackStatus      = 'Lock';
$lms_scheduleappointslots->lsa_LockCalenStatus  = $schedule_confirm_value;
$lms_scheduleappointslots->save();
	 }
				
				
  }
}
