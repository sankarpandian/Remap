<?php

namespace App\Http\Controllers\Ajax_Process;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\lms_customerdetails;
use App\Calendar_Models\lms_timemasters;
use App\Calendar_Models\lms_times;
use App\Calendar_Models\lms_datemasters;
use GuzzleHttp\Client;
use App\Calendar_Models\lms_calendarterritories;
use App\Models\lms_customerslots;
use App\Models\lms_calendars;
use App\Models\lms_branches;
use App\Calendar_Models\lms_weeks;
use App\Calendar_Models\lms_slots;
use App\Calendar_Models\lms_slotrelations;
use App\Calendar_Models\lms_slotstatus;
use App\Repositories\CalendarRepository;
use App\Models\mdm_storezipcodeterritory;
use App\Models\mdm_storezipcodeproducts;
use App\Models\mdm_remapcitystates;
use App\Models\lms_calldetails;
use App\Repositories\CallerScreenRepository;
use App\Models\mdm_remapdnis;
class AjaxProcessController extends Controller
{
    //
	public function __construct(lms_customerdetails $lms_customerdetails,lms_calldetails $lms_calldetails,lms_timemasters $lms_timemasters,lms_times $lms_times,lms_datemasters $lms_datemasters,lms_calendarterritories $lms_calendarterritories,lms_weeks $lms_weeks,lms_slots $lms_slots,lms_slotrelations $lms_slotrelations,lms_calendars $lms_calendars,lms_slotstatus $lms_slotstatus,CalendarRepository $CalendarRepository,CallerScreenRepository $CallerScreenRepository,mdm_remapdnis $mdm_remapdnis)
	{
		$this->lms_customerdetails = $lms_customerdetails;
		$this->lms_calldetails 		= $lms_calldetails;
		$this->lms_timemasters    = $lms_timemasters;
		$this->lms_times           = $lms_times;
		$this->lms_datemasters    = $lms_datemasters;
		$this->lms_calendarterritories = $lms_calendarterritories;
		$this->lms_weeks           = $lms_weeks;
		$this->lms_slots           = $lms_slots;
		$this->lms_slotrelations  = $lms_slotrelations;
		$this->lms_calendars       = $lms_calendars;
		$this->lms_slotstatus     = $lms_slotstatus;
		$this->CalendarRepository  = $CalendarRepository;
		$this->CallerScreenRepository=$CallerScreenRepository;
		$this->mdm_remapdnis      = $mdm_remapdnis;
	}
	public function call_from_ajax_fun()
	{
		//return 'hi';
		//echo 'hello';
		//print_r($_REQUEST['ajax_mode']);
		switch($_REQUEST['ajax_mode'])
		{
		 case "get_call_desc_list":

            $call_from   = $_REQUEST["call_from"];

            $ivr_service = trim($_REQUEST["ivr_service"]);

            if ($ivr_service == "fail") {

                //if ivr service fails - Display only checked description on zip mgmt

                /*$fet_remp_url = "http://qa.facelifters.com/staging/zipmgt/webservice/get_dnis_frm_ctgry_fail.php";
				
				$client = new Client();
				$res    = $client->request('POST', $fet_remp_url, [
					'form_params'  => [
						'category' => urlencode($call_from),
					]
				]);
				$result = $res->getBody()->getContents();
				*/ 
				//echo 'hihi1';
				$users = $this->CallerScreenRepository->associate_dnis_desc($call_from);
			    $users= json_encode($users); 
				//return response()->json(['response' => $users]);
				return $users;
				//print_r($users);
				//for($i=0;count($users);$i++)
				//{
				//	echo $users[$i]->prospect_id;
				//}
				
				/*echo '<select name="dnis_info" id="dnis_info"><option value="">Select One</option>';
				foreach($users as $listData)
				{
					echo '<option value="'.$listData->mdnis_ProspectId.'" desc="Customer Care Referral" dnis="'.$listData->mdnis_Dnis.'" companycode="'.$listData->mdnis_CompanyCode.'" prospectid="'.$listData->mdnis_ProspectId.'">'.$listData->mdnis_Source.'</option>';
				}
				echo '</select>';*/

            } elseif ($ivr_service == "success") {

              /*  $fet_remp_url = "http://qa.facelifters.com/staging/zipmgt/webservice/get_dnis_frm_ctgry_fail.php";
				
				$client = new Client();
				$res    = $client->request('POST', $fet_remp_url, [
					'form_params'  => [
						'category' => urlencode($call_from),
					]
				]);
				$result = $res->getBody()->getContents();
              */
			 // echo 'hihi2';
			  $users =$this->CallerScreenRepository->associate_dnis_desc($call_from);
			 /*  echo '<select name="dnis_info" id="dnis_info"><option value="">Select One</option>';
				foreach($users as $listData)
				{
					echo '<option value="'.$listData->mdnis_ProspectId.'" desc="Customer Care Referral" dnis="'.$listData->mdnis_Dnis.'" companycode="'.$listData->mdnis_CompanyCode.'" prospectid="'.$listData->mdnis_ProspectId.'">'.$listData->mdnis_Source.'</option>';
				}
				echo '</select>';*/
				$users= json_encode($users); 
				return $users;
            }

            //echo $url;

            //echo "<br />";

            //http://facelifters.com/forms/zipmgt/webservice/get_dnis_frm_ctgry.php?category=Other

            //http://facelifters.com/forms/zipmgt/webservice/get_dnis_frm_ctgry.php?category=HD&desc=Home%20Depot%20Stores

            /*$ch = curl_init(); // initialize curl handle

            curl_setopt($ch, CURLOPT_URL, $url); // set url to post to

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable

            $result = curl_exec($ch); // run the whole process
*/
            //echo $result; //contains response from server 
            
            break;
			
			case "validate_storeno":
			echo 'hihi';
			break;
			
			case "get_product_list":
			//echo 'hihi';
			$zipcode    = $_REQUEST["zipcode"];

            $result_arr = $this->getCityStateTerritoryInfo($zipcode);

            $result     = json_encode($result_arr);

            echo $result;
			break;
			
			case 'get_zipcodecitycounty_list':
			$zipcode    = $_REQUEST["zipcode"];
            $result_arr = $this->getCityStateTerritoryInfo1($zipcode);
            $result     = json_encode($result_arr);
            echo $result;
			break;
			
			case 'insert_brach_calen':
			
			
	$calen_day           = trim($_REQUEST['calen_day']);
	$calendar_name       = trim($_REQUEST['calendar_name']);
	$calenadr_id  = $this->CalendarRepository->get_calendar_id($calendar_name);
	$calen_hour_array    = $_REQUEST['calen_hour_array'];
	$calen_minutes_array = $_REQUEST['calen_minutes_array'];
	$calen_ampm_array    = $_REQUEST['calen_ampm_array'];
	for($i=0;$i<count($calen_hour_array);$i++)
	 {
	 $calen_time         = $calen_hour_array[$i].":".$calen_minutes_array[$i]." ".$calen_ampm_array[$i];
	 $calen_time_check   = $this->lms_timemasters
	                            ->leftJoin('lms_times',"lms_timemasters.ltm_TimeId","=","lms_times.lt_TimeId")
								->select('lms_timemasters.ltm_TimeMasterId')
	                            ->where('lms_timemasters.ltm_CalenProduct','=',$calenadr_id)
								->where('lms_timemasters.ltm_DateMasterId','=',$calen_day)
								->where('lms_times.lt_TimeMaster','=',$calen_time)
								->get();
							
			if(count($calen_time_check)==0)
			{
				$this->lms_times->insert(['lt_TimeMaster'=>$calen_time,'lt_CalenProduct'=>$calenadr_id]);
				
				$time_id = $this->lms_times->max('lt_TimeId');
				     
				$this->lms_timemasters->insert(['ltm_DateMasterId'=>$calen_day,'ltm_TimeId'=>$time_id,'ltm_CalenProduct'=>$calenadr_id,'ltm_Active'=>'1']);
				
				$time_master_id = $this->lms_timemasters->max('ltm_TimeMasterId');
						
			}
			
			else
			{
				 echo $msg="already";
			}
      }
	  
	  $date_master_details = $this->lms_datemasters
								  ->select('*')
								  ->orderBy('ldm_DateMasterId','Asc')
								  ->get();
	  $date_and_time =array();						  
      for($i=0;$i<count($date_master_details);$i++)								  
	  {
		   $date_master_id    = $date_master_details[$i]['ldm_DateMasterId'];
		   $date_master_name  = $date_master_details[$i]['ldm_DateMaster'];
		   $date_and_time[]   = $this->time_list_fun($date_master_id,$calenadr_id);
		   $date_and_time[$i]['date_master_name'] = $date_master_name;
		  //$date_and_time['date_master_id'] = $date_master_id;
		 // echo $data;
	  }
	return $date_and_time;
		
	 
	  //$time_query="select * from lms_time_master inner join lms_time ON lms_time_master.time_id=lms_time.time_id where lms_time_master.calen_product='$calendar_name' and date_master_id='$date_master_id' order by lms_time.time_id asc";
	  
	  break;
	  case 'list_calen_page':
	     $calendar_id       = trim($_REQUEST['calendar_id']);
		 $date_master_details = $this->lms_datemasters
									  ->select('*')
									  ->orderBy('ldm_DateMasterId','Asc')
									  ->get();
		  $date_and_time =array();						  
		  for($i=0;$i<count($date_master_details);$i++)								  
		  {
			   $date_master_id    = $date_master_details[$i]['ldm_DateMasterId'];
			   $date_master_name  = $date_master_details[$i]['ldm_DateMaster'];
			   $date_and_time[]   = $this->time_list_fun($date_master_id,$calendar_id);
			   $date_and_time[$i]['date_master_name'] = $date_master_name;
			  //$date_and_time['date_master_id'] = $date_master_id;
			 // echo $data;
		  }
		return $date_and_time;
	  break;
	  case 'all_territory_calen':
	
	    $calendar_name       = trim($_REQUEST['calendar_name']);
		$result              = $this->lms_calendarterritories
		->leftJoin('lms_calendars', 'lms_calendars.lc_CalendarId', '=', 'lms_calendarterritories.lct_CalendarId')
		->leftJoin('lms_branches', 'lms_branches.lb_TerritoryId', '=', 'lms_calendarterritories.lct_TerritoryId')
		->select('lms_calendars.lc_CalendarName','lms_branches.lb_TerritoryName','lms_branches.lb_TerritoryId')
		->where('lms_calendars.lc_CalendarName', '=',$calendar_name)
		->where('lms_calendarterritories.lct_OpenStatus', '=','open')
		//	->groupBy('lms_calendarterritories.lmsct_territory_id')
		->get();
	 
	  return $result;
	  break;
	  
	  case 'delete_appointment_slot_time':
	   $lmst_time_id       = trim($_REQUEST['lmst_time_id']);
	   $calendar_name      = trim($_REQUEST['calendar_name']);
	   $calendar_res       = $this->lms_calendars->select('lc_CalendarId')
	                              ->where('lc_CalendarName','=',$calendar_name)
								  ->get();
		$calendar_id       = $calendar_res[0]['lc_CalendarId'];
	   $this->lms_times->where('lt_TimeId', '=', $lmst_time_id)->delete();
	   
	   
	   $date_master_details = $this->lms_datemasters
								  ->select('*')
								  ->orderBy('ldm_DateMasterId','Asc')
								  ->get();
	  $date_and_time =array();						  
      for($i=0;$i<count($date_master_details);$i++)								  
	  {
		   $date_master_id    = $date_master_details[$i]['ldm_DateMasterId'];
		   $date_master_name  = $date_master_details[$i]['ldm_DateMaster'];
		   $date_and_time[]   = $this->time_list_fun($date_master_id,$calendar_id);
		   $date_and_time[$i]['date_master_name'] = $date_master_name;
		  //$date_and_time['date_master_id'] = $date_master_id;
		 // echo $data;
	  }
	return $date_and_time;
	   
	   
	  break;
	  case 'change_to_approve':
	 /* $territory_id       = trim($_REQUEST['territory_id_app']);
	  $calendar_id        = trim($_REQUEST['calendar_id_app']);
	  //$territory_id_app   = trim($_REQUEST['territory_id_app']);
	
	  $date = date('Y-m-d');
	  $week_result =  $this->CalendarRepository->get_week_id_func();
	  $week_id     =  $week_result[0]['week_id'];
      
	  $org_week_slots 	= 38;
	  
	  
	  //to get slot from present week
	  $result = $this->CalendarRepository->get_slot_details($week_id,$territory_id,$calendar_id);
      $tot_slots_from_present_week 	= count($result); 
	  $range_of_weeks 				= $org_week_slots - $tot_slots_from_present_week;
	  echo "my range".$range_of_weeks."<br>";
	  if($range_of_weeks>0)
		{
			//looping to fit the slots as 24 from present week
			for($i=0;$i<$range_of_weeks;$i++)
			{
				$week_id++;
				//adding slot for future weeks
							
				$this->lms_slots->insert(['lmss_week_id'=>$week_id,'lmss_company_id'=>1,'lmss_week_reps'=>0,'lmss_total_reps'=>0,'lmss_slot_comments'=>'test','lmss_slot_projected_date'=>$date,'lmss_slot_status_id'=>'3','lmss_pending_review'=>'','lmss_pending_review'=>0,'lmss_created_date'=>$date,'lmss_updated_date'=>$date,'lmss_territory_id'=>$territory_id,'lmss_calen_product'=>$calendar_id]);
				 $slot_id = $this->lms_slots->max('lmss_slot_id');  
				
				

				//To get all slots for all week day at right times
		        $result_tm = $this->lms_datemasters->select('*')->get();
		  for($k=0;$k<count($result_tm);$k++)
		  {
			 
			 $lmsdm_date_master_id   = $result_tm[$i]['lmsdm_date_master_id']; 
			 $result_lms_time_master = $this->lms_timemasters
			  ->join("lms_times","lms_times.lmst_time_id","=","lms_timemasters.lmstm_time_id")
			  ->select('lms_timemasters.lmstm_time_master_id')
			  ->where('lms_timemasters.lmstm_date_master_id','=',$lmsdm_date_master_id)
			  ->where('lms_timemasters.lmstm_calen_product','=',$calendar_id)->get();
			
			 echo "slot_id_first".$slot_id;echo "<br>";
			 echo 'result_count'.count($result_lms_time_master)."<br>";
			//if(count($result_lms_time_master)!=0)
			//{
				for($j=0;$j<count($result_lms_time_master);$j++)
				{
					 echo "slot_id".$slot_id;echo "<br>";
					
					$lms_time_master_id = $result_lms_time_master[$j]['lmstm_time_master_id'];
					
					$result_exist = $this->lms_slotrelations->select("*")
					->where("lmssr_company_id","=","1")
					->where("lmssr_slot_id","=",$slot_id)
					->where("lmssr_date_master_id","=",$lmsdm_date_master_id)
					->where("lmssr_time_master_id","=",$lms_time_master_id)
					->get();
					
					if(count($result_exist)==0)
					{
					$this->lms_slotrelations->insert(['lmssr_company_id'=>1,'lmssr_slot_id'=>$slot_id,'lmssr_date_master_id'=>$lmsdm_date_master_id,'lmssr_time_master_id'=>$lms_time_master_id,'lmssr_old_manager_request'=>0,'lmssr_manager_request'=>0,'lmssr_recommended'=>0,'lmssr_previous'=>0,'lmssr_actual'=>0,'lmssr_allocated'=>0,'lmssr_confirmation_actual'=>0,'lmssr_confirmation_allocated'=>0,'lmssr_sched_manual'=>0,'lmssr_conf_manual'=>0]);
					}
				} 
			//}
		  }
				
			echo $test ='slot updated for 24 weeks';	
			}
			//$final_res[$territory_count++] = array("territory_name" => $territory_name, "status" => "slot updated for 24 weeks");
		
			  
		}
		else
		{
			//$final_res[$territory_count++] = array("territory_name" => $territory_name, "status" => "slot already exists for 24 weeks");
			$test = 'slot already exists for 24 weeks';
			
		}
	 
	 // return 'Approve';
	  break;
	  */
	  
	  $territory_id       = trim($_REQUEST['territory_id']);
	  $calendar_id_app    = trim($_REQUEST['calendar_id_app']);
	  $calendar_terr_id   = trim($_REQUEST['calendar_terr_id']);
	  $form_submit   = trim($_REQUEST['form_submit']);
	  $calendar_weeks= 5;
	  
      $this->lms_calendarterritories
	       ->where('lct_CalendarTerritoryId',$calendar_terr_id)
           ->update(['lct_ApproveStatus' =>'Approve']);
	 
     for($k=1;$k<=$calendar_weeks;$k++)
	 {  
		if($k==1) 
		{
		$result_week_id = $this->lms_weeks->select('lw_WeekId')
		->where('lw_WeekStartDate','<=','now()')
		->where('lw_WeekEndDate','>=','now()')
		->get(); 
		$current_week_id=$result_week_id[0]['lw_WeekId']; 
	    $week_id=$current_week_id;
		}
		else
		{
				$result_week_id   = $this->lms_slots
				->select('ls_WeekId')
				->where('ls_CalenProduct','=',$calendar_id_app)
				->where('ls_TerritoryId','=',$territory_id)
				->orderBy('ls_SlotId', 'desc')->first(0);
				$week_id=$result_week_id['ls_WeekId']+1;
				$slot_id1 = $this->lms_slots->max('ls_SlotId');  
		}
	  $date = date('Y-m-d');
      $this->lms_slots->insert(['ls_WeekId'=>$week_id,'ls_CompanyId'=>1,'ls_WeekReps'=>0,'ls_TotalReps'=>0,'ls_SlotComments'=>'test','ls_SlotProjectedDate'=>$date,'ls_SlotStatusId'=>'3','ls_PendingReview'=>0,'ls_CreatedDate'=>$date,'ls_UpdatedDate'=>$date,'ls_TerritoryId'=>$territory_id,'ls_CalenProduct'=>$calendar_id_app]);	
	  // get the slot id
	 $slot_id = $this->lms_slots->max('ls_SlotId');  
	 $result_tm = $this->lms_datemasters->select('*')->get();
	
	for($i=0;$i<count($result_tm);$i++)
	  {
		 $lmsdm_date_master_id   = $result_tm[$i]['ldm_DateMasterId']; 
		 $result_lms_time_master = $this->lms_timemasters->select('ltm_TimeMasterId')
		                                ->where('ltm_DateMasterId','=',$lmsdm_date_master_id)
		                                ->where('ltm_CalenProduct','=',$calendar_id_app)
										->get();
										
		for($j=0;$j<count($result_lms_time_master);$j++)
		{
			$lms_time_master_id = $result_lms_time_master[$j]['ltm_TimeMasterId'];
			if($k==1) 
			{
			
			$this->lms_slotrelations->insert(['lsr_CompanyId'=>1,'lsr_SlotId'=>$slot_id,'lsr_DateMasterId'=>$lmsdm_date_master_id,'lsr_TimeMasterId'=>$lms_time_master_id,'lsr_OldManagerRequest'=>0,'lsr_ManagerRequest'=>0,'lsr_Recommended'=>0,'lsr_Previous'=>0,'lsr_Actual'=>0,'lsr_Allocated'=>0,'lsr_ConfirmationActual'=>0,'lsr_ConfirmationAllocated'=>0]);
			}
			else
			{
				
				$result_slot_relation   = $this->lms_slots
				->leftJoin("lms_slotrelations","lms_slots.ls_SlotId","=","lms_slotrelations.lsr_SlotId")
				->select('lms_slotrelations.lsr_OldManagerRequest','lms_slotrelations.lsr_ManagerRequest','lms_slotrelations.lsr_Recommended','lms_slotrelations.lsr_Previous','lms_slotrelations.lsr_Actual','lms_slotrelations.lsr_Allocated','lms_slotrelations.lsr_ConfirmationActual','lms_slotrelations.lsr_ConfirmationAllocated')
				->where('lms_slots.ls_CalenProduct','=',$calendar_id_app)
				->where('lms_slots.ls_TerritoryId','=',$territory_id)
				->where('lms_slotrelations.lsr_DateMasterId','=',$lmsdm_date_master_id)
				->where('lms_slotrelations.lsr_TimeMasterId','=',$lms_time_master_id)
				->where('lms_slotrelations.lsr_SlotId','=',$slot_id)
				->get();
				//echo "<br>last array";echo count($result_slot_relation); echo "<br>";
				
				@$lmssr_old_manager_request=$result_slot_relation[0]['lsr_OldManagerRequest'];
				@$lmssr_manager_request=$result_slot_relation[0]['lsr_ManagerRequest'];
				@$lmssr_recommended=$result_slot_relation[0]['lsr_Recommended'];
				@$lmssr_previous=$result_slot_relation[0]['lsr_Previous'];
				@$lmssr_actual=$result_slot_relation[0]['lsr_Actual'];
				@$lmssr_allocated=$result_slot_relation[0]['lsr_Allocated'];
				@$lmssr_confirmation_actual=$result_slot_relation[0]['lsr_ConfirmationActual'];
				@$lmssr_confirmation_allocated=$result_slot_relation[0]['lsr_ConfirmationAllocated'];
				
				$this->lms_slotrelations->insert(['lsr_CompanyId'=>1,'lsr_SlotId'=>$slot_id,'lsr_DateMasterId'=>$lmsdm_date_master_id,'lsr_TimeMasterId'=>$lms_time_master_id,'lsr_OldManagerRequest'=>@$lmssr_old_manager_request,'lsr_ManagerRequest'=>@$lmssr_manager_request,'lsr_Recommended'=>@$lmssr_recommended,'lsr_Previous'=>@$lmssr_previous,'lsr_Actual'=>@$lmssr_actual,'lsr_Allocated'=>@$lmssr_allocated,'lsr_ConfirmationActual'=>@$lmssr_confirmation_actual,'lsr_ConfirmationAllocated'=>@$lmssr_confirmation_allocated]);
				
				
			}
			
			
		} 
		
		
	  } 
	 }
		
		
	 
	  //print_r($result_lms_time_master);
	  return 'Approve';
	  break;
	  case 'change_to_reject':
	  $territory_id       = trim($_REQUEST['territory_id']);
	  
	  
	  $this->lms_calendarterritories
	       ->where('lct_CalendarTerritoryId',$territory_id)
           ->update(['lct_ApproveStatus' =>'Reject']);
	  return 'Reject';
	  break;
	  
	  case 'change_to_pending':
	  $territory_id       = trim($_REQUEST['territory_id']);
	  $this->lms_calendarterritories
	       ->where('lct_CalendarTerritoryId',$territory_id)
           ->update(['lct_ApproveStatus' =>'Pending']);
	  return 'Pending';
	  break;
	  
	  case 'delete_territory':
	  
	   $territory_id_arr       = $_REQUEST['territory_id_arr'];
	   $calendar_name          = trim($_REQUEST['calendar_name']);
	   $calendar_id            = $this->lms_calendars->where('lc_CalendarName',$calendar_name)->value('lc_CalendarId');
	   $this->lms_calendarterritories->whereIn('lct_TerritoryId',$territory_id_arr)
	        ->delete();
	   
		$result              = $this->lms_calendarterritories
		->leftJoin('lms_calendars', 'lms_calendars.lc_CalendarId', '=', 'lms_calendarterritories.lct_CalendarId')
		->leftJoin('lms_branches', 'lms_branches.lb_TerritoryId', '=', 'lms_calendarterritories.lct_TerritoryId')
		->select('lms_calendars.lc_CalendarName','lms_branches.lb_TerritoryName','lms_branches.lb_TerritoryId')
		->where('lms_calendars.lc_CalendarName', '=',$calendar_name)
		->where('lms_calendarterritories.lct_OpenStatus', '=','open')
		//	->groupBy('lms_calendarterritories.lmsct_territory_id')
		->get();
        return $result;		
	  break;
	  
	  case 'weekly_requested_details':
	
	 $week_id        = $_REQUEST['week_id'];
	 $territory_id    = $_REQUEST['lmsa_branch'];
	 
	 $reult   = $this->lms_slots->join('lms_weeks','lms_weeks.lw_WeekId','=','lms_slots.ls_WeekId')
	 ->join('lms_slotstatus','lms_slotstatus.lss_SlotStatusId','=','lms_slots.ls_SlotStatusId')
	 ->join('lms_branches','lms_branches.lb_TerritoryId','=','lms_slots.ls_TerritoryId')
	 ->select('*')
	 ->where('lms_slots.ls_WeekId','=',$week_id)
	 ->where('lms_slots.ls_TerritoryId','=',$territory_id)
	 ->get();
	 return $reult;										
	 break;
	 case 'update_pending_review':
	 //print_r($_REQUEST);
	 $lmss_slot_id       = trim($_REQUEST['lmss_slot_id']);
	 $lmss_territory_id  = trim($_REQUEST['lmss_territory_id']);
	 $lmss_week_reps     = trim($_REQUEST['lmss_week_reps']);
	 $lmss_total_reps    = trim($_REQUEST['lmss_total_reps']);
	 $week_start_date    = trim($_REQUEST['week_start_date']);
	 $message            = trim($_REQUEST['message']);
	 $lmss_calen_id      = trim($_REQUEST['lmss_calen_product']);
	 $rows_slot = $this->CalendarRepository->getSlotBySlotId_func($lmss_slot_id,$lmss_territory_id,$lmss_calen_id);
	 
	 $pending_review = 1;
		//to make slot status as approve to submitted or maintain submitted status(i.e. Under Review)
		if( (int)$rows_slot[0]['lmss_slot_status_id'] == 2 || (int)$rows_slot[0]['lmss_slot_status_id'] == 3 || (int)$rows_slot[0]['lmss_slot_status_id'] == 1 )
		{
			//Submitted or Approved status to Submitted
			$lmss_slot_status_id = 2;							
		}
		elseif( (int)$rows_slot[0]['lmss_slot_status_id'] == 4 || (int)$rows_slot[0]['lmss_slot_status_id'] == 5 )
		{
			$lmss_slot_status_id = 4;		
		}
	$this->CalendarRepository->updateSlot($lmss_week_reps, $lmss_total_reps, $message, $week_start_date, $lmss_slot_status_id, $pending_review, $lmss_slot_id, $lmss_territory_id);
	return 'success';
	 break;
	 
	 case "agent_display_board":
	 /*$territory_id        = $_REQUEST['territory_id'];
	 $week_id             = $_REQUEST['week_id'];
	 $lmss_calen_id       = $_REQUEST['lmss_calen_id'];
	 $slot_id             = $_REQUEST['slot_id'];
	 $weekly_app_result = $this->CalendarRepository->weekly_app_func($slot_id,$territory_id,$lmss_calen_id,$week_id);
	 return $weekly_app_result;*/
	 break;
	}
}
	
