$("document").ready(function()
{//previous week script
var product = $("#lld_ProductCode").val();
if(product!=null)
{
ajax_board_display('scheduling_calendar');		
}

$("#lld_ProductCode").on("change",function(){
ajax_board_display('scheduling_calendar');		
});


function ajax_board_display(calendar_type){ 
var calendar_type 		= calendar_type;// alert(calendar_type);
var week_id 		= $.trim( $("input#week_id").val() );
var org_week_id 	= $.trim( $("input#org_week_id").val() );
var zipcode = $("#zipcode").val();
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajax({
type: "GET",
url: "./inbound_ajax_zipcode",
data: {"zipcode" : zipcode,'week_id':week_id,'org_week_id':org_week_id,_token: CSRF_TOKEN},
dataType: "json",
success: function(data){
// alert(data);
var date_exist = "";
var date_array = ['0']; 
var lmst_time_master = "";
var display_calendar = "";
var count=0;
for(var i=0;i<data.length;i++)
{
var selected_date = data[i]['lw_WeekStartDate'];
var lmsdm_date_master = data[i]['ldm_DateMaster'];
var lmst_time_master  = data[i]['lt_TimeMaster'];
var days =i;
if(date_exist!=lmsdm_date_master)
{
var selected_date 	= new Date(data[i]['lw_WeekStartDate']); 
var numberOfDaysToAdd = 1;
if(i==0)
{
selected_date.setMonth(selected_date.getMonth() + 1);  
}
else
{
selected_date.setDate(selected_date.getDate() + (1+i)/3);  //alert(selected_date);
selected_date.setMonth(selected_date.getMonth() + 1); 
}
var date 			= selected_date.getDate();
var monthNames = [
				"January", "February", "March",
				"April", "May", "June",
				"July", "August", "September",
				"October", "November", "December"
				]; 

var month_name     = monthNames[selected_date.getMonth()];
var month 		   = selected_date.getMonth();
var year 		   = selected_date.getFullYear();
var correct_date   = date+'-'+month+'-'+year;
var appt_date      = year+'-'+month+'-'+date;
date_exist         = lmsdm_date_master;
display_calendar   = display_calendar+'<input type="hidden" id="lmss_calen_id" name="lmss_calen_id" value="'+data[i]['ls_CalenProduct']+'"><input type="hidden" id="lmss_slot_id" name="lmss_slot_id" value="'+data[i]['ls_SlotId']+'"><input type="hidden" id="lmss_territory_id" name="lmss_territory_id" value="'+data[i]['ls_TerritoryId']+'"><div class="clearfix"></div><div class="col-md-12" style="width:100%;font-weight:bold;text-align:left;"><div class="calen_disp" ><div class="x_panel" style="border:0px;">'+date_exist+'-'+correct_date+'</div></div></div><div style="clear:both;"></div>';
date_array.push(date_exist);
count++;
}
if($.inArray(data[i]['ldm_DateMaster'],date_array))
{
	if(calendar_type=='scheduling_calendar')
	{
		var actutal=data[i]['lsr_Actual'];
	}
	else if(calendar_type=='confirmation_calendar')
	{
			var actutal=data[i]['lsr_ConfirmationActual'];
	}
	
lmst_time_master     = data[i]['lt_TimeMaster'];
display_calendar = display_calendar+'<div class="col-md-3 col-sm-1 col-xs-6 calen_disp" ><div class="x_panel" style=text-align:center;">'+lmst_time_master+'<br><input type="radio" class="get_date_time" name="radio" id="get_date_time" data-month-name="'+month_name+'" data-date-only="'+appt_date+'" data-date="'+date+'" data-time="'+data[i]['lt_TimeMaster']+'" value="'+data[i]['ldm_DateMaster']+'" "'+data[i]['lt_TimeMaster']+'" data-dateMasterId="'+data[i]['ltm_DateMasterId']+'" data-dateTimeId="'+data[i]['ltm_TimeMasterId']+'" data-toggle="modal" data-target=".bs-example-modal-lg" >'+actutal+'&nbsp; Reps</div></div>';
}

}
//alert(display_calendar);


		if(calendar_type=='scheduling_calendar')
	{
		$("#display_calendar_id").html(display_calendar);
	}
	else if(calendar_type=='confirmation_calendar')
	{
			$("#confirm_display_calendar_id").html(display_calendar);
	}

}
});

}

$("#SchedulingCalen").on("click",function(){
	ajax_board_display( calendar_type='scheduling_calendar');
	$("#scheduleConfirm").val('schedule');
});

$("#ConfirmCalen").on("click",function(){
	ajax_board_display( calendar_type='confirmation_calendar');
	$("#scheduleConfirm").val('confirm');
});

$("a#previous_week").click(function(e){
e.preventDefault();
var org_week_id = $.trim( $("#org_week_id").val() ); 
if( parseInt(org_week_id) >= parseInt( $("#week_id").val() ) )
{
//case when previous week is less than current week
}
else
{
var week_id = parseInt( $("#week_id").val() )-1;
$("#week_id").val( week_id );
}
ajax_board_display( calendar_type='scheduling_calendar');
return false;
});
$("a#next_week").click(function(e){
e.preventDefault();	
var org_week_id = $.trim( $("#org_week_id").val() );
var week_id = parseInt( $("#week_id").val() )+1;
$("#week_id").val( week_id );       
ajax_board_display( calendar_type='scheduling_calendar');
return false;
});


$("a#cprevious_week").click(function(e){
e.preventDefault();
var org_week_id = $.trim( $("#org_week_id").val() ); 
if( parseInt(org_week_id) >= parseInt( $("#week_id").val() ) )
{
//case when previous week is less than current week
}
else
{
var week_id = parseInt( $("#week_id").val() )-1;
$("#week_id").val( week_id );
}
ajax_board_display( calendar_type='confirmation_calendar');
return false;
});
$("a#cnext_week").click(function(e){
e.preventDefault();	
var org_week_id = $.trim( $("#org_week_id").val() );
var week_id = parseInt( $("#week_id").val() )+1;
$("#week_id").val( week_id );       
ajax_board_display( calendar_type='confirmation_calendar');
return false;
});


});
