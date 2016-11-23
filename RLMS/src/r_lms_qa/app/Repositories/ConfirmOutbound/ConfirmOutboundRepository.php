<?php

namespace App\Repositories\ConfirmOutbound;
use Illuminate\Database\Eloquent\Model;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Models\lms_customerdetails;
class ConfirmOutboundRepository extends Model
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
  
  public function CheckExistRequestId($CustomerId)
  {
	$RequestIdArray = $this->lms_customerdetails
	  ->join("lms_calldetails","lms_customerdetails.lcd_CustomerId","=","lms_calldetails.lld_CustomerId")
	  ->leftjoin("lms_customerslots","lms_customerdetails.lcd_CustomerId","=","lms_customerslots.lcs_CustomerId")
	  ->where("lms_customerdetails.lcd_CustomerId","=",$CustomerId)
	  ->first(); 
  return $RequestIdArray;
  }

  public function UpdateRequestIdReturnId($CustomerId)
  {
	 // For update the request Id 
	 $date               = new \DateTime();
     $requestId          = $date->format('U');
	 $this->lms_calldetails->where("lld_CustomerId","=",$CustomerId)
	       ->update(['lld_RequestId'=>$requestId]);
     // Get the request id from based on the customer id 
	 $ResultReId = $this->lms_calldetails->where("lld_CustomerId","=",$CustomerId)->get;
	 return $ResultReId[0]['lld_RequestId'];
  }
		
}