	public function time_list_fun($date_master_id,$calendar_id)
	{
		$time_details    = $this->lms_times
	                 ->join('lms_timemasters','lms_timemasters.ltm_TimeId','=','lms_times.lt_TimeId')
					 ->select('*')
					 ->where('lms_timemasters.ltm_CalenProduct','=',$calendar_id)
					 ->where('lms_timemasters.ltm_DateMasterId','=',$date_master_id)
					 ->orderBy('lms_times.lt_TimeId','Asc')
					 ->get();
		
		return $time_details;
	}
	public function insertCallerScreen_fun()
	{
		$call_from 			= trim( $_REQUEST['call_from'] );	
		$hd_type_id 		= $_REQUEST['hd_type_id'];

		$store_id		 	= "";
		$associate_id 		= "";
		$isp_id				= "";
		
		$customer_presence	= 0;
				
		
		//slide 2
		
		$title			 = $_REQUEST['title']; 	
		$first_name		 = $_REQUEST['first_name']; 
		$last_name		 = $_REQUEST['usrs_lastname']; 
		$zipcode		 = $_REQUEST['zipcode']; 
		$territory_id_fet  = $this->CalendarRepository->get_territoryCode_based_zipcode($zipcode);
		$store_id        = '';
		$store_id        = trim( $_REQUEST['store_no'] );
		$lld_ProductCode = trim($_REQUEST['lld_ProductCode']);
		$dnis_info       = trim($_REQUEST['dnis_info']);
		$prospect_id	 = $dnis_info.date('m').date('y').$territory_id_fet.$lld_ProductCode;
		
		$appdate       = trim($_REQUEST['get_date_dis']);
		$appTime       = trim($_REQUEST['get_time_dis']);
		$territory_id  = trim($_REQUEST['territory_id']);
				
		//slide 3
		
	//$call_status_id			= 1; //Not Available
	$hometype_id			=trim( $_REQUEST['hometype_id'] ) ;
	
	if( $hometype_id == 3 || $hometype_id == 4  || $hometype_id == 7 )
	{
		//Case - Home Type Condo, Townhouse	
		$apt_unit			= trim( $_REQUEST['apt_unit'] ) ;
	}
	else
	{
		$apt_unit			= "";	
	}
	
	$customer_mode_id   	= 4; //Not Available
	$spouse_name			= "";
	$customer_address		= "";
	$customer_city			=  trim( $_REQUEST['customer_city'] );
	$customer_state			=  trim( $_REQUEST['customer_state'] );
	$customer_territory		=  trim( $_REQUEST['customer_territory'] );
	$customer_county		=  trim( $_REQUEST['customer_county'] );
	$lcd_Address_email      =  trim( $_REQUEST['lcd_Address_email']);
	
	$customer_cross_street	= ""; 
	$customer_community		= "";
	$house_color			= "";

	$home_phone				= "";
	$work_phone				= "";
	$work_phone_ext			= "";
	
	$cell_phone				= "";
	$customer_comments		= "";
	$customer_presence		=  trim( $_REQUEST['customer_presence'] );
    
	$home_phone				=  trim( $_REQUEST['home_phone']);
	$work_phone				=  trim( $_REQUEST['work_phone']);
	$customer_comments		=  trim( $_REQUEST['customer_comments']);
	//if( $work_phone != "" )
	//{
	//	$work_phone_ext			=  trim( $_REQUEST['work_phone_ext']);
	//}
	
	$cell_phone				=  trim( $_REQUEST['cell_phone']);
	//Case - Not owner or Owner
	if( isset( $_REQUEST['not_owner'] ) )
	{
		//not_owner true
		$hometype_id		= 6; //Not Available
		$review_case		= "not_owner";
		$call_status_id		= 9; //case - not owner
	}
	else
	{
		
		if((int)$hometype_id == 5)
		{
			//Case - Mobile Home
			$review_case		= "mobile_home";
			$call_status_id 	= 7; //case - mobile home 
		}
		else
		{
			$call_status_id		= 1; //case - not available
			$review_case		= "normal";

			$customer_mode_id		=  trim( $_REQUEST['customer_mode_id'] );
			if( (int)$customer_mode_id == 1 )
			{
				//Case - Spouse/Co-Owner selected
				$spouse_name		=  trim( $_REQUEST['spouse_name'] );
			}
			else
			{
				//Case 1-Leg or Sole Owner selected
				$spouse_name		= "";
			}
			
			$customer_address		=  trim( $_REQUEST['customer_address']);
			$customer_city			=  trim( $_REQUEST['customer_city']);
			$customer_county	    =  trim( $_REQUEST['customer_county']);
			$customer_state			=  trim( $_REQUEST['customer_state']);
			$zipcode			    =  trim( $_REQUEST['zipcode']);
		   
			$customer_cross_street	= ""; 
			$customer_community		= "";
			$house_color			= "";
		   /* if(isset($lcd_AptUnit))
			{
				$lms_customerdetails->lcd_AptUnit = $lcd_AptUnit;  // 
			}
			else
			{
			$lms_customerdetails->lcd_AptUnit = '0';  // 
			}*/
			$home_phone				=  trim( $_REQUEST['home_phone']);
			$work_phone				=  trim( $_REQUEST['work_phone']);
			if( $work_phone != "" )
			{
				$work_phone_ext			=  trim( $_REQUEST['work_phone_ext']);
			}
			
			$cell_phone				=  trim( $_REQUEST['cell_phone']);
			$customer_comments		=  trim( $_REQUEST['customer_comments']);
			$customer_presence		=  trim( $_REQUEST['customer_presence']); 
			
			
			$work_phone_mode		=  trim( $_REQUEST['work_phone_mode']);
			$cell_phone_mode		=  trim( $_REQUEST['cell_phone_mode']);
			$customer_cross_street	=  trim( $_REQUEST['customer_cross_street']); 
			if( (int)$customer_presence == 1)
			{
				//case - if customer present
				//$customer_cross_street	=  trim( $_REQUEST['customer_cross_street'] ) ); 
				$customer_community		=  trim( $_REQUEST['customer_community']);
				$house_color			=  trim( $_REQUEST['house_color']);
			}
		}
	}
		
		
		
		
		
		
		$this->lms_customerdetails->insert(
		[
		'lcd_Title'           => $title,
		'lcd_FirstName'       => $first_name,
		'lcd_LastName'        => $last_name,
		'lcd_Zipcode'         => $zipcode,
		'lcd_OwnerTypeId'     => $zipcode,
		'lcd_HomeTypeId'      => $customer_mode_id,
		'lcd_CoownerName'     => $spouse_name,
		'lcd_Address'         => $customer_address,
		'lcd_CrossStreet'     => $customer_cross_street,
		'lcd_City'            => $customer_city,
		'lcd_County'          => $customer_county,
		'lcd_AptUnit'         => '',
		'lcd_HousecColor'     => $house_color,
		'lcd_EmailAddress'    => $lcd_Address_email,
		'lcd_Community'       => $customer_community,
		'lcd_HomePhone'       => $home_phone,
		'lcd_WPTitle'         => '',
		'lcd_WorkPhone'       => $home_phone,
		'lcd_CPTitle'         => '',
		'lcd_CellPhone'       => $cell_phone,
		'lcd_Territory'       => $customer_territory,
		'lcd_Comments'        => $customer_comments,
		]
		);
	
	    $customer_id = $this->lms_customerdetails->max('lcd_CustomerId');
  
		$lld_ProsepctId   = "";
		$lld_Calldesc     = "";
	    $lms_calldetails = new lms_calldetails;
		$lms_calldetails->lld_CustomerId  = $customer_id;
		$lms_calldetails->lld_ProsepctId  = $prospect_id;
		$lms_calldetails->lld_ProductCode = $lld_ProductCode;
		if(!empty($call_from))
		{
		$lms_calldetails->lld_CallFromId = $call_from;
		}
		if(!empty($lld_ProsepctId))
		{
		//$lms_calldetails->lld_ProsepctId = $lld_ProsepctId.date('my').$lld_ProductCode;
		$lms_calldetails->lld_ProsepctId = $lld_Calldesc;
		}
		
		$lms_calldetails->lld_SlotId = 0; //
		$lms_calldetails->lld_CallbackId = 0; //
		$lms_calldetails->lld_VerificationCode = 0; //
		if(!empty($store_id))
		{
		$lms_calldetails->lld_StoreId = $store_id;
		}
		if(!empty($associate_id))
		{
		$lms_calldetails->lld_AssociateId = $associate_id;
		}
		
		$lms_calldetails->lld_CallStatusId = 2;
		$lms_calldetails->lld_NonProductId = 0;
		$lms_calldetails->lld_AgentCreatedBy = '1000';
		$lms_calldetails->lld_AgentUpdatedBy = '1000';
		$lms_calldetails->lld_AssignedBy = '0';
		$lms_calldetails->lld_ResultedBy = '0';
		$lms_calldetails->lld_CallTypeId = $hd_type_id; //
		$lms_calldetails->lld_OriginSourceId = '0';
		$lms_calldetails->lld_LiveStatus = '';
		$lms_calldetails->lld_LeadBucketID = '2'; //
		$lms_calldetails->lld_RepAssigned = '0';
		$lms_calldetails->lld_RepResulted = '0';
		$lms_calldetails->lld_PriorityOrder = '0';
		$lms_calldetails->lld_PrioritySetDate = date('Y-m-d H:i:s');
		$lms_calldetails->lld_FinishCallButton = 1;
		$lms_calldetails->lld_CallDateTime = date('Y-m-d H:i:s');
		$lms_calldetails->lld_RecordCreatedDateTime = date('Y-m-d H:i:s');
		$lms_calldetails->lld_RescheduleCreatedDateTime = date('Y-m-d H:i:s');
		$lms_calldetails->lld_LastModifiedDate = date('Y-m-d H:i:s');;
		$lms_calldetails->save();
		
	$actual = $this->CalendarRepository->slotDetailsForAllLeads($appdate,$appTime,$zipcode,$customer_id,$territory_id);
		
		
	if($actual=='success')		
	return 'success';
    else 
	return 'not available'; 
	}
	
