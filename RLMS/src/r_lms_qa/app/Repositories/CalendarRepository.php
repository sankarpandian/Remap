<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\lms_branches;
use App\Calendar_Models\lms_datemasters;
use App\Calendar_Models\lms_calendarterritories;
use App\Models\lms_calendars;
use App\Calendar_Models\lms_times;
use App\Calendar_Models\lms_weeks;
use App\Calendar_Models\lms_slots;
use App\Calendar_Models\lms_timemasters;
use App\Calendar_Models\lms_slotrelations;
use App\Models\lms_customerslots;

class CalendarRepository extends Model
{
    //
	public function __construct(lms_branches $lms_branches,lms_datemasters $lms_datemasters,lms_calendarterritories $lms_calendarterritories,lms_calendars $lms_calendars,lms_times $lms_times,lms_weeks $lms_weeks,lms_slots $lms_slots,lms_timemasters $lms_timemasters,lms_slotrelations $lms_slotrelations)
	{
		$this->lms_branches             =  $lms_branches;
		$this->lms_datemasters         =  $lms_datemasters;
		$this->lms_calendarterritories =  $lms_calendarterritories;
		$this->lms_calendars            =  $lms_calendars;
		$this->lms_times                =  $lms_times;
		$this->lms_weeks                =  $lms_weeks;
		$this->lms_slots                =  $lms_slots;
		$this->lms_timemasters         =  $lms_timemasters;
		$this->lms_slotrelations       =  $lms_slotrelations;
		
	}
				
	public function lms_branches_fun()
	{
		$lms_branches_res = $this->lms_branches
					   ->select('lb_TerritoryCode','lb_TerritoryName','lb_TerritoryId')
					   ->where('lb_CompanyId','=','1')
					   ->orderBy('lb_TerritoryName','Asc')
					   ->get();
		return $lms_branches_res;
	}
	
	public function lms_datemasters_fun()
	{
		$lms_datemasters_res = $this->lms_datemasters
					   ->select('*')
					   ->get();
		return $lms_datemasters_res;
	}
	
