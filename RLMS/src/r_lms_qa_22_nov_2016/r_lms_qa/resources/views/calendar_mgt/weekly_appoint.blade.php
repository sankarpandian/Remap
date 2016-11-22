@extends('layouts.master')

@section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
 <!-- bootstrap-daterangepicker -->
<script src="{{ URL::asset('assets/datePicker/moment/moment.min.js')}}"></script>
<script src="{{ URL::asset('assets/datepicker/datepicker/daterangepicker.js')}}"></script>
<script>
var $j = jQuery;
jQuery(function($) {	
$('.single_cal1').daterangepicker({
	      format: 'YYYY-MM-DD',
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });	
});	
$("document").ready(function(){
	

$("#weely_appoint_form").on("submit",function(e)
{
	//alert('hihi');
	
	var test=$("#get_slot_value").val();
	//alert(test);
	if(test==1)
	{
		return false;
	}
	if($("#lmss_total_reps").val()=='')
	{
		alert("Please Enter Total Reps #");
		return false;
	}
	else if($("#lmss_week_reps").val()=='')
	{
		alert("Please Enter Total Reps In Training #");
		return false;
	}
	else if($("#week_start_date").val()=='')
	{
		
		alert("Please select Date");
		return false;
		
	}
	else
	{
	$.ajaxSetup({header:$('meta[name="_token"]').attr('content')})
    e.preventDefault(e);
	$.ajax({

        type:"GET",
        url:'./weekly_app',
        data:$(this).serialize(),
        dataType: 'html',
        success: function(data){
            console.log(data);
        },
        error: function(data){
        
        }
    });	
	return true;
	}
	
	
	
	
	
	return false;
    });

	$("#approve_pending").on("click",function(){
		
		var lmss_slot_id       = $("#lmss_slot_id").val();
		var lmss_territory_id  = $("#lmss_territory_id").val();
		var lmss_week_reps     = $("#lmss_week_reps").val();
		var lmss_total_reps    = $("#lmss_total_reps").val();
		var week_start_date    = $("#week_start_date").val();
		var message            = $("#message_approve").val();
		
		var lmss_calen_product = $("#lmss_calen_product").val();
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			   type: "GET",
			   url : "./call_from_ajax",
			   data: {"ajax_mode": "update_pending_review", "lmss_slot_id" : lmss_slot_id, "lmss_territory_id" : lmss_territory_id, "lmss_week_reps" : lmss_week_reps, "lmss_total_reps" : lmss_total_reps,"message":message, "week_start_date" : week_start_date,"lmss_calen_product":lmss_calen_product,_token: CSRF_TOKEN},
			   dataType: "html",
			   async   : false,
			   success: function(data)
			   {
				  if(data=='success') 
				  {
					//  alert(data);
					
					$("#display_prove_success").html('<div class="alert alert-info alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Review!</strong> Updated Successfully</div>');
				  }
			   }   
			   });
			   return false;
	});
// For Submit validation	
$("input.actual_slot_array").on("change",function()
{
	var territoryId        = $("#lmss_territory_id").val();
	var slotId             = $("#lmss_slot_id").val();
	var getSlotValue       = $(this).val();
	var lastSlotValue      = $("#get_slot_value").val();
	var getTimeDateId      = $(this).attr('name');
	var last_given_slot_value = $(this).val();
	var getTimeDate        = getTimeDateId.split('_');
	var dateMasterId       = getTimeDate[2];
	var timemasterId       = getTimeDate[3];
	var ajax_data          = {'slotId' : slotId , 'territoryId' : territoryId , 'dateMasterId' : dateMasterId, 'timemasterId' : timemasterId}
	$.ajax({
	type:"GET",
	url:"./scheduleslot",
	data:ajax_data,
	dataType:"html",
	success:function(result)
	{
		//alert(result);
		var result = parseInt(result);
		if(last_given_slot_value<result)
		{  
		  $("#get_slot_value").val("1");
		}
		else
		{
			return false;
		}
	}
	});
});