	public function getCityStateTerritoryInfo($zipcode)
	{
		$zipcode 	= str_pad( $zipcode, 5, "0", STR_PAD_LEFT);
		$fet_remp_url = "http://qa.facelifters.com/staging/zipmgt/webservice/get_city_state_product_ws.php?zip=".$zipcode;
				
				$client = new Client();
									$res    = $client->request('POST', $fet_remp_url, [
										'form_params'  => [
											
										]
									]);
		$xml_result= $res->getBody()->getContents();
		$doc = new \DOMDocument();
		$doc->loadXML( $xml_result );
					
		$el = $doc->getElementsByTagName('var'); // presuming your tag is the only element in the document
		$error = $doc->getElementsByTagName('error')->item(0)->getAttribute('description');
		
		$result_arr = array( "zipcode_city" => $el->item(0)->getAttribute('expr'), "zipcode_state" => $el->item(1)->getAttribute('expr'),"zipcode_products" => $el->item(2)->getAttribute('expr'),"zipcode_territory" => $el->item(3)->getAttribute('expr'),"zipcode_territory_name" => $el->item(4)->getAttribute('expr'),"zipcode_time_zone" => $el->item(5)->getAttribute('expr'), "zipcode_error" => $error);	
		return $result_arr;						
	
	}
	