	public function lms_ins_territory_branch_fun($calendar_id,$company_id,$territory_array)
	{
	
$calendar_id         = trim($calendar_id);
$company_id          = trim($company_id);
$result              = $this->lms_calendarterritories
->leftJoin('lms_calendars', 'lms_calendars.lc_CalendarId', '=', 'lms_calendarterritories.lct_CalendarId')
->leftJoin('lms_branches', 'lms_branches.lb_TerritoryId', '=', 'lms_calendarterritories.lct_TerritoryId')
->select('lms_calendars.lc_CalendarName','lms_branches.lb_TerritoryName','lms_branches.lb_TerritoryId')
->where('lms_calendars.lc_CalendarId', '=',$calendar_id)
->where('lms_calendarterritories.lct_OpenStatus', '=','open')
->whereIn('lms_calendarterritories.lct_TerritoryId',$territory_array)
//	->groupBy('lms_calendarterritories.lmsct_territory_id')
->get();
	
		$error_ter='';
	    if(count($result)>0)
		{
			
			// getting existing territory List 
			for($i=0;$i<count($result);$i++)
			{
				$territory_name_exist[] = $result[$i]['lb_TerritoryName']; 
				$territory_id_exist[]   = $result[$i]['lb_TerritoryId']; 
			}
			if(count($territory_id_exist)>0)
			{
				$list_territory='';
				//$error_ter.='<p style="color:red">The given territory already exits as the calendar name of "'.$calendar_name.'" </p>';
				//$error_ter.='<ul style="list-style-type: none;">';
				$error_ter1='';
				for($i=0;$i<count($territory_name_exist);$i++)
				{
					// $error_ter1.='<li>';
					// $error_ter1.='<b>'.$territory_name_exist[$i].'</b>';
					// $error_ter1.='</li>';
					 $exist_territory_id    = $territory_id_exist[$i];
					 $exist_territory_name[]=$territory_name_exist[$i];
				}
				
				//$error_ter.=$error_ter1.'<ul>';
				
				
			}
			
			
			// Insert the calendar name to lms_calendars table
	/*	$cal_nam_res=$this->lms_calendars->select('*')
		                  ->where('lmsc_calendar_name','=',$calendar_name)
			              ->get();
			if(count($cal_nam_res)>0)
			{
				$calendar_id=$cal_nam_res[0]['lmsc_calendar_id'];
			}
			else
			{
				$insert_query=$this->lms_calendars->insert(['lmsc_calendar_name'=>$calendar_name,'lmsc_created_date'=>'now()']);
				$calendar_id=$insert_query->lmsc_calendar_id;
			}	
		*/	
		 // insert the data to lms_calendarterritories	
		$territory_code_exit = array_diff($territory_array,$territory_id_exist);
		
		
			if(count($territory_code_exit)>0)
			{
				
				foreach($territory_code_exit as $territory_data)
				{
					
					$cal_terr_result = $this->lms_calendarterritories->select('*')
											->where('lct_CalendarId','=',$calendar_id)
											->where('lct_TerritoryId','=',$territory_data)
											->get();
					
								
					if(count($cal_terr_result)==0)
					{
						
						//$db->execQuery("update lms_calendar_territory set active_status='0' where territory_id='$territory_data'");
						
						$this->lms_calendarterritories->insert(['lct_CompanyId'=>1,'lct_CalendarId'=>$calendar_id,'lct_TerritoryId'=>$territory_data,'lct_OpenStatus'=>'open','lct_ActiveStatus'=>'1']);
					//	$this->lms_calendarterritories
						//     ->where('territory_id',$territory_data)
						
						
					}
					
				}
			}
			else
			{
				
				foreach($territory_array as $territory_data)
				{
					
					$cal_terr_result = $this->lms_calendarterritories->select('*')
											->where('lct_CalendarId','=',$calendar_id)
											->where('lct_TerritoryId','=',$territory_data);
									
					if(count($cal_terr_result)==0)
					{
						//$db->execQuery("update lms_calendar_territory set active_status='0' where territory_id='$territory_data'");
						
						$this->lms_calendarterritories->insert(['lct_CalendarId'=>$calendar_id,'lct_TerritoryId'=>$territory_data,'lct_OpenStatus'=>'open','lct_ActiveStatus'=>'1']);
						
					}
					
				}
			}
		return $result;
			
		}
		else
		{
			
			
			// If lms_calendarterritories data not exist here the will be inserted to lms_calendarterritories
			/*$get_calen_result = $this->lms_calendars
			                         ->select('*') 
									 ->where('lmsc_calendar_name','=',$calendar_name)
									 ->get();
			if(count($get_calen_result)>0)
			{
				$calendar_id=$get_calen_result[0]['lmsc_calendar_id'];
			}
			else
			{
				$result=$this->lms_calendars->insert(['lmsc_calendar_name'=>$calendar_name,'lmsc_created_date'=>'now()']);
				$calendar_id = $this->lms_calendars->max('lmsc_calendar_id');;
				//$calendar_id = $result[0]->lmsc_calendar_id;
				
				
			}*/
			foreach($territory_array as $territory_data)
			{
				$get_cal_terr_res = $this->lms_calendarterritories
				                         ->select('*') 
										 ->where('lct_CalendarId','=',$calendar_id)
										 ->where('lct_TerritoryId','=',$territory_data)
				                         ->get();
				
				if(count($get_cal_terr_res)==0)
				{
					
					$open_status   = "open";
					$active_status = 1;
					$this->lms_calendarterritories
					     ->INSERT(['lct_CompanyId'=>3,'lct_CalendarId'=>$calendar_id,'lct_TerritoryId'=>$territory_data,'lct_OpenStatus'=>$open_status,'lct_ActiveStatus'=>$active_status]);
					
				}
			}
		return 'not_exist';	
		}
			
			
	}
	