// For on change validation
$("input.actual_slot_array").on("change",function(){
   	var getSlotValue       = $(this).val();
	
	var actualSlotId      = $(this).attr('id');
	
	var last_given_slot_value = $(this).val();
	var actualSlot            = actualSlotId.split('_');
	var dateMasterId          = actualSlot[2];
	var timemasterId          = actualSlot[3];
     //alert(dateMasterId);
    var confirmSlotval     = $("#conf_slot_"+dateMasterId+"_"+timemasterId).val();
	var managerRequestval     = $("#mgr_slot_"+dateMasterId+"_"+timemasterId).val();	
	var actualSlotval      = $("#"+actualSlotId).val();
	//alert(managerRequestval);
	//var actual 			= $('#'+actual_id).val(); 
	//var manager_request	= $('#'+manager_request_id).val();
	if( parseInt(managerRequestval)!=0 ) //Case - MR not be zero
	{
		
		 if( parseInt(actualSlotval) > parseInt(managerRequestval)*3 )
		{
		    //case if actual is greater than thrice of manager request
			$('#'+actualSlotId).val(managerRequestval*3);
		}	
	}
	else
	{
		$("#conf_slot_"+dateMasterId+"_"+timemasterId).val("0");
		$('#'+actualSlotId).val("0");
	}
	
	
});
/*	
$("input.conf_act_slot_array").on("change",function()
{
	var territoryId        = $("#lmss_territory_id").val();
	var slotId             = $("#lmss_slot_id").val();
	var getSlotValue       = $(this).val();
	var lastSlotValue      = $("#get_slot_value").val();
	var getTimeDateId      = $(this).attr('name');
	var last_given_slot_value = $(this).val();
	var getTimeDate        = getTimeDateId.split('_');
	var dateMasterId       = getTimeDate[2];
	var timemasterId       = getTimeDate[3];
	
	var existVal           = $(this).attr('data-existVal'); 
	//alert(getTimeDateId);
	//alert(existVal);
	var ajax_data          = {'slotId' : slotId , 'territoryId' : territoryId , 'dateMasterId' : dateMasterId, 'timemasterId' : timemasterId}
	$.ajax({
	type:"GET",
	url:"./confrimslot",
	data:ajax_data,
	dataType:"html",
	success:function(result)
	{
		//alert(result);
		var confirm_result=confirm('There is already '+result+' Lead/s confirmed for this slot. Do you want Proceed with this update?');
			if(confirm_result==false)
			{
			$('#'+getTimeDateId).val(existVal);
			}
	}
	});
});
*/
// For on change validation *2 check for slot confirm
$("input.conf_act_slot_array").on("change",function(){
	
   	var getConSlotValue       = $(this).val();
	var confirmSlotId          = $(this).attr('id');
	var last_given_conf_slot_value = $(this).val();
	var confirmSlot            = confirmSlotId.split('_');
	var dateMasterId           = confirmSlot[2];
	var timemasterId           = confirmSlot[3];
     //alert(dateMasterId);
    var actualSlotval         = $("#actual_slot_"+dateMasterId+"_"+timemasterId).val();
	var managerRequestval      = $("#mgr_slot_"+dateMasterId+"_"+timemasterId).val();	
	
	
	if(parseInt(managerRequestval) == 0)	//case - if MR is zero
	{
		$('#'+confirmSlotId).val("0");
		$("#actual_slot_"+dateMasterId+"_"+timemasterId).val("0");
	}
	else
	{
		if( parseInt( $('#'+confirmSlotId).val() ) > parseInt(managerRequestval)*2 )
		{
			//Case - Conf max will be MR X 2
			$('#'+confirmSlotId).val( parseInt((managerRequestval)*2));
		}
				
	}

	
});


});


</script>
<style>
.calen_disp {
    width: 25%;
}
.form-control_wek
{
	height:22px;
	width: 35%;
	padding:6px 6px;
}
th,td,tr{text-align:center !important;}
.modal-sm {width:400px;}
.table {
	    margin-bottom: 0px;
}
.x_content
{
	padding: 0 5px 0px;
}
</style>
<div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">
                  
                  <div class="x_content">

                    <table class="table">
                      <thead>
                        <tr>
                         
                          <th>Sales Manager</th>
                          <th>Territory</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                         
                          <td>{{$slot_relation_det[0]['lb_SalesMgr']}}</td>
                          <td>{{$slot_relation_det[0]['lb_Address']}}</td>
                         
                        </tr>
                       
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>

		<form action="weely_appoint_form" name="weely_appoint_form" id="weely_appoint_form" method="GET">	  
		<meta name="csrf-token" content="{{ csrf_token() }}" />
			  <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">

                    <table class="table table-striped">
                      <thead>
                        <tr>
                         
                          <th>Legend</th>
                          
                          
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                         
                          <td>MR       -  Manager Request &nbsp;&nbsp;&nbsp;
							Sched  -  Schedule &nbsp;&nbsp;&nbsp;
							Conf    -  Confirmation
							</td>
                          
                        </tr>
                        
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
			  
			  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">

                    <table class="table table-striped">
                      <thead>
                        <tr>
                         
                          <th>Total # Reps Running</th>
						  <th>Total # Reps in Training</th>
                          <th>Projected Start Date</th>
                          
                        </tr>
                      </thead>
                      <tbody>
<tr>
   <td><input type="text" placeholder="Total # Reps Running" class="form-control" name="lmss_total_reps" value="{{$slot_relation_det[0]['ls_TotalReps']}}" id="lmss_total_reps"></td>
  <td><input type="text" placeholder="Total # Reps in Training" class="form-control" name="lmss_week_reps" id="lmss_week_reps" value="{{$slot_relation_det[0]['ls_WeekReps']}}"></td>
  <td><input type="text" placeholder="Projected Start Date" class="form-control single_cal1" name="week_start_date" id="week_start_date"   value="{{$slot_relation_det[0]['lw_WeekStartDate']}}"></td>
</tr>
                        
                      </tbody>
                    </table>	

                  </div>
                </div>
              </div>
			  <!-- lmss_week_id,, -->