	public function getCityStateTerritoryInfo1($zipcode)
	{
		$zipcode 	= str_pad( $zipcode, 5, "0", STR_PAD_LEFT);
		
		$url = "http://dev.facelifters.com/dev/zipmgt/webservice/get_city_state_county_product_ws.php?zip=".$zipcode;
		$client = new Client();
							$res    = $client->request('POST', $url, [
								'form_params'  => [
									
								]
							]);
		$xml_result= $res->getBody()->getContents();
		
		
		$elem = new \SimpleXMLElement($xml_result); //print_r($elem);
		$state 			= $elem->state;		
		$products 		= $elem->products;		
		$territory  	= $elem->territory;		
		$territory_name = $elem->territory_name;		
		$time_zone  	= $elem->time_zone;	
		$city1='';
		foreach ($elem as $city) {
			
			if($city['name']=='Cityname')
			{
				for($j=0;$j<$city->count();$j++)
				{
					 if($city1=='')
					 {
						$city1 .= trim($city->child[$j]);	 
					 }
					 else
					 {
						$city1 .=",".trim($city->child[$j]);	 
					 }
				}
		 
			}
		}
		
		$county1='';
		foreach ($elem as $county) {
			
			if($county['name']=='Countyname')
			{
				for($j=0;$j<$county->count();$j++)
				{
					 if($county1=='')
					 {
						$county1 .=trim($county->child[$j]);	 
					 }
					 else
					 {
						$county1 .=",".trim($county->child[$j]); 
					 }
				}
		 
			}
		}
		
		
		$state1='';
		foreach ($elem as $state) {
			
			if($state['name']=='state')
			{
			 $state1 .=$state[0];
			}
			
		}
		
		$territory1='';
		foreach ($elem as $territory) {
			
			if($territory['name']=='territory')
			{
			 $territory1 .=$territory[0];
			}
			
		}
		
		$products1='';
		foreach ($elem as $products) {
			
			if($products['name']=='products')
			{
			 $products1 .=$products[0];
			}
			
		}
		
		

		$result_arr 				 =	array();
		$result_arr['state']		 =	$state1;
		$result_arr['products'] 	 =	$products1;
		$result_arr['territory']	 =	$territory1;
		$result_arr['territory_name']=	$territory_name;
		$result_arr['time_zone']	 =  $time_zone;
		$result_arr['city']	 		 =  $city1;
		$result_arr['county']	 	 =  $county1;
		
		
		return $result_arr;
	}
	