	public function appointment_slot_function($calendar_id)
	{
	  $date_master_details = $this->lms_datemasters
								  ->select('*')
								  ->get();
								 
	  $date_and_time =array();						  
      for($i=0;$i<count($date_master_details);$i++)								  
	  {
		   $date_master_id    = $date_master_details[$i]['ldm_DateMasterId'];
		   $date_master_name  = $date_master_details[$i]['ldm_DateMaster'];
		   $date_and_time[]   = $this->time_list_fun($date_master_id,$calendar_id);
		   $date_and_time[$i]['ldm_DateMaster'] = $date_master_name;
		 
	  }
	   return $date_and_time;
	}
	
	public function time_list_fun($date_master_id,$calendar_id)
	{
		$time_details    = $this->lms_times
	                 ->join('lms_timemasters','lms_timemasters.ltm_TimeId','=','lms_times.lt_TimeId')
					 ->select('lms_times.lt_TimeMaster','lms_times.lt_TimeId')
					 ->where('lms_timemasters.ltm_CalenProduct','=',$calendar_id)
					 ->where('lms_timemasters.ltm_DateMasterId','=',$date_master_id)
					 ->orderBy('lms_times.lt_TimeId','Asc')
					 ->get();
		
		return $time_details;
	}
	
	public function lms_existing_calendar_fun()
	{
		$existing_calenda = $this->lms_calendarterritories
		                         ->leftJoin('lms_calendars','lms_calendarterritories.lct_CalendarId','=','lms_calendars.lc_CalendarId')
								 ->leftJoin('lms_branches','lms_calendarterritories.lct_TerritoryId','=','lms_branches.lb_TerritoryId')
								 ->select('lms_calendars.lc_CalendarName','lms_calendarterritories.lct_TerritoryId',
								 'lms_calendarterritories.lct_CalendarTerritoryId',
								 'lms_branches.lb_TerritoryName',
								 'lms_calendarterritories.lct_CompanyId','lms_calendars.lc_DaysCount','lms_calendars.lc_CalendarId','lms_calendarterritories.lct_ApproveStatus')
								 ->where('lms_calendarterritories.lct_ActiveStatus',"=","1")
								 ->get();
        return $existing_calenda;
	}
	
	public function getTerritoryCalen_fun($calen_id)
	{
		$CalenTerrBasedOnId  = $this->lms_calendarterritories
		                         ->leftJoin('lms_calendars','lms_calendarterritories.lct_CalendarId','=','lms_calendars.lc_CalendarId')
								 ->leftJoin('lms_branches','lms_calendarterritories.lct_TerritoryId','=','lms_branches.lb_TerritoryId')
								 ->select('lms_calendars.lc_CalendarName','lms_calendars.lc_CalendarId','lms_calendarterritories.lct_TerritoryId','lms_calendarterritories.lct_CompanyId')
								 ->where('lms_calendarterritories.lct_CalendarId',"=",$calen_id)
								 ->get();
        return $CalenTerrBasedOnId;								
								 
	}
	
	public function getTerritoryCalen_sel($calen_name)
	{
		$CalenTerrBasedOnId  = $this->lms_calendarterritories
		                         ->leftJoin('lms_calendars','lms_calendarterritories.lct_CalendarId','=','lms_calendars.lc_CalendarId')
								 ->leftJoin('lms_branches','lms_calendarterritories.lct_TerritoryId','=','lms_branches.lb_TerritoryId')
								 ->select('lms_calendarterritories.lct_TerritoryId')
								 ->where('lms_calendars.lc_CalendarName',"=",$calen_name)
								 ->groupBy('lms_calendarterritories.lct_TerritoryId')
								 ->get();
								
        return $CalenTerrBasedOnId;								
								 
	}
	
