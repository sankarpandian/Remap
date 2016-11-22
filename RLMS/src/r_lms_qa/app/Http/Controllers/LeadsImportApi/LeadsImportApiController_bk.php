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
use App\Models\remap_outbound_leads;
use App\Models\lms_customerslots;
use App\Models\lms_weeks;
use App\Models\lms_slots;
use App\Models\lms_timemasters;
use App\Models\lms_times;
use App\Models\lms_slotrelations;




class LeadsImportApiController extends Controller
{
	public function convert_to_xml()
	{
		
		
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
		$current_time=date("Y-m-d h:i:s");
		
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
		
		//echo $file_name;
		
		$xml = XmlParser::load("lead_import_api_files/$source/$file_name.xml");
		$leads = $xml->getContent();
		$lms_customerdetails=new lms_customerdetails();
		$lms_calldetails=new lms_calldetails();
		$remap_outbound_leads=new remap_outbound_leads();
		
		
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


		$remap_outbound_leads->apptid =$leads->apptid;
		$remap_outbound_leads->lmsid =$leads->lmsid;
		$remap_outbound_leads->crmid =$leads->crmid;
		$remap_outbound_leads->createddt =$leads->createddt;
		$remap_outbound_leads->modifieddt =$leads->modifieddt;
		$remap_outbound_leads->refacingtype =$leads->refacingtype;
		$remap_outbound_leads->zipcode =$leads->zipcode;
		$remap_outbound_leads->apptdate =$leads->apptdate;
		$remap_outbound_leads->appttime =$leads->appttime;
		$remap_outbound_leads->firstname =$leads->firstname;
		$remap_outbound_leads->lastname =$leads->lastname;
		$remap_outbound_leads->coowner =$leads->coowner;
		$remap_outbound_leads->streetaddress =$leads->streetaddress;
		$remap_outbound_leads->addressline2 =$leads->addressline2;
		$remap_outbound_leads->crossstreet =$leads->crossstreet;
		$remap_outbound_leads->city =$leads->city;
		$remap_outbound_leads->state =$leads->state;
		$remap_outbound_leads->phoneno =$leads->phoneno;
		$remap_outbound_leads->secondaryno =$leads->secondaryno;
		$remap_outbound_leads->thirdno =$leads->thirdno;
		$remap_outbound_leads->email =$leads->email;
		$remap_outbound_leads->comments =$leads->comments;
		$remap_outbound_leads->sc_assoc =$leads->sc_assoc;
		$remap_outbound_leads->sc_ver =$leads->sc_ver;
		$remap_outbound_leads->associateid =$leads->associateid;
		$remap_outbound_leads->storeno =$leads->storeno;
		$remap_outbound_leads->usr_isp =$leads->usr_isp;
		$remap_outbound_leads->prospectid =$leads->prospectid;
		$remap_outbound_leads->callbackno =$leads->callbackno;
		$remap_outbound_leads->reference =$leads->reference;
		$remap_outbound_leads->source =$leads->source;
		$remap_outbound_leads->telerepid =$leads->telerepid;
		$remap_outbound_leads->dwelling =$leads->dwelling;
		$remap_outbound_leads->community_name =$leads->community_name;
		$remap_outbound_leads->house_color =$leads->house_color;
		$remap_outbound_leads->result =$leads->result;
		$remap_outbound_leads->specialoffers =$leads->specialoffers;
		$remap_outbound_leads->refstore =$leads->RefStore;
		$remap_outbound_leads->save();

		/*$lms_customerslots->lcs_CustomerId =$lms_customerdetails->lcd_CustomerId;
		$lms_customerslots->lcs_AppDate =$leads->apptdate;
		$lms_customerslots->lcs_AppTime =$leads->appttime;
		$lms_customerslots->save();*/


		$appdate =$leads->apptdate;
		$apptime =$leads->appttime;

		
		$week_id=lms_weeks::where('lw_WeekStartDate','<=',$appdate)->where('lw_WeekEndDate','>=',$appdate)->value('lw_WeekId');
		//echo $week_id."/";
		$slot_id=lms_slots::where('ls_WeekId',$week_id)->where('ls_TerritoryId',$territory_id_fet)->where('ls_CalenProduct',$calendar_id_fet)->value('ls_SlotId');
		//echo $slot_id."/";
		$date_master_id=date('w',strtotime($appdate));
		$time_master_id = lms_timemasters::join('lms_times', 'lms_timemasters.ltm_TimeId', '=','lms_times.lt_TimeId')
		->where('ltm_DateMasterId',$date_master_id)->where('ltm_CalenProduct',$calendar_id_fet)->where('lt_TimeMaster',$apptime)->value('ltm_TimeMasterId');

		//echo $time_master_id."/";
		$actual = lms_slotrelations::where('lsr_SlotId',$slot_id)->where('lsr_DateMasterId',$date_master_id)
		->where('lsr_TimeMasterId',$time_master_id)->whereRaw('lsr_Actual-lsr_Allocated > 0')->value('lsr_Allocated');
		
		//echo $actual."/";

		if($actual>0)
		{
			$allocated = lms_slotrelations::select('lsr_Allocated')->where('lsr_SlotId',$slot_id)->where('lsr_DateMasterId',$date_master_id)
			->where('lsr_TimeMasterId',$time_master_id)->increment('lsr_Allocated');
			//echo $allocated;
			$lms_customerslots=new lms_customerslots();
			//$max_leadid = 0;
			$max_leadid = lms_customerslots::max('lcs_LeadID');
			if($max_leadid==0)
			{
				//echo $max_leadid."lead0";
				$lms_customerslots->lcs_LeadID =1;
			}
			else
			{
				
				$lms_customerslots->lcs_LeadID =$max_leadid+1;
				//echo $max_leadid."lead1";
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
			//echo $lms_customerslots;
			echo "Success";
		}
		else
		{
			echo "Not Avaliable";
		}
		//$week_id=lms_weeks::whereBetween('reservation_from', [$from, $to])->get();
		
	}
}