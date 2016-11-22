<?php

namespace App\Repositories\Outbound;
use Illuminate\Database\Eloquent\Model;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Models\lms_customerdetails;
class OutboundRepository extends Model
{
	public function __construct(lms_calldetails $lms_calldetails,lms_customerslots $lms_customerslots,lms_customerdetails $lms_customerdetails)
	{
		$this->lms_calldetails     = $lms_calldetails;
		$this->lms_customerslots   = $lms_customerslots;
		$this->lms_customerdetails = $lms_customerdetails;
	}
	
  public function GetListCustomerDetails($CustomerId)
  {
  $resultCustomerDetails = $this->lms_customerdetails
  ->join("lms_calldetails","lms_customerdetails.lcd_CustomerId","=","lms_calldetails.lld_CustomerId")
  ->leftjoin("lms_customerslots","lms_customerdetails.lcd_CustomerId","=","lms_customerslots.lcs_CustomerId")
  ->where("lms_customerdetails.lcd_CustomerId","=",$CustomerId)
  ->first();	
	  
	return $resultCustomerDetails;
	
  }
	
		
}