	public function get_all_branch_fun()
	{
		$result = $this->lms_branches
		               ->select('lb_TerritoryId','lb_TerritoryName')
		               ->where('lb_CompanyId','=',1)
					   ->get();
		return $result;
	}
	//Get the week id
	public function get_lw_WeekId_func()
	{
		$result_lw_WeekId = $this->lms_weeks->select('lw_WeekId')
	                 ->where('lw_WeekStartDate','<=','now()')
					 ->where('lw_WeekEndDate','>=','now()')
					 ->get(); 
	    return $result_lw_WeekId;
	}
	public function getSlotBySlotId_func($slot_id,$territory_id,$calen_id)
	{
		$result = $this->lms_slots
		               ->join("lms_weeks","lms_weeks.lw_WeekId","=","lms_slots.ls_WeekId")
					   ->join("lms_branches","lms_branches.lb_TerritoryId","=","lms_slots.ls_TerritoryId")
					   ->select('*')
		    ->where("lms_slots.ls_TerritoryId","=",$territory_id)
			->where("lms_slots.ls_SlotId","=",$slot_id)
			->where("lms_slots.ls_CalenProduct","=",$calen_id)
			->get();
	    return $result;
	}
	
	public function get_calendar_id($calen_name)
	{
		$cal_nam_res=$this->lms_calendars->select('*')
		                  ->where('lc_CalendarName','=',$calen_name)
			              ->get();
			if(count($cal_nam_res)>0)
			{
				$calendar_id=$cal_nam_res[0]['lc_CalendarId'];
			}
			else
			{
			   $result=$this->lms_calendars->insert(['lc_CalendarName'=>$calen_name,'lc_CreatedDate'=>'now()']);
               $calendar_id = $this->lms_calendars->max('lc_CalendarId');	
			}
			//print_r($cal_nam_res);exit;
			return $calendar_id;
	}
	
	public function getTimeByDate($date_master_id,$calendar_id,$territory_id)
	{
		$calen_time_check   = $this->lms_timemasters
	                            ->join('lms_times',"lms_timemasters.ltm_TimeId","=","lms_times.lt_TimeId")
								->select('lms_timemasters.ltm_TimeMasterId','lms_timemasters.ltm_DateMasterId','lms_times.lt_TimeMaster')
	                            ->where('lms_timemasters.ltm_DateMasterId','=',$date_master_id)
								->where('lms_timemasters.ltm_CalenProduct','=',$calendar_id)
								->where('lms_timemasters.ltm_Active','=',1)
								->orderBy('ltm_TimeMasterId','Asc')
								->get();
		
        return $calen_time_check;
    }
	
	public function getSlotRelation_fun($lmss_slot_id, $date_master_id, $time_master_id)
	{
		$result_slot_r = $this->lms_slotrelations->select('*')
		                      ->where("lsr_SlotId","=",$lmss_slot_id)  
							  ->where("lsr_DateMasterId","=",$date_master_id)
							  ->where("lsr_TimeMasterId","=",$time_master_id)
							  ->get();
		return $result_slot_r;
		
	}
	
	public function weekly_app_func($slot_id,$territory_id,$calen_id,$get_lw_WeekId)
	{
		    //$day_of_week = date('N', strtotime(date('d')));
			$result_slot_r = $this->lms_timemasters
		    ->join("lms_datemasters","lms_datemasters.ldm_DateMasterId","=","lms_timemasters.ltm_DateMasterId")
			->join("lms_times","lms_times.lt_TimeId","=","lms_timemasters.ltm_TimeId")
			->join("lms_slots","lms_slots.ls_CalenProduct","=","lms_timemasters.ltm_CalenProduct")
			->join("lms_weeks","lms_slots.ls_WeekId","=",
			"lms_weeks.lw_WeekId")
			->join("lms_slotrelations", function($join)
				 {
					 $join->on('lms_slotrelations.lsr_SlotId', '=', 'lms_slots.ls_SlotId');
					 $join->on('lms_slotrelations.lsr_TimeMasterId', '=', 'lms_timemasters.ltm_TimeMasterId');
					 $join->on('lms_slotrelations.lsr_DateMasterId', '=', 'lms_datemasters.ldm_DateMasterId');

				 })
			->select('lms_timemasters.ltm_TimeMasterId','lms_slots.ls_SlotProjectedDate','lms_timemasters.ltm_DateMasterId',
			'lms_timemasters.ltm_TimeId',
			'lms_times.lt_TimeMaster',
			'lms_timemasters.ltm_CalenProduct','lms_slotrelations.lsr_ManagerRequest','lms_slotrelations.lsr_Allocated',
			'lms_slotrelations.lsr_Actual','lms_slotrelations.lsr_ConfirmationActual','lms_slotrelations.lsr_ConfirmationAllocated','lms_datemasters.ldm_DateMaster','lms_slots.ls_WeekId','lms_slots.ls_SlotId','lms_slots.ls_TerritoryId','lms_slots.ls_CalenProduct',
			'lms_weeks.lw_WeekStartDate')
			->where("lms_slotrelations.lsr_SlotId","=",$slot_id)
			->where("lms_slots.ls_TerritoryId","=",$territory_id)
			->where("lms_slots.ls_CalenProduct","=",$calen_id)
			->where("lms_slots.ls_WeekId","=",$get_lw_WeekId)
			->orderby("lms_datemasters.ldm_DateMasterId",'ASC')
			->get();
			return $result_slot_r;
	}
	