	public function ajax_appointment_date()
	{
		 $date=$_GET['date'];
		 $zipcode = $_REQUEST['zipcode'];
		 $territory_id_fet = $this->CalendarRepository->get_territory_based_zipcode($zipcode);
		 $calendar_id_fet  = $this->CalendarRepository->get_calendar_based_territory($territory_id_fet);
			//echo $date;
			$week_id=lms_weeks::where('lw_WeekStartDate','<=',$date)->where('lw_WeekEndDate','>=',$date)->value('lw_WeekId');
			$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
			//echo $slot_id;
			$date_master_id=date('w',strtotime($date));
			
			//echo $time_master_id;
			//return json_encode($time_master_id);

			$time=lms_timemasters::select('lms_times.lt_TimeMaster')->join('lms_slotrelations','lms_timemasters.ltm_TimeMasterId', '=', 'lms_slotrelations.lsr_TimeMasterId')
			->join('lms_times', 'lms_timemasters.ltm_TimeId', '=','lms_times.lt_TimeId')
			->where('lms_timemasters.ltm_DateMasterId',$date_master_id)->where('lms_timemasters.ltm_CalenProduct',$calendar_id_fet)
			->where('lms_slotrelations.lsr_SlotId',$slot_id)->where('lms_slotrelations.lsr_DateMasterId',$date_master_id)->get();
			//->whereRaw('lms_slotrelations.lsr_Actual - lms_slotrelations.lsr_Allocated > 0')
			return json_encode($time);

			/*$time_master_id = lms_timemasters::join('lms_times', 'lms_timemasters.lmstm_time_id', '=','lms_times.lmst_time_id')
			->where('lmstm_date_master_id',$date_master_id)->where('lmstm_calen_product','AUGUST')->pluck('lmstm_time_master_id');
			$actual = lms_slotrelations::where('slot_id',$slot_id)->where('date_master_id',$date_master_id)
			->whereIn('time_master_id',$time_master_id)->whereRaw('actual-allocated > 0')->get();
			
			$actual = lms_slotrelations::join('lms_timemasters', function ($query) use ($time_master_id) {
        ->on('lms_timemasters.lmstm_time_master_id', '=', 'lms_slotrelations.time_master_id')->whereRaw('actual-allocated > 0');
    })->whereIn('time_master_id', $time_master_id)->where('slot_id',$slot_id)->where('date_master_id',$date_master_id);
			return json_encode($actual);*/
	}
	
