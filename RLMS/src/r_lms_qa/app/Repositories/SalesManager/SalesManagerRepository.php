<?php

namespace App\Repositories\SalesManager;
use Illuminate\Database\Eloquent\Model;
use App\Calendar_Models\lms_slots;
use App\Repositories\CalendarRepository;
use App\Calendar_Models\lms_slotrelations;

class SalesManagerRepository extends Model
{
    //
	public function __construct(lms_slots $lms_slots,CalendarRepository $CalendarRepository,lms_slotrelations $lms_slotrelations)
	{
		$this->lms_slots = $lms_slots;		
		$this->CalendarRepository = $CalendarRepository;
        $this->lms_slotrelations  = $lms_slotrelations;		
	}
	public function SalesManagerDashboardSlot()
	{
		$start_week 	= $this->CalendarRepository->get_lw_WeekId_func();
		$start_week_id  = $start_week[0]['lw_WeekId'];
		$end_week_id 	= $start_week_id+4;
		$territory_id   = 1;
		$calendar_list  = array('109');
		$SmdResult      = $this->lms_slots
		                  ->join("lms_weeks","lms_weeks.lw_WeekId","=","lms_slots.ls_WeekId")
		                  ->join("lms_slotstatus","lms_slotstatus.lss_SlotStatusId","=","lms_slots.ls_SlotStatusId")
						  ->join("lms_branches","lms_branches.lb_TerritoryId","=","lms_slots.ls_TerritoryId")
						  ->select("*")
						  ->where("lms_slots.ls_TerritoryId","=",$territory_id)
						  ->whereIn("lms_slots.ls_CalenProduct",[$calendar_list])
						  ->whereBetween("lms_weeks.lw_WeekId",[$start_week_id,$end_week_id])
						  ->orderBy("lms_slots.ls_SlotId","asc")
						  ->get();
	  return $SmdResult;
		
	}

    public function updatesSlotRelation( $slot_id, $date_master_id, $time_master_id, $old_manager_request, $manager_request, $recommended, $lmssr_pre_actual, $actual_request, $confirmation)
	{
		$this->lms_slotrelations->where('lsr_SlotId',"=",$slot_id)
		->where('lsr_DateMasterId','=',$date_master_id)
		->where('lsr_TimeMasterId','=',$time_master_id)
		->where('lsr_SlotId','=',$slot_id)
		->update(['lsr_OldManagerRequest'=>$old_manager_request,'lsr_ManagerRequest'=>$manager_request,'lsr_Recommended'=>$recommended,'lsr_Previous'=>$lmssr_pre_actual,'lsr_Actual'=>$actual_request,'lsr_ConfirmationActual'=>$confirmation]);
		
	}	
	public function SlotRelationDetails($slot_id)
	{
		$result = $this->lms_slotrelations
		->select('*')->where('lsr_SlotId',"=",$slot_id)
		->get();
		
		return $result;
	}
		
}