	public function updatesSlotRelation( $slot_id, $date_master_id, $time_master_id, $old_manager_request, $manager_request, $recommended, $lmssr_pre_actual, $actual_request, $confirmation)
	{
		$this->lms_slotrelations->where('lsr_SlotId',"=",$slot_id)
		->where('lsr_DateMasterId','=',$date_master_id)
		->where('lsr_TimeMasterId','=',$time_master_id)
		->update(['lsr_OldManagerRequest'=>$old_manager_request,'lsr_ManagerRequest'=>$manager_request,'lsr_Recommended'=>$recommended,'lsr_Previous'=>$lmssr_pre_actual,'lsr_Actual'=>$actual_request,'lsr_ConfirmationActual'=>$confirmation]);
		
	}
	
	public function updateSlot($lmss_week_reps, $lmss_total_reps, $message, $lw_WeekStartDate, $lss_SlotStatusId, $pending_review, $lmss_slot_id, $lmss_territory_id)
	{
		$this->lms_slots->where("ls_SlotId","=","$lmss_slot_id")
		                ->where("ls_TerritoryId","=","$lmss_territory_id")
						->update(['ls_WeekReps'=>$lmss_week_reps,'ls_TotalReps'=>$lmss_total_reps,'ls_SlotComments'=>$message,'ls_SlotProjectedDate'=>$lw_WeekStartDate,'ls_SlotStatusId'=>$lss_SlotStatusId,'ls_PendingReview'=>$pending_review,'ls_UpdatedDate'=>'now()']);
		
	}
	
	public function get_territory_based_zipcode($zipcode)
	{
		$result =  $this->lms_branches->join("mdm_storebranchzipcodes","mdm_storebranchzipcodes.msbz_BranchId","=","lms_branches.lb_BranchId")->select("lms_branches.lb_TerritoryId")->where("mdm_storebranchzipcodes.msbz_Zipcodes","=",$zipcode)->get();
		$territory_id_fet = $result[0]['lb_TerritoryId'];
		return $territory_id_fet;
	}
	public function get_territoryCode_based_zipcode($zipcode)
	{
		$result =  $this->lms_branches->join("mdm_storebranchzipcodes","mdm_storebranchzipcodes.msbz_BranchId","=","lms_branches.lb_BranchId")->select("lms_branches.lb_TerritoryCode")->where("mdm_storebranchzipcodes.msbz_Zipcodes","=",$zipcode)->get();
		$territory_id_fet = $result[0]['lb_TerritoryCode'];
		return $territory_id_fet;
	}
	
	public function get_calendar_based_territory($territory_id)
	{
		
		$result = $this->lms_calendarterritories->select("lct_CalendarId")->where("lct_TerritoryId","=",$territory_id)->where("lct_ActiveStatus","=",1)->get();
		
	    return $result[0]['lct_CalendarId'];
	}
	