<input type="hidden" name="get_slot_value" id="get_slot_value" value="0" />
<input type="hidden" value="{{$weekly_app_result[0]['ls_WeekId']}}" id="lmss_week_id" name="lmss_week_id">
<input type="hidden" value="{{$weekly_app_result[0]['ls_SlotId']}}" id="lmss_slot_id" name="lmss_slot_id" id="lmss_slot_id">
<input type="hidden" value="{{$weekly_app_result[0]['ls_TerritoryId']}}" id="lmss_territory_id" name="lmss_territory_id">
<input type="hidden" value="{{$weekly_app_result[0]['ls_CalenProduct']}}" id="lmss_calen_product" name="lmss_calen_product">
			 {{$date_exist=""}}
				
			 @for($i=0;$i<count($weekly_app_result);$i++) 
				 @if($date_exist!=$weekly_app_result[$i]['ldm_DateMaster'])
			  <div class="col-md-6 col-sm-6 col-xs-12 calen_disp">
                <div class="x_panel">
                  
                  <div class="x_content">

                    <table>
                      <thead>
                        
                         
                          
                        
                          
						  <?php 
					      $date_exist=$weekly_app_result[$i]['ldm_DateMaster'];
						  $date_array[] = $date_exist;
					       ?>
							 <tr>
							 <th>{{$weekly_app_result[$i]['ldm_DateMaster']}}</th> 
							 </tr>
						 
						   
                      </thead>
                      
                    </table>

                  </div>
                </div>
              </div>
			  
			  
			   
			  
			  
			   @endIf
			 @if(in_array($weekly_app_result[$i]['ldm_DateMaster'],$date_array))
			 <div class="col-md-6 col-sm-6 col-xs-12 calen_disp">
                <div class="x_panel" style="padding:10px 36px">
                  
                  <div class="x_content" style="padding:0 5px 0px">

                    <table >
                      
                      <tbody>
					  <tr ><th colspan="3">{{$weekly_app_result[$i]['lt_TimeMaster'] }}</th></tr>
                        <tr>
                         
                          <td>MR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Sched &nbsp; </td><td>Conf </td>
                          
                        </tr>
                        <tr>
                         
					  <td>
					  <input type="text" readonly="readonly" value="{{$weekly_app_result[$i]['lsr_ManagerRequest'] }}" style="width:30px;" class="form-control form-control_wek mgr_slot_array" id="mgr_slot_{{$weekly_app_result[$i]['ltm_DateMasterId'] }}_{{$weekly_app_result[$i]['ltm_TimeMasterId'] }}" name="mgr_slot_{{$weekly_app_result[$i]['ltm_DateMasterId'] }}_{{$weekly_app_result[$i]['ltm_TimeMasterId'] }}"/> 
					  </td>
					  <td>
					  <input type="text" class="form-control form-control_wek actual_slot_array" value="{{$weekly_app_result[$i]['lsr_Actual'] }}" id="actual_slot_{{$weekly_app_result[$i]['ltm_DateMasterId'] }}_{{$weekly_app_result[$i]['ltm_TimeMasterId'] }}" style="width:30px;" name="actual_slot_{{$weekly_app_result[$i]['ltm_DateMasterId'] }}_{{$weekly_app_result[$i]['ltm_TimeMasterId'] }}"/> 
					  </td>
					  <td>
					  <input type="text" data-existVal="{{$weekly_app_result[$i]['lsr_ConfirmationActual'] }}" value="{{$weekly_app_result[$i]['lsr_ConfirmationActual'] }}" style="width:30px;" class="form-control form-control_wek conf_act_slot_array" id="conf_slot_{{$weekly_app_result[$i]['ltm_DateMasterId'] }}_{{$weekly_app_result[$i]['ltm_TimeMasterId'] }}" name="conf_slot_{{$weekly_app_result[$i]['ltm_DateMasterId'] }}_{{$weekly_app_result[$i]['ltm_TimeMasterId'] }}"/>
					  </td>
                          
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
		     @endIf
			 @endFor 
			 <p><textarea id="message" required="required" class="form-control" name="message" style="width:50%; resize: none;" ></textarea></P>
			 <input type="submit" class="btn btn-success" name="approve_request" id="approve_request" value="Approve">
			 <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg">Pending Review</button>
			 
			 
			 <button type="button" class="btn btn-danger">Cancel</button>
			 
		</form>	 
		<form >
		
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2"></h4>
                        </div>
                        <div class="modal-body">
						<div id="display_prove_success"></div>
                         <p>Are You sure you want to send this to sales manager for clarification</p>
						 
						 
						<p> If Yes please enter any comment below then click ok</p>
                         
						<p><textarea id="message_approve" required="required" class="form-control" name="message" style="width:100%; resize: none;" ></textarea></P>  
						 
						  
						  
                        </div>
                        <div class="modal-footer">
                          
                         <button type="button" class="btn btn-success" name="approve_pending" id="approve_pending">Ok</button>
						 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						
                        </div>

                      </div>
                    </div>
                  </div>
				  
			</form>	
@endsection		  
  
