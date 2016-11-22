<?php

namespace App\Http\Controllers\Ajax_Process;

use Illuminate\Http\Request;

use App\Calendar_Models\lms_slots;
use App\Calendar_Models\lms_timemasters;
use App\Calendar_Models\lms_slotrelations;
use App\Calendar_Models\lms_weeks;
use App\Http\Requests;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Http\Controllers\Controller;
use App\Repositories\CalendarRepository;
use App\Repositories\Outbound\OutboundRepository;
class OutboundAjaxProcessController extends Controller
{
    //
	public function __construct(CalendarRepository $CalendarRepository,lms_customerdetails $lms_customerdetails,lms_calldetails $lms_calldetails,lms_customerslots $lms_customerslots,lms_slots $lms_slots,lms_timemasters $lms_timemasters,lms_slotrelations $lms_slotrelations,lms_weeks $lms_weeks,OutboundRepository $OutboundRepository)
	{
		$this->CalendarRepository  = $CalendarRepository;
		$this->lms_customerdetails = $lms_customerdetails;
		$this->lms_calldetails     = $lms_calldetails;
		$this->lms_customerslots   = $lms_customerslots;
		$this->lms_slots           = $lms_slots;
		$this->lms_timemasters    = $lms_timemasters;
		$this->lms_slotrelations  = $lms_slotrelations;
		$this->lms_weeks           = $lms_weeks;
		$this->OutboundRepository           = $OutboundRepository;
	}
	public function OutboundUpdateProcess()
	{
	$actual = $this->OutboundRepository->UpdateLeadsAjaxProcess('shedule',2);	
	if($actual=='success')		
	return 'success';
    else 
	return 'not available'; 
	}
	
}