	public function ajax_call_from()
	{
		$lld_CallFromId=$_GET['lld_CallFromId'];
		$call_from_description=mdm_remapdnis::select('mrd_ProspectId','mrd_CompanyCode','mrd_Source')
		->where('mrd_CategoryId',$lld_CallFromId)->get();
		return json_encode($call_from_description);
	}
	
	public function ajax_zipcode()
	{
		$lcd_Zipcode=$_GET['lcd_Zipcode'];
		$kitchen=mdm_storezipcodeproducts::select('mszp_StoreZipcodeProductid')->join('mdm_storezipcodeterritory','mdm_storezipcodeterritory.mszt_Store','=','mdm_storezipcodeproducts.mszp_Store')
		->where('mszp_Zipcodes',$lcd_Zipcode)
		->whereColumn('mszp_Kitchen','=','mszt_Kitchen')
		->where('mszp_Kitchen','!=',87)->get();
		
		$bath=mdm_storezipcodeproducts::join('mdm_storezipcodeterritory','mdm_storezipcodeterritory.mszt_Store','=','mdm_storezipcodeproducts.mszp_Store')
		->where('mszp_Zipcodes',$lcd_Zipcode)
		->whereColumn('mszp_Bath', '=', 'mszt_Bath')
		->where('mszp_Bath','!=',87)->get();

		$garage=mdm_storezipcodeproducts::join('mdm_storezipcodeterritory','mdm_storezipcodeterritory.mszt_Store','=','mdm_storezipcodeproducts.mszp_Store')
		->where('mszp_Zipcodes',$lcd_Zipcode)
		->whereColumn('mszp_Garage', '=', 'mszt_Garage')
		->where('mszp_Garage','!=',87)->get();

		$closet=mdm_storezipcodeproducts::join('mdm_storezipcodeterritory','mdm_storezipcodeterritory.mszt_Store','=','mdm_storezipcodeproducts.mszp_Store')
		->where('mszp_Zipcodes',$lcd_Zipcode)
		->whereColumn('mszp_Closet', '=', 'mszt_Closet')
		->where('mszp_Closet','!=',87)->get();

		$city=mdm_remapcitystates::select('mrcs_City')->where('mrcs_Zipcode',$lcd_Zipcode)->groupBy('mrcs_City')->get();
		$county=mdm_remapcitystates::select('mrcs_County')->where('mrcs_Zipcode',$lcd_Zipcode)->groupBy('mrcs_County')->get();
		$state=mdm_remapcitystates::select('mrcs_State')->where('mrcs_Zipcode',$lcd_Zipcode)->groupBy('mrcs_State')->get();
		//$product=array("a" => $kitchen, "b" => $bath)
		//print_r(expression)
		//return json_encode($city);
		$territory_code=lms_branches::select('lb_TerritoryCode')->join('mdm_storezipcodeproducts','lms_branches.lb_TerritoryId','=','mdm_storezipcodeproducts.mszp_Kitchen')
  ->where('mszp_Zipcodes',$lcd_Zipcode)->get();
       $territory_id=lms_branches::select('lb_TerritoryId')->join('mdm_storezipcodeproducts','lms_branches.lb_TerritoryId','=','mdm_storezipcodeproducts.mszp_Kitchen')
  ->where('mszp_Zipcodes',$lcd_Zipcode)->get();

  return json_encode(array("kitchen"=>$kitchen,"bath"=>$bath,"garage"=>$garage,"closet"=>$closet,"city"=>$city,"county"=>$county,"state"=>$state,"territory_code"=>$territory_code,"territory_id"=>$territory_id));
		
		//if($bath!=null)
		//{
			//$bath1="Bath";
		//}
		//print_r(json_encode(array("a" => $kitchen, "b" => $bath)));
	}
	
