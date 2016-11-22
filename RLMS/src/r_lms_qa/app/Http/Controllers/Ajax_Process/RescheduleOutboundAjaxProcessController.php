<?php

namespace App\Http\Controllers\Ajax_Process;

use Illuminate\Http\Request;

use App\Calendar_Models\lms_slots;
use App\Calendar_Models\lms_timemasters;
use App\Calendar_Models\lms_slotrelations;
use App\Http\Requests;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Http\Controllers\Controller;
use App\Repositories\CalendarRepository;
use App\Repositories\Outbound\OutboundRepository;
class RescheduleOutboundAjaxProcessController extends Controller
{
    //
	public function __construct(CalendarRepository $CalendarRepository,lms_customerdetails $lms_customerdetails,lms_calldetails $lms_calldetails,lms_customerslots $lms_customerslots,lms_slots $lms_slots,lms_timemasters $lms_timemasters,lms_slotrelations $lms_slotrelations)
	{
		$this->CalendarRepository  = $CalendarRepository;
		$this->lms_customerdetails = $lms_customerdetails;
		$this->lms_calldetails     = $lms_calldetails;
		$this->lms_customerslots   = $lms_customerslots;
		$this->lms_slots           = $lms_slots;
		$this->lms_timemasters    = $lms_timemasters;
		$this->lms_slotrelations  = $lms_slotrelations;
	}
	public function ConfirmOutboundUpdateProcess()
	{
		extract($_REQUEST);
		if($selectedScheduleConfirm=='schedule')
		$call_status_id = 2;
	    else
		$call_status_id = 34;
		$actual = $this->OutboundRepository->UpdateLeadsAjaxProcess($selectedScheduleConfirm,$call_status_id);
		/*$lld_CustomerId     = $_REQUEST['lld_CustomerId'];
		$call_from 			= trim( $_REQUEST['call_from'] );	
		//$prospect_id		= trim( $_REQUEST['prospect_id'] );	
		

		//$customer_refer_id	= trim( $_REQUEST['customer_refer_id'] );		
		//$customer_id		= trim( $_REQUEST['customer_id'] );		

		$hd_type_id 		= 3;

		$store_id		 	= "";
		$associate_id 		= "";
		$isp_id				= "";
		
		$customer_presence	= 0;
	
		switch($call_from)
		{
			case 1: //HD
				if( isset( $_REQUEST['isp_id'] ) && isset( $_REQUEST['store_no'] ) )
				{
					//Case - (HD --> Home Depot - ISP Program)
					//$isp_id				= trim( $_REQUEST['isp_id'] );
					//$customer_presence 	= $_REQUEST['customer_present'];
					$store_id		 	= $_REQUEST['store_no'];
				}
				else
				{
					$hd_type_id 		= $_REQUEST['hd_type_id'];
					if($hd_type_id == 1)
					{
						//Customer is there
						$customer_presence 	= 1;
					}
					else
					{
						//Associate case
						//$customer_presence 	= $_REQUEST['customer_present'];
						$store_id		 	= $_REQUEST['store_no'];
						$associate_id 		= $_REQUEST['associate_id'];
					}
				}
			break;	
			case 2: //SC
				$store_id		 	= $_REQUEST['store_no'];
				$associate_id 		= $_REQUEST['associate_id'];
				$customer_presence 	= 1;
			break;
			case 3: //Internet
				$customer_presence 	= 1;
			break;
			case 4: //Other
				if(isset($_REQUEST['store_no']))
				{
					$store_id = TRIM($_REQUEST['store_no']);
				}
				if(isset($_REQUEST['associate_id']))
				{
					$associate_id = TRIM($_REQUEST['associate_id']);
				}
				$customer_presence 	= 1;
			break;
		

		}
			
		
		//slide 2
		
		$title			 = $_REQUEST['title']; 	
		$first_name		 = $_REQUEST['first_name']; 
		$last_name		 = $_REQUEST['usrs_lastname']; 
		$zipcode		 = $_REQUEST['zipcode']; 
		$store_id        = '';
		$store_id        = trim( $_REQUEST['store_no'] );
		$lld_ProductCode = trim($_REQUEST['lld_ProductCode']);
		$appdate    = trim($_REQUEST['get_date_dis']);
		$appTime    = trim($_REQUEST['get_time_dis']);
		$schedule_confirm_status_id = trim($_REQUEST['schedule_confirm_value']);
		//if($store_id=='')
		//{
		 // $store_id=$db->getStoreZipcodeInfo($zipcode);
		//}
		
		
		
		//slide 3
		
		$call_status_id			= 1; //Not Available
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
			}
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
		'lld_CallStatusId'        		 =>$schedule_confirm_status_id,
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
	*/
	$territory_id = $_REQUEST['territory_id'];
	$appdate    = trim($_REQUEST['get_date_dis']);
	$appTime    = trim($_REQUEST['get_time_dis']);
	$actual = $this->CalendarRepository->slotDetailsForAllLeadsUpdate($appdate,$appTime,$zipcode,$lld_CustomerId,$territory_id);
	if($actual=='success')		
	return 'success';
    else 
	return 'not available'; 
	}
}
