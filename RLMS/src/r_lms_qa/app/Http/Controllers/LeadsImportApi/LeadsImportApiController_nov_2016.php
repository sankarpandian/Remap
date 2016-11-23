<?php

namespace App\Http\Controllers\LeadsImportApi;

use Illuminate\Http\Request;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use Illuminate\Support\Facades\Response;
use XmlParser;
use App\Models\remap_outboundleads;
use App\Models\lms_customerslots;
use App\Models\lms_weeks;
use App\Models\lms_slots;
use App\Models\lms_timemasters;
use App\Models\lms_times;
use App\Models\lms_slotrelations;
use App\Repositories\CalendarRepository;
use App\Repositories\CallerScreenRepository;
use App\Http\Controllers\home;
use App\Models\lms_duplicaterecords;
use App\Models\lms_scheduleappointslots;

class LeadsImportApiController extends Controller
{
	public function __construct(home $home,CalendarRepository $CalendarRepository,CallerScreenRepository $CallerScreenRepository)
	{
		$this->CalendarRepository     = $CalendarRepository;
		$this->home                   = $home;	
        $this->CallerScreenRepository = $CallerScreenRepository;		
	}
	
	 public function leads_import_api()
	{
		//echo $date_master_id=date('w');
		//exit;
		$security_key=$_REQUEST['security_key'];
		//echo $security_key;
		$xmlString=$_REQUEST['xml_string'];
		$xml = simplexml_load_string($xmlString);
		$source=(string)$xml->source;
		$firstname=(string)$xml->firstname;
		$phoneno=(string)$xml->phoneno;
		
		$ninety_days=date("Y-m-d",strtotime("-90 days"));
		
		
		//$current_time=date("Y-m-d h:i:s");
		
		$date               = new \DateTime();
		$current_time          = $date->format('U');
		$file_name=$firstname.'_'.$phoneno.'_'.$current_time;
		if(is_dir("lead_import_api_files/$source"))
		{
		  
		  //$myfile = fopen("lead_import_api_files/$source/$file_name.xml", "w") or die("Unable to open file!");
		
		}
		else
		{
			
			mkdir("lead_import_api_files/$source");
			
		  //echo ("$file is not a directory");
		}
		$myfile = fopen("lead_import_api_files/".$source."/".$file_name.".xml", "w") or die("Unable to open file!");
		fwrite($myfile, $xmlString);
		fclose($myfile);
		$xml = XmlParser::load("lead_import_api_files/$source/$file_name.xml");
		$leads = $xml->getContent();
		//echo $file_name;
		
		$dulicate_lead_count = lms_customerdetails::where('lcd_HomePhone',$phoneno)->where('created_at','>=',$ninety_days)->count();
		
		if($dulicate_lead_count==0)
		{
		$lms_customerdetails=new lms_customerdetails();
		$lms_calldetails=new lms_calldetails();
		$remap_outbound_leads=new remap_outboundleads();
		$lms_scheduleappointslots=new lms_scheduleappointslots();
		
		$lms_customerdetails->lcd_Zipcode =$leads->zipcode;
		$lms_customerdetails->lcd_FirstName =$leads->firstname;
		$lms_customerdetails->lcd_LastName =$leads->lastname;
		$lms_customerdetails->lcd_CoownerName =$leads->coowner;
		$lms_customerdetails->lcd_Address =$leads->streetaddress;
		$lms_customerdetails->lcd_CrossStreet =$leads->crossstreet;
		$lms_customerdetails->lcd_City =$leads->city;
		$lms_customerdetails->lcd_State =$leads->state;
		$lms_customerdetails->lcd_HomePhone =$leads->phoneno;
		$lms_customerdetails->lcd_CellPhone =$leads->secondaryno;
		$lms_customerdetails->lcd_WorkPhone =$leads->thirdno;
		$lms_customerdetails->lcd_EmailAddress =$leads->email;
		$lms_customerdetails->lcd_Comments =$leads->comments;
		$lms_customerdetails->lcd_HousecColor =$leads->house_color;
		$lms_customerdetails->save();
		
		$lms_calldetails->lld_CustomerId =$lms_customerdetails->lcd_CustomerId;
		$lms_calldetails->lld_ProductCode =$leads->refacingtype;
		$lms_calldetails->lld_AssociateId =$leads->associateid;
		$lms_calldetails->lld_StoreId =$leads->storeno;
		$lms_calldetails->lld_ProsepctId =$leads->prospectid;
		$lms_calldetails->lld_Source =$leads->source;
		if(($leads->RefStore)!="")
		{
			$lms_calldetails->lld_RefStore =$leads->RefStore;
		}
		else
		{
			$lms_calldetails->lld_RefStore =$leads->storeno;
		}
		$lms_calldetails->save();


		$remap_outbound_leads->rol_ApptId =$leads->apptid;
		$remap_outbound_leads->rol_LmsId =$leads->lmsid;
		$remap_outbound_leads->rol_CrmId =$leads->crmid;
		$remap_outbound_leads->rol_CreatedDt1 =$leads->createddt;
		$remap_outbound_leads->rol_ModifiedDt1 =$leads->modifieddt;
		$remap_outbound_leads->rol_RefacingType =$leads->refacingtype;
		$remap_outbound_leads->rol_Zipcode =$leads->zipcode;
		$remap_outbound_leads->rol_ApptDate =$leads->apptdate;
		$remap_outbound_leads->rol_ApptTime =$leads->appttime;
		$remap_outbound_leads->rol_FirstName =$leads->firstname;
		$remap_outbound_leads->rol_LastName =$leads->lastname;
		$remap_outbound_leads->rol_Coowner =$leads->coowner;
		$remap_outbound_leads->rol_StreetAddress =$leads->streetaddress;
		$remap_outbound_leads->rol_AddressLine2 =$leads->addressline2;
		$remap_outbound_leads->rol_CrossStreet =$leads->crossstreet;
		$remap_outbound_leads->rol_City =$leads->city;
		$remap_outbound_leads->rol_State =$leads->state;
		$remap_outbound_leads->rol_PhoneNo =$leads->phoneno;
		$remap_outbound_leads->rol_SecondaryNo =$leads->secondaryno;
		$remap_outbound_leads->rol_ThirdNo =$leads->thirdno;
		$remap_outbound_leads->rol_Email =$leads->email;
		$remap_outbound_leads->rol_Comments =$leads->comments;
		$remap_outbound_leads->rol_ScAssoc =$leads->sc_assoc;
		$remap_outbound_leads->rol_ScVer =$leads->sc_ver;
		$remap_outbound_leads->rol_AssociateId =$leads->associateid;
		$remap_outbound_leads->rol_StoreNo =$leads->storeno;
		$remap_outbound_leads->rol_UsrIsp =$leads->usr_isp;
		$remap_outbound_leads->rol_ProspectId =$leads->prospectid;
		$remap_outbound_leads->rol_CallbackNo =$leads->callbackno;
		$remap_outbound_leads->rol_Reference =$leads->reference;
		$remap_outbound_leads->rol_Source =$leads->source;
		$remap_outbound_leads->rol_TeleRepId =$leads->telerepid;
		$remap_outbound_leads->rol_Dwelling =$leads->dwelling;
		$remap_outbound_leads->rol_CommunityName =$leads->community_name;
		$remap_outbound_leads->rol_HouseColor =$leads->house_color;
		$remap_outbound_leads->rol_Result =$leads->result;
		$remap_outbound_leads->rol_SpecialOffers =$leads->specialoffers;
		$remap_outbound_leads->rol_RefStore =$leads->RefStore;
		$remap_outbound_leads->save();

		/*$lms_customerslots->lcs_CustomerId =$lms_customerdetails->lcd_CustomerId;
		$lms_customerslots->lcs_AppDate =$leads->apptdate;
		$lms_customerslots->lcs_AppTime =$leads->appttime;
		$lms_customerslots->save();*/


		$appdate =$leads->apptdate;
		$apptime =$leads->appttime;
		if((isset($appdate) && $appdate!='') && (isset($apptime) && $apptime!=''))
		{
		$territory_id_fet = $this->CalendarRepository->get_territory_based_zipcode($leads->zipcode);
		//echo $territory_id_fet."/";
		$calendar_id_fet  = $this->CalendarRepository->get_calendar_based_territory($territory_id_fet);
		//echo $calendar_id_fet."/";
		$week_id=lms_weeks::where('lw_WeekStartDate','<=',$appdate)->where('lw_WeekEndDate','>=',$appdate)->value('lw_WeekId');
		//echo $week_id."/";
		$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
		//echo $slot_id."/";
		 $date_master_id=date('w',strtotime($appdate));
		if($date_master_id==0)
		{
			 $date_master_id=7;
		}
		 $time_master_id = lms_timemasters::join('lms_times', 'lms_timemasters.ltm_TimeId', '=','lms_times.lt_TimeId')
		->where('ltm_DateMasterId',$date_master_id)->where('ltm_CalenProduct',$calendar_id_fet)->where('lt_TimeMaster',$apptime)->value('ltm_TimeMasterId');

		echo $time_master_id."/";
		$actual   = lms_slotrelations::where("lsr_SlotId",$slot_id)->where("lsr_DateMasterId",$date_master_id)
		->where("lsr_TimeMasterId",$time_master_id)->value("lsr_Actual");
		
		echo $actual."/";

		if($actual>0)
		{
			$allocated = lms_slotrelations::select('lsr_Allocated')->where('lsr_SlotId',$slot_id)->where('lsr_DateMasterId',$date_master_id)
			->where('lsr_TimeMasterId',$time_master_id)->increment('lsr_Allocated');
			$lms_customerslots=new lms_customerslots();
			$max_leadid = lms_customerslots::max('lcs_LeadID');
			if($max_leadid==0)
			{
				$lms_customerslots->lcs_LeadID =1;
			}
			else
			{
				$lms_customerslots->lcs_LeadID =$max_leadid+1;
			}
			
			$lms_customerslots->lcs_SlotId =$slot_id;
			$lms_customerslots->lcs_CustomerId =$lms_customerdetails->lcd_CustomerId;
			$lms_customerslots->lcs_LeadCaption ='NR';
			
			$lms_customerslots->lcs_WeekSlotId =$week_id;
			$lms_customerslots->lcs_DateMasterId =$date_master_id;
			$lms_customerslots->lcs_TimeMasterId =$time_master_id;
			$lms_customerslots->lcs_ApponimtentDate =$appdate;
			$lms_customerslots->lcs_AppointmentTime =$apptime;
			$lms_customerslots->save();
			$lms_scheduleappointslots->lsa_SlotId =$slot_id;
			$lms_scheduleappointslots->lsa_DateMasterId =$date_master_id;
			$lms_scheduleappointslots->lsa_TimeMasterId =$time_master_id;
			$lms_scheduleappointslots->lsa_LoackStatus ="Lock";
			$lms_scheduleappointslots->lsa_LockCalenStatus =2;
			$lms_scheduleappointslots->lsa_RequestId =$lms_customerdetails->lcd_CustomerId."_".$current_time;
			$lms_scheduleappointslots->save();
			echo "Success";
		}
		else
		{
			echo "Not Avaliable";
		}
		}
		else
		{
		$lms_customerslots=new lms_customerslots();
		$lms_customerslots->lcs_CustomerId  = $lms_customerdetails->lcd_CustomerId;
		$lms_customerslots->save();
		echo "Success";
		}
		}
		else
		{
			$dulicate_lead_id = lms_customerdetails::where('lcd_HomePhone',$phoneno)->where('created_at','>=',$ninety_days)->value('lcd_CustomerId');
			
			$lms_duplicaterecords=new lms_duplicaterecords();
			$lms_duplicaterecords->ldr_CustomerId =$dulicate_lead_id;
			$lms_duplicaterecords->ldr_ApptId =$leads->apptid;
			$lms_duplicaterecords->ldr_LmsId =$leads->lmsid;
			$lms_duplicaterecords->ldr_CrmId =$leads->crmid;
			$lms_duplicaterecords->ldr_CreatedDt1 =$leads->createddt;
			$lms_duplicaterecords->ldr_ModifiedDt1 =$leads->modifieddt;
			$lms_duplicaterecords->ldr_RefacingType =$leads->refacingtype;
			$lms_duplicaterecords->ldr_Zipcode =$leads->zipcode;
			$lms_duplicaterecords->ldr_ApptDate =$leads->apptdate;
			$lms_duplicaterecords->ldr_ApptTime =$leads->appttime;
			$lms_duplicaterecords->ldr_FirstName =$leads->firstname;
			$lms_duplicaterecords->ldr_LastName =$leads->lastname;
			$lms_duplicaterecords->ldr_Coowner =$leads->coowner;
			$lms_duplicaterecords->ldr_StreetAddress =$leads->streetaddress;
			$lms_duplicaterecords->ldr_AddressLine2 =$leads->addressline2;
			$lms_duplicaterecords->ldr_CrossStreet =$leads->crossstreet;
			$lms_duplicaterecords->ldr_City =$leads->city;
			$lms_duplicaterecords->ldr_State =$leads->state;
			$lms_duplicaterecords->ldr_PhoneNo =$leads->phoneno;
			$lms_duplicaterecords->ldr_SecondaryNo =$leads->secondaryno;
			$lms_duplicaterecords->ldr_ThirdNo =$leads->thirdno;
			$lms_duplicaterecords->ldr_Email =$leads->email;
			$lms_duplicaterecords->ldr_Comments =$leads->comments;
			$lms_duplicaterecords->ldr_ScAssoc =$leads->sc_assoc;
			$lms_duplicaterecords->ldr_ScVer =$leads->sc_ver;
			$lms_duplicaterecords->ldr_AssociateId =$leads->associateid;
			$lms_duplicaterecords->ldr_StoreNo =$leads->storeno;
			$lms_duplicaterecords->ldr_UsrIsp =$leads->usr_isp;
			$lms_duplicaterecords->ldr_ProspectId =$leads->prospectid;
			$lms_duplicaterecords->ldr_CallbackNo =$leads->callbackno;
			$lms_duplicaterecords->ldr_Reference =$leads->reference;
			$lms_duplicaterecords->ldr_Source =$leads->source;
			$lms_duplicaterecords->ldr_TeleRepId =$leads->telerepid;
			$lms_duplicaterecords->ldr_Dwelling =$leads->dwelling;
			$lms_duplicaterecords->ldr_CommunityName =$leads->community_name;
			$lms_duplicaterecords->ldr_HouseColor =$leads->house_color;
			$lms_duplicaterecords->ldr_Result =$leads->result;
			$lms_duplicaterecords->ldr_SpecialOffers =$leads->specialoffers;
			$lms_duplicaterecords->ldr_RefStore =$leads->RefStore;
			$lms_duplicaterecords->save();
			echo "duplicate";
		}
		//$week_id=lms_weeks::whereBetween('reservation_from', [$from, $to])->get();
		
	}
}