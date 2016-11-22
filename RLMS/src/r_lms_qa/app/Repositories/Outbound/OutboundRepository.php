<?php

namespace App\Repositories\Outbound;
use Illuminate\Database\Eloquent\Model;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Models\lms_customerdetails;
use App\Repositories\CalendarRepository;
class OutboundRepository extends Model
{
	public function __construct(lms_calldetails $lms_calldetails,lms_customerslots $lms_customerslots,lms_customerdetails $lms_customerdetails,CalendarRepository $CalendarRepository)
	{
		$this->lms_calldetails     = $lms_calldetails;
		$this->lms_customerslots   = $lms_customerslots;
		$this->lms_customerdetails = $lms_customerdetails;
		$this->CalendarRepository  = $CalendarRepository;
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

  public function UpdateLeadsAjaxProcess($schedule,$call_status_id)
	{
		$lld_CustomerId     = $_REQUEST['lld_CustomerId'];
		$call_from 			= trim( $_REQUEST['lld_CallFromId'] );	
		//$prospect_id		= trim( $_REQUEST['prospect_id'] );	
		

		//$customer_refer_id	= trim( $_REQUEST['customer_refer_id'] );		
		//$customer_id		= trim( $_REQUEST['customer_id'] );		

		$hd_type_id 		= 3;

		$store_id		 	= "";
		$associate_id 		= "";
		$isp_id				= "";
		$customer_county    = "";
		$customer_presence	= 0;
	    $WPTitle                =  "";
     	$WPTitle                = $_REQUEST['lcd_WPTitle'];
		
		$CPTitle                =  "";
     	$CPTitle                = $_REQUEST['lcd_CPTitle'];
		switch($call_from)
		{
			case 1: //HD
				if( isset( $_REQUEST['isp_id'] ) && isset( $_REQUEST['lld_StoreId'] ) )
				{
					//Case - (HD --> Home Depot - ISP Program)
					//$isp_id				= trim( $_REQUEST['isp_id'] );
					//$customer_presence 	= $_REQUEST['customer_present'];
					$store_id		 	= $_REQUEST['lld_StoreId'];
				}
				else
				{
					$hd_type_id 		= $_REQUEST['lld_CallTypeId'];
					if($hd_type_id == 1)
					{
						//Customer is there
						$customer_presence 	= 1;
					}
					else
					{
						//Associate case
						//$customer_presence 	= $_REQUEST['customer_present'];
						$store_id		 	= $_REQUEST['lld_StoreId'];
						$associate_id 		= $_REQUEST['lld_AssociateId'];
					}
				}
			break;	
			case 2: //SC
				$store_id		 	= $_REQUEST['lld_StoreId'];
				$associate_id 		= $_REQUEST['lld_AssociateId'];
				$customer_presence 	= 1;
			break;
			case 3: //Internet
				$customer_presence 	= 1;
			break;
			case 4: //Other
				if(isset($_REQUEST['lld_StoreId']))
				{
					$store_id = TRIM($_REQUEST['lld_StoreId']);
				}
				if(isset($_REQUEST['lld_AssociateId']))
				{
					$associate_id = TRIM($_REQUEST['lld_AssociateId']);
				}
				$customer_presence 	= 1;
			break;
		

		}
			
		
		//slide 2
		
		$title			 = $_REQUEST['lcd_Title']; 	
		$first_name		 = $_REQUEST['lcd_FirstName']; 
		$last_name		 = $_REQUEST['lcd_LastName']; 
		$zipcode		 = $_REQUEST['lcd_Zipcode']; 
		$store_id        = '';
		$store_id        = trim( $_REQUEST['lld_StoreId'] );
		$lld_ProductCode = trim($_REQUEST['lld_ProductCode']);
		$appdate         = $_REQUEST['get_date_dis'];
		//$appdate    = date('Y-m-d');
		$appTime    = trim($_REQUEST['get_time_dis']);
		//if($store_id=='')
		//{
		 // $store_id=$db->getStoreZipcodeInfo($zipcode);
		//}
		
		
		
		//slide 3
		
		//$call_status_id			= 1; //Not Available
	$hometype_id			=trim( $_REQUEST['lch_HomeTypeId'] ) ;
	
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
	$customer_address		=  trim( $_REQUEST['lcd_Address']);
	$customer_city			=  trim( $_REQUEST['lcd_City'] );
	$customer_state			=  trim( $_REQUEST['lcd_State'] );
	$customer_territory		=  trim( $_REQUEST['lmss_territory_id'] );
	//$customer_county		=  trim( $_REQUEST['customer_county'] );
	$lcd_Address_email      =  trim( $_REQUEST['lcd_EmailAddress']);
	
	$customer_cross_street	= ""; 
	$customer_community		= "";
	$house_color			= "";

	$home_phone				= "";
	$work_phone				= "";
	$work_phone_ext			= "";
	
	$cell_phone				= "";
	$customer_comments		= "";
	//$customer_presence		=  trim( $_REQUEST['customer_presence'] );
    
	$home_phone				=  trim( $_REQUEST['lcd_HomePhone']);
	$work_phone				=  trim( $_REQUEST['lcd_WorkPhone']);
	$customer_comments		=  trim( $_REQUEST['lld_CallDescription']);
	//if( $work_phone != "" )
	//{
	//	$work_phone_ext			=  trim( $_REQUEST['work_phone_ext']);
	//}
	
	$cell_phone				=  trim( $_REQUEST['lcd_CellPhone']);
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
			$review_case		= "lcd_WorkPhone";
			//$call_status_id 	= 7; //case - mobile home 
		}
		else
		{
			//$call_status_id		= 1; //case - not available
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
			
			
			
			
			
			
			
			$customer_cross_street	=  trim( $_REQUEST['lcd_CrossStreet']); 
			if( (int)$customer_presence == 1)
			{
				//case - if customer present
				//$customer_cross_street	=  trim( $_REQUEST['customer_cross_street'] ) ); 
				$customer_community		=  trim( $_REQUEST['lcd_Community']);
				$house_color			=  trim( $_REQUEST['lcd_HousecColor']);
			}
		}
	}
	
