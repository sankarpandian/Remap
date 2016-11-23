<?php

namespace App\Http\Controllers\Ajax_Process;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CalendarRepository;
use App\Calendar_Models\lms_slotrelations;
class AjaxProContrWeeklyApp extends Controller
{
    //
	public function __construct(CalendarRepository $CalendarRepository)
	{
		$this->CalendarRepository = $CalendarRepository;
	}
	
	public function week_app_ajax_fun()
	{
		
		$lmss_total_reps        = trim($_REQUEST['lmss_total_reps']);
		$lmss_week_reps         = trim($_REQUEST['lmss_week_reps']);
		$lmss_week_id           = trim($_REQUEST['lmss_week_id']);
		$lmss_slot_id           = trim($_REQUEST['lmss_slot_id']);
		$lmss_territory_id      = trim($_REQUEST['lmss_territory_id']);
		$lmss_calen_id          = trim($_REQUEST['lmss_calen_product']);
		$message                = trim($_REQUEST['message']);
		$week_start_date        = trim($_REQUEST['week_start_date']);
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
		
		if(count($resultSlotId)>0)
		{
		for($k=0;$k<count($resultSlotId);$k++)
		{
		// UPdating data to slot_relation table
		$lms_datemasters      = $this->CalendarRepository->lms_datemasters_fun();
		
		for($i=0;$i<count($lms_datemasters);$i++)
		{
			$lmsdm_date_master_id  = $lms_datemasters[$i]['ldm_DateMasterId'];
			$lmsdm_date_master     = $lms_datemasters[$i]['ldm_DateMaster'];
			
			$TimeByDate = $this->CalendarRepository->getTimeByDate($lmsdm_date_master_id,$lmss_calen_id,$lmss_territory_id);
						
			for($j=0;$j<count($TimeByDate);$j++)
			{ 
				$lmstm_time_master_id = $TimeByDate[$j]['ltm_TimeMasterId'];
				$lmstm_date_master_id = $TimeByDate[$j]['ltm_DateMasterId'];
				if(isset($_REQUEST['mgr_slot_'.$lmstm_date_master_id."_".$lmstm_time_master_id]) && isset($_REQUEST['actual_slot_'.$lmstm_date_master_id."_".$lmstm_time_master_id]) && isset($_REQUEST['conf_slot_'.$lmstm_date_master_id."_".$lmstm_time_master_id]))
				{
				$actual_request 	= trim($_REQUEST['actual_slot_'.$lmstm_date_master_id."_".$lmstm_time_master_id]);
				
				$manager_request 	= trim($_REQUEST['mgr_slot_'.$lmstm_date_master_id."_".$lmstm_time_master_id]);
				
				$conf_request 		= trim($_REQUEST['conf_slot_'.$lmstm_date_master_id."_".$lmstm_time_master_id]);
				
				$recommended		= 2 * (int)$manager_request;	
	
				$confirmation		= $conf_request;
				
				$get_slot_rel_res 	= $this->CalendarRepository->getSlotRelation_fun($lmss_slot_id, $lmstm_date_master_id, $lmstm_time_master_id);
				
				    if(count($get_slot_rel_res)>0)
					{
					$lmssr_old_man_req = $get_slot_rel_res[0]['lsr_OldManagerRequest'];
					$lmssr_actual = $get_slot_rel_res[0]['lsr_Actual'];
					$this->CalendarRepository->updatesSlotRelation( $resultSlotId[$k]['ls_SlotId'], $lmstm_date_master_id, $lmstm_time_master_id, $get_slot_rel_res[0]['lsr_OldManagerRequest'], $manager_request, $recommended, $get_slot_rel_res[0]['lsr_Actual'], $actual_request, $confirmation);
					}
				}
			}
		}
	  }
        }
		
	}
	
	public function SheduleSlotValidation()
	{
		extract($_REQUEST);	
		$lms_slotrelations = new lms_slotrelations;
        $result = $lms_slotrelations
		 ->join("lms_slots","lms_slots.ls_SlotId","=","lms_slotrelations.lsr_SlotId")
		->where("lms_slotrelations.lsr_DateMasterId","=",$dateMasterId)
		->where("lms_slotrelations.lsr_TimeMasterId","=",$timemasterId)
		->where("lms_slots.ls_SlotId","=",$slotId)
		->where("lms_slots.ls_TerritoryId","=",$territoryId)
		->select('lms_slotrelations.lsr_Allocated')
		->first();
	
	return $result['lsr_Allocated'];
		
	}
	
	public function confirmSlotValidation()
	{
		extract($_REQUEST);	
		$lms_slotrelations = new lms_slotrelations;
        $result = $lms_slotrelations
		 ->join("lms_slots","lms_slots.ls_SlotId","=","lms_slotrelations.lsr_SlotId")
		->where("lms_slotrelations.lsr_DateMasterId","=",$dateMasterId)
		->where("lms_slotrelations.lsr_TimeMasterId","=",$timemasterId)
		->where("lms_slots.ls_SlotId","=",$slotId)
		->where("lms_slots.ls_TerritoryId","=",$territoryId)
		->select('lms_slotrelations.lsr_ConfirmationAllocated')
		->first();
	
	return $result['lsr_ConfirmationAllocated'];
		
	}
	
}