	public function inbound_ajax_zipcode()
	{
		$zipcode           = $_REQUEST['zipcode'];
		$week_id           = $_REQUEST['week_id'];
		$org_week_id       = $_REQUEST['org_week_id'];
		$territory_id_fet  = $this->CalendarRepository->get_territory_based_zipcode($zipcode);
		$calendar_id_fet   = $this->CalendarRepository->get_calendar_based_territory($territory_id_fet);
		if($week_id=='')
		{
		 $week_id           = lms_weeks::where('lw_WeekStartDate','<=','now()')->where('lw_WeekEndDate','>=','now()')->value('lw_WeekId');
		}
		
		$slot_id           = lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
		$weekly_app_result = $this->CalendarRepository->weekly_app_func($slot_id,$territory_id_fet,$calendar_id_fet,$week_id);
		return $weekly_app_result;
	}
	public function quickresult_result()
	{
		$call_status=$_REQUEST['call_statusid'];
		$customer_id=$_REQUEST['lld_CustomerId'];
		//echo $call_status;
		$this->lms_calldetails
		->where("lld_CustomerId","=",$customer_id)->
		update(
		[
		'lld_CallStatusId' =>$call_status,
		]);
		return 'success';
	}
	public function quickresult_inbound()
	{
		
		
		$call_from           = "";
		$dnis_info           = "";
		$hd_type_id          = "";
		$associate_id        = "";
		$store_no            = "";
		$customer_presence   = "";
		$title               = "";
		$first_name          = "";
		$usrs_lastname       = "";
		$zipcode             = "";
		$hometype_id         = "";
		$not_owner           = "";
		$spouse_name         = "";
		$spouse_name         = "";
		$spouse_name         = "";
		$customer_county     = "";
		$customer_city       = "";
		$customer_state      = "";
		$customer_cross_street  = "";
		$customer_territory     = "";
		$customer_community     = "";
		$house_color            = "";
		$home_phone             = "";
		$cell_phone             = "";
		$customer_comments      = "";
		$lcd_Address_email      = "";
		$lld_ProductCode        = "";
		$work_phone             = "";
		$get_time_dis           = "";
		$get_date_dis           = "";
		$territory_id           = "";
		extract($_REQUEST);
		
		$lms_customerdetails  = new lms_customerdetails;
		$lms_customerdetails->lcd_Presence    = $customer_presence;
		$lms_customerdetails->lcd_CallById    = '0';
		$lms_customerdetails->lcd_Title       = $title;
		$lms_customerdetails->lcd_FirstName   = $first_name;
		$lms_customerdetails->lcd_LastName    = $usrs_lastname;
		$lms_customerdetails->lcd_Zipcode     = $zipcode;
		//$lms_customerdetails->lcd_OwnerTypeId = $lcd_OwnerTypeId;
		//$lms_customerdetails->lcd_HomeTypeId  = $hometype_id;  //
		/*$lcd_CoownerName = "";
		if(isset($lcd_CoownerName))
		{
		$lms_customerdetails->lcd_CoownerName = $lcd_CoownerName;
		}
		else
		{
		$lms_customerdetails->lcd_CoownerName = '';
		}*/
		$lms_customerdetails->lcd_Address     = $customer_address;
		$lms_customerdetails->lcd_CrossStreet = $customer_cross_street;
		$lms_customerdetails->lcd_City        = $customer_city;
		$lms_customerdetails->lcd_County      = $customer_county;
		$lms_customerdetails->lcd_State       = $customer_state;
		if(isset($apt_unit))
		{
			$lms_customerdetails->lcd_AptUnit = $apt_unit;  // 
		}
		else
		{
		    $lms_customerdetails->lcd_AptUnit = '0';  // 
		}
		$lms_customerdetails->lcd_HousecColor   = $house_color;
		$lms_customerdetails->lcd_EmailAddress  = $lcd_Address_email;
		$lms_customerdetails->lcd_Community     = $customer_community; //
		$lms_customerdetails->lcd_HomePhone     = $home_phone;
		//$lms_customerdetails->lcd_WPTitle       = $lcd_WPTitle;
		$lms_customerdetails->lcd_WorkPhone     = $work_phone;
		//$lms_customerdetails->lcd_CPTitle       = $lcd_CPTitle;
		$lms_customerdetails->lcd_CellPhone     = $cell_phone; //
		$lms_customerdetails->lcd_Territory     = $territory_id; //
		$lms_customerdetails->lcd_Comments      = $customer_comments;
		
		$lms_customerdetails->save();
		$CustomerId                      = $lms_customerdetails->lcd_CustomerId;
		$lms_calldetails                  = new lms_calldetails;
		$lms_calldetails->lld_CustomerId  = $CustomerId;
		$lms_calldetails->lld_ProductCode = $lld_ProductCode;
		if(!empty($call_from))
		{
		$lms_calldetails->lld_CallFromId = $call_from;
		}
		//if(!empty($lld_ProsepctId))
		//{
		// $lms_calldetails->lld_ProsepctId = $lld_ProsepctId;
		//}
		
		//$lms_calldetails->lld_SlotId      = 0; //
		//$lms_calldetails->lld_CallbackId  = 0; //
		//$lms_calldetails->lld_VerificationCode = 0; //
		if(!empty($store_no))
		{
		$lms_calldetails->lld_StoreId    = $store_no;
		}
		if(!empty($associate_id))
		{
		$lms_calldetails->lld_AssociateId = $associate_id;
		}
	/*	if(isset($appointment_date) && $appointment_date!="")
		{
			$lms_calldetails->lld_CallStatusId     =2;
		}
		else
		{
			$lms_calldetails->lld_CallStatusId     =33;
		}
		*/
		$lms_calldetails->lld_NonProductId   = 0;
		//$lms_calldetails->lld_AgentCreatedBy = $tsr_number;
		//$lms_calldetails->lld_AgentUpdatedBy = $conf_number;
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
	
		$lms_customerslots=new lms_customerslots();
	    $lms_customerslots->lcs_CustomerId = $CustomerId;
		$lms_customerslots->save();
		return 'success';
	}
	public function ajax_oot()
	{
		$oot = $_REQUEST['oot'];
		$customer_id=$_REQUEST['lld_CustomerId'];
		$this->lms_calldetails
		->where("lld_CustomerId","=",$customer_id)->
		update(
		[
		'lld_CallStatusId' =>$oot,
		]);
		return json_encode("success");
	}
	public function ajax_non_product()
	{
		$non_product_status = $_REQUEST['non_product_status'];
		$customer_id=$_REQUEST['lld_CustomerId'];
		$nonproduct=$_REQUEST['nonproduct'];
		$this->lms_calldetails
		->where("lld_CustomerId","=",$customer_id)->
		update(
		[
		'lld_CallStatusId' =>$nonproduct,
		'lld_NonProductId' =>$non_product_status,
		]);
		return json_encode("success");
	}
	public function dup_homephone()
	{

		switch($_REQUEST['ajax_mode'])
		{
		case "inboundHomephone":
		$homephone=$_REQUEST['homephone'];
		// subtract 10 days from date
		$from_date = Date('Y-m-d H:i:s', strtotime("-90 days"));
		$to_date   = date('Y-m-d H:i:s');
     	$requested_start_date  = date("Y-m-d H:i:s",strtotime($from_date));
		$requested_end_date    = date("Y-m-d H:i:s",strtotime($to_date));
 		$homephone_check_query = $this->lms_customerdetails
									->select('lcd_HomePhone','created_at')
									->where('lcd_HomePhone', '=', $homephone)
									->whereBetween('created_at',[$requested_start_date, $requested_end_date])
									->get();
		$count_query=count($homephone_check_query);
		return $count_query;									
		break;
		
		case "otherBucketHomephone":
		$homephone = $_REQUEST['homephone'];
		$custid    = $_REQUEST['lld_CustomerId'];
		// subtract 10 days from date
		$from_date = Date('Y-m-d H:i:s', strtotime("-10 days"));
		$to_date   = date('Y-m-d H:i:s');
     	$requested_start_date  = date("Y-m-d H:i:s",strtotime($from_date));
		$requested_end_date    = date("Y-m-d H:i:s",strtotime($to_date));
 		$homephone_check_query = $this->lms_customerdetails
									->select('lcd_HomePhone','created_at')
									->where('lcd_HomePhone', '=', $homephone)
									->whereNotIn('lcd_CustomerId',[$custid])
									->whereBetween('created_at',[$requested_start_date, $requested_end_date])
									->get();
		$count_query=count($homephone_check_query);
		return $count_query;
		break;
	}

	}	
	
}