	$this->lms_customerdetails
		->where("lcd_CustomerId","=",$lld_CustomerId)->
		update(
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
		'lcd_WPTitle'         => $WPTitle,
		'lcd_WorkPhone'       => $home_phone,
		'lcd_CPTitle'         => $CPTitle,
		'lcd_CellPhone'       => $cell_phone,
		'lcd_Territory'       => $customer_territory,
		'lcd_Comments'        => $customer_comments,
		]
		);
		
	//echo $this->lms_customerdetails->lcd_CustomerId;
	//return redirect('callerscreen');
	 //$customer_id = $this->lms_customerdetails->max('lcd_CustomerId');

	
	    
		$lld_ProsepctId   = "";
		$lld_Calldesc     = "";
	    
		if(empty($call_from))
		{
		 $call_from = "";
		}
		if(empty($store_id))
		{
		$store_id = "";
		}
		if(empty($associate_id))
		{
		$associate_id = "";
		}
		$this->lms_calldetails
		->where("lld_CustomerId","=",$lld_CustomerId)->
		update(
		[
		'lld_ProductCode'        		 =>$lld_ProductCode,
		'lld_CallFromId'          		 =>$call_from,
		'lld_SlotId'             		 =>0,
		'lld_ProsepctId'           =>'',
		'lld_CallbackId'          		 =>'',
	    'lld_VerificationCode'    		 =>'',
		'lld_StoreId'             		 =>$store_id,
		'lld_CallStatusId'        		 =>$call_status_id,
		'lld_AgentCreatedBy'      		 =>1000,
		'lld_AgentUpdatedBy'      		 =>1000,
		'lld_AssignedBy'           		 =>0,
		'lld_ResultedBy'                 =>0,
		'lld_PriorityOrder'              =>0,
		'lld_PrioritySetDate'            =>date('Y-m-d H:i:s'),
		'lld_FinishCallButton'           =>1,
		'lld_CallDateTime'               =>date('Y-m-d H:i:s'),
		'lld_RecordCreatedDateTime'      =>date('Y-m-d H:i:s'),
		'lld_RescheduleCreatedDateTime'  =>date('Y-m-d H:i:s'),
		'lld_LastModifiedDate'           =>date('Y-m-d H:i:s'),
		]);
		
	$territory_id = $_REQUEST['lmss_territory_id'];
	
	$actual = $this->CalendarRepository->slotDetailsForAllLeadsUpdate($appdate,$appTime,$zipcode,$lld_CustomerId,$territory_id,$schedule);
	return $actual;
	}
		
}
