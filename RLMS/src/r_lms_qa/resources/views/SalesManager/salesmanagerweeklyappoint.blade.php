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
	$.ajaxSetup({header:$('meta[name="_token"]').attr('content')})
    e.preventDefault(e);
	$.ajax({

        type:"GET",
		//url:'./weeklyApp',
        url:'./salesManWeeklyApp',
        data:$(this).serialize(),
        dataType: 'html',
        success: function(data){
            console.log(data);
        },
        error: function(data){

        }
    });
	
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
	
});
function slotValidateForScheduled(last_given_slot_value, date_master, time_master,manager_request)
{
	var last_given_slot_value1 = last_given_slot_value;
	var sched_slot_id=$("#lmss_slot_id").val();
	var sched_territory_id=$("#lmss_territory_id").val(); 
	var manager_request_id = "slot_"+date_master+"_"+time_master;
	//var get_slot_value=$("#get_slot_value").val();
	var ajax_data = {'sched_slot_id' : sched_slot_id , 'sched_territory_id' : sched_territory_id , 'sched_date_master' : date_master, 'sched_time_master' : time_master}
	$.ajax({
	type:"GET",
	url:"slotValidateSalesManeger",
	data:ajax_data,
	dataType:"json",
	success:function(result)
	{
		var result = result['lsr_Allocated'];
		alert(result);
		var max_manager_request = Math.round(last_given_slot_value*1.5);
		alert(max_manager_request);
		if(max_manager_request < result)
		{
			alert('Not allowed, The slots are already filled'); 
			$("#mgr_slot_"+date_master+"_"+time_master).val(manager_request);
			return false;
		}
		else
		{
			alert('test');
			//$("#get_slot_value").val("0");
			return true;
		}
	}
	});
}
</script>
<style>
.x_panel {
    padding: 8px 3px !important;
}
</style>

<div class="col-md-12 col-sm-6 col-xs-12">

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
                         
                          <td><input type="text" placeholder=".col-md-1" class="form-control" name="lmss_total_reps" value="{{$slot_relation_det[0]['ls_TotalReps']}}" id="lmss_total_reps"></td>
                          <td><input type="text" placeholder=".col-md-1" class="form-control" name="lmss_week_reps" id="lmss_week_reps" value="{{$slot_relation_det[0]['ls_WeekReps']}}"></td>
						  <td><input type="text" placeholder=".col-md-2" class="form-control single_cal1" name="week_start_date" id="week_start_date"  value="{{$slot_relation_det[0]['lw_WeekStartDate']}}"></td>
                        </tr>
                        
                      </tbody>
                    </table>	

                  </div>
                </div>
              </div>
			  <!-- lmss_week_id,, -->
			
			 <input type="hidden" value="{{$weekly_app_result[0]['ls_WeekId']}}" id="lmss_week_id" name="lmss_week_id">
			 <input type="hidden" value="{{$weekly_app_result[0]['ls_SlotId']}}" id="lmss_slot_id" name="lmss_slot_id" id="lmss_slot_id">
			 <input type="hidden" value="{{$weekly_app_result[0]['ls_TerritoryId']}}" id="lmss_territory_id" name="lmss_territory_id">
			 <input type="hidden" value="{{$weekly_app_result[0]['ls_CalenProduct']}}" id="lmss_calen_product" name="lmss_calen_product">
			 {{$date_exist=""}}
				
			 @for($i=0;$i<count($weekly_app_result);$i++) 
				 @if($date_exist!=$weekly_app_result[$i]['ldm_DateMaster'])
			  <div class="clearfix"></div>
<div class="col-md-12" style="width:100%;font-weight:bold;text-align:left;">
<div class="calen_disp" >
<div class="x_panel" style="border:0px;">
                        
                         
                          
                        
                          
	  <?php 
	  $date_exist=$weekly_app_result[$i]['ldm_DateMaster'];
	  $date_array[] = $date_exist;
	  $start_date   = $weekly_app_result[$i]['lw_WeekStartDate'];
	  $weekDay      = $weekly_app_result[$i]['ltm_DateMasterId'];
	  $dateList     =  date('d-m-Y', strtotime($start_date .' +'.$weekDay.' day'));
	  
	   ?>
		 {{$weekly_app_result[$i]['ldm_DateMaster']}}
			 {{$dateList}}			 
						   
                     

                  </div>
                </div>
              </div>
<div style="clear:both;"></div>			  
			  
			   
			  
			  
			   @endIf
			 @if(in_array($weekly_app_result[$i]['ldm_DateMaster'],$date_array))
			 <div class="col-md-2 col-sm-1 col-xs-6 calen_disp" >
		     <div class="x_panel" style="text-align:center;">{{$weekly_app_result[$i]['lt_TimeMaster'] }}
			 <div align="center">
		     <input type="text" style="width:40px;text-align:center" value="{{$weekly_app_result[$i]['lsr_ManagerRequest'] }}" style="text-align:center" class="form-control form-control_wek mgr_slot_array" id="mgr_slot_{{$weekly_app_result[$i]['ltm_DateMasterId'] }}_{{$weekly_app_result[$i]['ltm_TimeMasterId'] }}" name="mgr_slot_{{$weekly_app_result[$i]['ltm_DateMasterId'] }}_{{$weekly_app_result[$i]['ltm_TimeMasterId'] }}" onchange="slotValidateForScheduled(this.value,'<?php echo $weekly_app_result[$i]['ltm_DateMasterId']; ?>','<?php echo$weekly_app_result[$i]['ltm_TimeMasterId']; ?>', '<?php echo $weekly_app_result[$i]['lsr_ManagerRequest']; ?>')"/> 
			  </div>
		     </div>
			</div>
					 
					 

                  
		     @endIf
			 
			 @endFor 
			 <div class="col-md-12 col-sm-1 col-xs-6 calen_disp" >
			 <textarea id="message" required="required" class="form-control" name="message" style="width:50%; resize: none;" ></textarea></P>
			 <input type="submit" class="btn btn-success" name="approve_request" id="approve_request" value="Submit">
			 
			 
			 <button type="button" class="btn btn-danger">Cancel</button>
			 </div>
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
  