	public function get_slot_details($start_lw_WeekId,$territory_id,$calendar_id)
		{
			$result = $this->lms_slots->join("lms_weeks","lms_weeks.lw_WeekId","=","lms_slots.ls_WeekId")
			               ->join("lms_slotstatus","lms_slotstatus.lss_SlotStatusId","=","lms_slots.ls_SlotStatusId")
						   ->join("lms_branches","lms_branches.lb_TerritoryId","=","lms_slots.ls_TerritoryId")
						   ->select('*')
						   ->where("lms_slots.ls_WeekId",">=",$start_lw_WeekId) 
						   ->where("lms_slots.ls_TerritoryId",">=",$territory_id)
						   ->where("lms_slots.ls_CalenProduct",">=",$calendar_id)
						   ->orderBy("lms_slots.ls_WeekId","ASC")
						   ->get();
											
			return $result;
			
		}
		
		public function getSlotIdBySlotId($slot_id,$territory_id,$calendar_id)
		{
			$result = $this->lms_slots->join("lms_weeks","lms_weeks.lw_WeekId","=","lms_slots.ls_WeekId")
			               ->join("lms_slotstatus","lms_slotstatus.lss_SlotStatusId","=","lms_slots.ls_SlotStatusId")
						   ->join("lms_branches","lms_branches.lb_TerritoryId","=","lms_slots.ls_TerritoryId")
						   ->select('lms_slots.ls_WeekId')
						   ->where("lms_slots.ls_SlotId","=",$slot_id) 
						   ->where("lms_slots.ls_TerritoryId","=",$territory_id)
						   ->where("lms_slots.ls_CalenProduct","=",$calendar_id)
						   ->get();
											
			return $result;
			
		}
		
		public function lw_WeekStartDate_fun($lw_WeekId)
		{
			$start_date = $this->lms_weeks->select('lw_WeekStartDate')
			->where('lw_WeekId','=',$lw_WeekId)
			->get();
			return $start_date;
		}
		
		public function slotIdGetBasedTerrIdCalIenId($lmss_territory_id,$lmss_calen_id)
		{
			$result = $this->lms_slots->select("*")
			               ->where("ls_TerritoryId","=",$lmss_territory_id)
						   ->where("ls_CalenProduct","=",$lmss_calen_id)
						   ->get();
						   
		    return $result;
		}
		
