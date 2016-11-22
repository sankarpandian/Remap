<?php

namespace App\Http\Controllers\Ajax_Process;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Calendar_Models\lms_slotrelations;
use App\Http\Controllers\Controller;
use App\Repositories\CalendarRepository;
use App\Repositories\SalesManager\SalesManagerRepository;
class SalesManagerAjaxProContrWeeklyApp extends Controller
{
    //
	public function __construct(CalendarRepository $CalendarRepository,SalesManagerRepository $SalesManagerRepository)
	{
		$this->CalendarRepository     = $CalendarRepository;
		$this->SalesManagerRepository = $SalesManagerRepository;
	}
	
	public function SalesManagerWeeklyAppoint()
	{
		
		$lmss_total_reps        = trim($_REQUEST['lmss_total_reps']);
		$lmss_week_reps         = trim($_REQUEST['lmss_week_reps']);
		$lmss_week_id           = trim($_REQUEST['lmss_week_id']);
		$lmss_slot_id           = trim($_REQUEST['lmss_slot_id']);
		$lmss_territory_id      = trim($_REQUEST['lmss_territory_id']);
		$lmss_calen_id          = trim($_REQUEST['lmss_calen_product']);
		$message                = trim($_REQUEST['message']);
		$week_start_date        = trim($_REQUEST['week_start_date']);
		
		//$week_slot_query = "select * from lms_slot_relation where slot_id = '".$_REQUEST['slot_id']."'";
		
		//$week_slot_query = $this->SalesManagerRepository->SlotRelationDetails($lmss_slot_id);
		
		
		
		//Updating information to lms_slot
		$pending_review = 0;
		$rows_slot = $this->CalendarRepository->getSlotBySlotId_func($lmss_slot_id,$lmss_territory_id,$lmss_calen_id);
		
		if( (int)$rows_slot[0]['ls_SlotStatusId'] == 2 || (int)$rows_slot[0]['ls_SlotStatusId'] == 1 )
		{
			//Submitted status to Approved
			$lmss_slot_status_id = 3;							
		}
		elseif( (int)$rows_slot[0]['ls_SlotStatusId'] == 4 )
		{
			//Re-Submitted to Re-Approved
			$lmss_slot_status_id = 5;							
		}
		elseif( (int)$rows_slot[0]['ls_SlotStatusId'] == 3 || (int)$rows_slot[0]['ls_SlotStatusId'] == 5 )
		{
			$lmss_slot_status_id = $rows_slot[0]['ls_SlotStatusId'];
		}
		$this->CalendarRepository->updateSlot($lmss_week_reps, $lmss_total_reps, $message, $week_start_date, $lmss_slot_status_id, $pending_review, $lmss_slot_id, $lmss_territory_id);
		$resultSlotId = $this->CalendarRepository->slotIdGetBasedTerrIdCalIenId($lmss_territory_id,$lmss_calen_id);
		//echo count($resultSlotId);
		if(count($resultSlotId)>0)
		{
		for($k=0;$k<count($resultSlotId);$k++)
		{
		// UPdating data to slot_relation table
		$lms_datemasters      = $this->CalendarRepository->lms_datemasters_fun();
		//print_r($lms_datemasters);
		for($i=0;$i<count($lms_datemasters);$i++)
		{
			$lmsdm_date_master_id  = $lms_datemasters[$i]['ldm_DateMasterId'];
			$lmsdm_date_master     = $lms_datemasters[$i]['ldm_DateMaster'];
			
			$TimeByDate = $this->CalendarRepository->getTimeByDate($lmsdm_date_master_id,$lmss_calen_id,$lmss_territory_id);
			//print_r($TimeByDate);
						
			for($j=0;$j<count($TimeByDate);$j++)
			{ 
				$lmstm_time_master_id = $TimeByDate[$j]['ltm_TimeMasterId'];
				$lmstm_date_master_id = $TimeByDate[$j]['ltm_DateMasterId'];
				if(isset($_REQUEST['mgr_slot_'.$lmstm_date_master_id."_".$lmstm_time_master_id]))
				{
							
				$manager_request 	= trim($_REQUEST['mgr_slot_'.$lmstm_date_master_id."_".$lmstm_time_master_id]);
				
					
				$recommended		= 2 * (int)$manager_request;	
	            $lsr_Actual         = 1.5 * (int)$manager_request;	
				$confirmation       = (int)$manager_request;	
				
				
				$get_slot_rel_res 	= $this->CalendarRepository->getSlotRelation_fun($lmss_slot_id, $lmstm_date_master_id, $lmstm_time_master_id);
				//print_r($get_slot_rel_res);
				    if(count($get_slot_rel_res)>0)
					{
					$lmssr_actual = $get_slot_rel_res[0]['lsr_Actual'];
					$this->SalesManagerRepository->updatesSlotRelation( $resultSlotId[$k]['ls_SlotId'], $lmstm_date_master_id, $lmstm_time_master_id,$get_slot_rel_res[0]['lsr_OldManagerRequest'], $manager_request, $recommended,$lsr_Actual,$lmssr_actual, $confirmation);
					
					}
				}
			}
		}
	  }
        }
		
	}
	
	public function slotValidateSalesManFun()
	{
		$sched_slot_id      = $_REQUEST['sched_slot_id'];
		$sched_territory_id = $_REQUEST['sched_territory_id'];
		$sched_date_master  = $_REQUEST['sched_date_master'];
		$sched_time_master  = $_REQUEST['sched_time_master'];
		$lms_slotrelations  = new lms_slotrelations;
		$result = $lms_slotrelations
		          ->join('lms_slots','lms_slotrelations.lsr_SlotId','=','lms_slots.ls_SlotId')
		          ->select('lms_slotrelations.lsr_Allocated')
				  ->where('lms_slotrelations.lsr_DateMasterId','=',$sched_date_master)
				  ->where('lms_slotrelations.lsr_TimeMasterId','=',$sched_time_master)
				  ->where('lms_slots.ls_SlotId','=',$sched_slot_id)
				  ->where('lms_slots.ls_TerritoryId','=',$sched_territory_id)
				  ->first();
		
		return $result;
	}
}