	public function slotDetailsForAllLeads($appdate,$apptime,$lcd_Zipcode,$customer_id,$territory_id,$companyId)
	{
		
	$calendar_id_fet  = $this->get_calendar_based_territory($territory_id);
	$week_id          = lms_weeks::where('lw_WeekStartDate','<=',$appdate)->where('lw_WeekEndDate','>=',$appdate)->value('lw_WeekId');
	$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
	$date_master_id  = date('w',strtotime($appdate));
	if($date_master_id==0)
	 {
		$date_master_id=7;
	 }
	$time_master_id = lms_timemasters::join('lms_times', 'lms_timemasters.ltm_TimeId', '=','lms_times.lt_TimeId')
	->where('ltm_DateMasterId',$date_master_id)->where('ltm_CalenProduct',$calendar_id_fet)->where('lt_TimeMaster',$apptime)->value('ltm_TimeMasterId');

	//echo $time_master_id."/";
	 $actual        = $this->lms_slotrelations->select('lms_slotrelations.lsr_Actual','lms_slotrelations.lsr_Allocated')->where('lsr_SlotId',$slot_id)->where('lsr_DateMasterId',$date_master_id)
	->where('lms_slotrelations.lsr_TimeMasterId',$time_master_id)->first();
	
	if($actual['lsr_Actual']>0)
		{
	        $allocated = lms_slotrelations::select('lsr_Allocated')->where('lsr_SlotId',$slot_id)->where('lsr_DateMasterId',$date_master_id)->where('lsr_TimeMasterId',$time_master_id)->increment('lsr_Allocated');
			
			$lms_customerslots=new lms_customerslots();
			//$max_leadid = 0;
			$max_leadid = lms_customerslots::max('lcs_LeadID');
			if($max_leadid==0)
			{
				$lms_customerslots->lcs_LeadID =10000;
			}
			else
			{
				
				$lms_customerslots->lcs_LeadID =$max_leadid+1;
			}
			
			$lms_customerslots->lcs_SlotId        = $slot_id;
			$lms_customerslots->lcs_CustomerId    = $customer_id;
			$lms_customerslots->lcs_LeadCaption   = 'NR';
			$appdate2                             = explode("-",$appdate);
			$appdate1 = $appdate2[2]."/".$appdate2[0]."/".$appdate2[1];
			$appointment_datetime                 = $appdate1." ".$apptime;
			$lms_customerslots->lcs_WeekSlotId    = $week_id;
			$lms_customerslots->lcs_DateMasterId  = $date_master_id;
			$lms_customerslots->lcs_TimeMasterId  = $time_master_id;
			//$lms_customerslots->lcs_ApptDateTime =$appointment_datetime;
			$lms_customerslots->lcs_ApponimtentDate =$appdate;
			$lms_customerslots->lcs_AppointmentTime =$apptime;
			$lms_customerslots->lcs_CompanyId = $companyId;
			$lms_customerslots->save();
			//echo $lms_customerslots;
			return 'success';
		}
		else
		{
			return 'fail';
		}
		
	
	}
	
	
	public function slotDetailsForAllLeadsUpdate($appdate,$apptime,$lcd_Zipcode,$lld_CustomerId,$territory_id,$selectedScheduleConfirm)
	{
		
	$calendar_id_fet  = $this->get_calendar_based_territory($territory_id);
	$week_id          = lms_weeks::where('lw_WeekStartDate','<=',$appdate)->where('lw_WeekEndDate','>=',$appdate)->value('lw_WeekId');
	$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
	$date_master_id  = date('w',strtotime($appdate));
	if($date_master_id==0)
	 {
		 $date_master_id=7;
	 }
	$time_master_id = lms_timemasters::join('lms_times', 'lms_timemasters.ltm_TimeId', '=','lms_times.lt_TimeId')
	->where('ltm_DateMasterId',$date_master_id)->where('ltm_CalenProduct',$calendar_id_fet)->where('lt_TimeMaster',$apptime)->value('ltm_TimeMasterId');

	//echo $time_master_id."/";
	 $actual        = $this->lms_slotrelations->select('lms_slotrelations.lsr_Actual','lms_slotrelations.lsr_Allocated','lsr_ConfirmationActual','lsr_ConfirmationAllocated')->where('lsr_SlotId',$slot_id)->where('lsr_DateMasterId',$date_master_id)
	->where('lms_slotrelations.lsr_TimeMasterId',$time_master_id)->first();
	if($selectedScheduleConfirm=='shedule')
	{
		if($actual['lsr_Actual']>0)
			{
				$allocated = lms_slotrelations::select('lsr_Allocated')->where('lsr_SlotId',$slot_id)->where('lsr_DateMasterId',$date_master_id)
				->where('lsr_TimeMasterId',$time_master_id)->increment('lsr_Allocated');
				
			}
	}
	else if($selectedScheduleConfirm=='confirm')
	{
		if($actual['lsr_ConfirmationActual']>0)
			{
				$allocated = lms_slotrelations::select('lsr_ConfirmationAllocated')->where('lsr_SlotId',$slot_id)->where('lsr_DateMasterId',$date_master_id)
				->where('lsr_TimeMasterId',$time_master_id)->increment('lsr_ConfirmationActual');
				
			}
			
	}
	
	$appdate2 = explode("-",$appdate);
	$appdate1 = $appdate2[2]."/".$appdate2[0]."/".$appdate2[1];
	$appointment_datetime = $appdate1." ".$apptime;
	$lms_customerslots=new lms_customerslots();
	$lms_customerslots
	->where("lcs_CustomerId","=",$lld_CustomerId)->
	update(
	[
	'lcs_SlotId'        		 =>$slot_id,
	'lcs_LeadCaption'        	 =>'NR',
	'lcs_WeekSlotId'        	 =>$week_id,
	'lcs_DateMasterId'        	 =>$date_master_id,
	'lcs_TimeMasterId'        	 =>$time_master_id,
	'lcs_ApponimtentDate'        =>$appdate,
	'lcs_AppointmentTime'        =>$apptime,
	]);
	return 'success';	
		
	
	}
		
}
