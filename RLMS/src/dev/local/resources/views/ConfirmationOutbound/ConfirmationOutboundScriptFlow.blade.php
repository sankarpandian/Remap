@extends('layouts.master')

@section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/caller_screen_js/caller_screen.js') }}"></script>
<!-- For calendar display -->
<script src="{{ URL::asset('assets/js/CalendarDisplay/CalendarDisplayFunc.js') }}"></script>
<!--Check Duplicate Phone  -->
<script src="{{ URL::asset('assets/js/Comon/phoneDuplicate.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/mask/jquery.maskedinput.min.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/fancybox/source/jquery.fancybox.css')}}" type="text/css" media="screen" />
<!-- jQuery Tags Input -->
    <!-- jQuery Tags Input -->
<script>
function onAddTag(tag) {
alert("Added a tag: " + tag);
}

function onRemoveTag(tag) {
alert("Removed a tag: " + tag);
}

function onChangeTag(input, tag) {
alert("Changed a tag: " + tag);
}

$("document").ready(function($){
var lld_CustomerId=$('#lld_CustomerId').val();
$('.call_status').change(function()
{
	var alert_confirm = confirm('Are you sure want to leave the screen');
	var call_statusid = $(this).val();
	var CSRF_TOKEN    = $('meta[name="csrf-token"]').attr('content');
	if (alert_confirm == true) {
	$.ajax({
		type: "POST",
		url: "./quickresult_result",
		data: {"call_statusid" : call_statusid,'lld_CustomerId': lld_CustomerId,_token: CSRF_TOKEN},
		dataType: "html",
		async:false,
		success: function(data)
		{
			if(data=='success')
			{
			var url = 'Confirmoutboundcallerscreen';
			window.location.href = url;
			}
		}
	});
	
	} 
	else
	{
	return false;
	}
});
	
	
	$('#home_phone').mask('(999) 999-9999');
    $('#work_phone').mask('(999) 999-9999');
    $('#cell_phone').mask('(999) 999-9999');
jQuery('.fancybox-media').fancybox({
openEffect  : 'none',
closeEffect : 'none',
helpers : {
media : {}
}
});
$('.form').parsley();
jQuery('#wizard').smartWizard({
onLeaveStep:leaveAStepCallback,
onFinish:onFinishCallback
});


function leaveAStepCallback(obj, context){
	if (context.fromStep > context.toStep) 
	{
	// Going backward
	return true;
	} 
	else 
	{
	// Going forward
	return validateSteps(context.fromStep); // return false to stay on step and true to continue navigation 
	}
}

function onFinishCallback(objs, context){
	$("#formstep").parsley().validate();
    if($("#formstep").parsley().isValid())
    {
       validateAllSteps();
        return true;
    }
    else
    {
        return false;
    }
	/*if(validateAllSteps()){

	}*/
}
function validateAllSteps()
	{
	//slide 1
	var call_from    = "";
	var dnis_info    = "";
	var hd_type_id   = "";
	var associate_id = "";
	var store_no     = "";
	var customer_presence="";

	call_from 		       = $.trim( $("#call_from").val() );
	dnis_info              = $.trim( $("#dnis_info").val() );
	hd_type_id             = $.trim( $("#hd_type_id").val() );
	associate_id           = $.trim( $("#associate_id").val() );
	store_no               = $.trim( $("#store_no").val() );
	//customer_presence       = $('.customer_presence:selected').val();
	customer_presence       =1;
	//slide 2

	var title              = "";
	var first_name         = "";
	var usrs_lastname      = "";
	var zipcode            = "";

	title 		           = $.trim( $("#title").val() );
	first_name 		       = $.trim( $("#first_name").val() );
	usrs_lastname 		   = $.trim( $("#last_name").val() );
	zipcode 		       = $.trim( $("#zipcode").val() );

	//slide 4

	var hometype_id           = "";
	var not_owner             = "";
	var spouse_name           = "";
	var customer_address      = "";
	var customer_county       = "";
	var customer_city         = "";
	var customer_cross_street = "";
	var customer_community    = "";
	var house_color           = "";
	var home_phone            = "";
	var cell_phone            = "";
	var customer_comments     = "";
	var customer_state        = "";
	var apt_unit              = "";
	var customer_territory    = 1;
	var lld_ProductCode       = "";


	//slide 5

	var get_time_dis          = "";
	var get_date_dis          = "";
	var lld_CustomerId        = "";
	get_time_dis              = $.trim( $("#get_time_dis").val() );
	get_date_dis              = $("#get_date_dis").val();
    lld_CustomerId            = $("#lld_CustomerId").val();
	hometype_id 		      = $.trim( $("#hometype_id").val() );
	not_owner 		          = $.trim( $("#not_owner").val() );
	spouse_name 		      = $.trim( $("#spouse_name").val() );
	customer_address 		  = $.trim( $("#customer_address").val() );
	customer_county 		  = $.trim( $("#lcd_County").val() );
	customer_city 		      = $.trim( $("#lcd_City").val() );
	customer_state            = $.trim( $("#lcd_State").val() );
	customer_cross_street 	  = $.trim( $("#customer_cross_street").val() );
	customer_community 		  = $.trim( $("#customer_community").val() );
	house_color 		      = $.trim( $("#house_color").val() );
	home_phone 		          = $.trim( $("#home_phone").val() );
	cell_phone 		          = $.trim( $("#cell_phone").val() );
	customer_comments 		  = $.trim( $("#customer_comments").val() );
	customer_mode_id          = $('.flat:selected').val();
	apt_unit                  = $.trim( $("#apt_unit").val() );
	lcd_Address_email         = $.trim( $("#lcd_Address").val() );    
	work_phone                = $.trim( $("#work_phone").val() ); 
	lld_ProductCode           = $.trim( $("#lld_ProductCode").val() );
//alert(lld_ProductCode)	;
    var WPTitle               =  "";
	WPTitle                   =  $.trim( $("#lcd_WPTitle").val() );
	var CPTitle               =  "";
	CPTitle                   =  $.trim( $("#lcd_CPTitle").val() );
	var schedule_confirm_value=  $(".schedule_confirm_value").val();  
	var CSRF_TOKEN            =  $('meta[name="csrf-token"]').attr('content');
	var territory_id          =  $("#territory_id").val();
	var selectedScheduleConfirm = $("#selectedScheduleConfirm").val();
	$.ajax({
	url: './updateconfimoutbounddata',
	type: 'GET',
	data: {'lld_CustomerId': lld_CustomerId,'call_from': call_from,'dnis_info':dnis_info,'hd_type_id':hd_type_id,'associate_id':associate_id,'store_no':store_no,'customer_presence':customer_presence,'title':title,'first_name':first_name,'usrs_lastname':usrs_lastname,'zipcode':zipcode,'hometype_id':hometype_id,'not_owner':not_owner,'customer_mode_id':customer_mode_id,'spouse_name':spouse_name,'customer_address':customer_address,'apt_unit':apt_unit,'customer_county':customer_county,'customer_city':customer_city,'customer_state':customer_state,'customer_cross_street':customer_cross_street,'customer_territory':customer_territory,'customer_community':customer_community,'house_color':house_color,'home_phone':home_phone,'cell_phone':cell_phone,'customer_comments':customer_comments,'lcd_Address_email':lcd_Address_email,'lld_ProductCode':lld_ProductCode,'work_phone':work_phone,'get_time_dis':get_time_dis,'get_date_dis':get_date_dis,'WPTitle':WPTitle,'CPTitle':CPTitle,'schedule_confirm_value':schedule_confirm_value,'territory_id':territory_id,'selectedScheduleConfirm':selectedScheduleConfirm,_token: CSRF_TOKEN},
	dataType: 'html',
	success: function (data) {
	if(data=='success')
	{
	var url = 'gridview';
	window.location.href = url;
	}
	}
	});
}
// Your Step validation logic
function validateSteps(stepnumber)
	{
	//var isStepValid = true;
	if(stepnumber == 1)
	{
		
		$("#formstep").parsley().validate("block1");
        if($("#formstep").parsley().isValid("block1"))
        {
           // alert(stepnumber);
            return true;
        }
        else
        {
            return false;
        }

	
	}
	else if(stepnumber ==2)
	{
		$("#formstep").parsley().validate("block2");
        if($("#formstep").parsley().isValid("block2"))
        {
           // alert(stepnumber);
    var zipcode    = $.trim( $("#zipcode").val() );
	if(zipcode!="")
	{
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
	type: "GET",
	url: "./ajax_zipcode",
	data: {"lcd_Zipcode" : zipcode,_token: CSRF_TOKEN},
	dataType: "json",
	beforeSend: function(){
	$("span.product_list_container").html("Please wait...");
	},
	success: function(data){
	$.each(data['territory_id'], function(index, element) {
		     $("#territory_id").val(element.lb_TerritoryId);
			});	
	$("#lcd_City").html("");
	$("#lcd_County").html("");
	$("#lcd_State").html(""); 
	if(data!="")
	{
	$("#lcd_City").append(
	$('<option></option>').val("").html("Select City"));
	$("#lcd_County").append(
	$('<option></option>').val("").html("Select County"));
	$("#lcd_State").append(
	$('<option></option>').val("").html("Select State"));
	
	$.each(data['city'], function(index, element) {
	//var value= element.mdnis_CompanyCode+element.mdnis_ProspectId;

	$("#lcd_City").append(
	$('<option></option>').val(element.mrcs_City).html(element.mrcs_City));
	});

	$.each(data['county'], function(index, element) {
	//var value= element.mdnis_CompanyCode+element.mdnis_ProspectId;

	$("#lcd_County").append(
	$('<option></option>').val(element.mrcs_County).html(element.mrcs_County));
	});

	$.each(data['state'], function(index, element) {
	//var value= element.mdnis_CompanyCode+element.mdnis_ProspectId;

	$("#lcd_State").append(
	$('<option></option>').val(element.mrcs_State).html(element.mrcs_State));
	});
	}
   }	
	});
  }
            return true;
        }
        else
        {
            return false;
        }
	
	}
	else if(stepnumber ==3)
	{
		$("#formstep").parsley().validate("block3");
        if($("#formstep").parsley().isValid("block3"))
        {
           // alert(stepnumber);
		
		var getDate       = $("input[name='radio']:checked").attr('data-date-only');
		var dateMasterId  = $("input[name='radio']:checked").attr('data-datemasterid');
		var timeMasterId  = $("input[name='radio']:checked").attr('data-datetimeid');
		var zipcode       = $("#zipcode").val();
		var timezone      = 'EST';
		var companyId     = 1;
		var conformlead   = 'yes';
		var CustomerId    = $("#lld_CustomerId").val();
		var dateTimestamp = $.now();
		var requestId     = $("#requestId").val();
		var slot_id       = $("#lmss_slot_id").val();
		var territory_id  = $("#lmss_territory_id").val();
		var week_id       = $("#lmss_week_id").val();
		var schedule_confirm_value = $("#schedule_confirm_value").val();
		
		var dataSend      = {'currDate':getDate,'zipcode':zipcode,'timezone':timezone,'companyId':companyId,'conformlead':conformlead,'requestId':requestId,'territory_id':territory_id,'slot_id':slot_id,'week_id':week_id,'dateMasterId':dateMasterId,'timeMasterId':timeMasterId,"schedule_confirm_value":schedule_confirm_value}
		$.ajax({
			url :'lockTimeSlot',
			type:'GET',
			dataType:'HTML',
			data:dataSend,
			success:function(result)
			{
				//alert(result);
			}
		});
        return true;
        }
        else
        {
            return false;
        }
	
	}
	else if(stepnumber ==4)
	{

		$("#formstep").parsley().validate("block4");
        if($("#formstep").parsley().isValid("block4"))
        {
          return true;
        }
        else
        {
            return false;
        }
	
	}
	else if(stepnumber ==5)
	{
		$("#formstep").parsley().validate("block5");
        if($("#formstep").parsley().isValid("block5"))
        {
			return true;
        }
        else
        {
            return false;
        }
		
	var scheduleConfirmValue = $("#schedule_confirm_value").val();
	return false;
	}
	else if(stepnumber ==6)
	{
		$("#formstep").parsley().validate("block6");
        if($("#formstep").parsley().isValid("block6"))
        {
          
            return true;
        }
        else
        {
            return false;
        }

	}

}

function store_number_valid(store_no)
{
//alert('test');
store_result = '0';
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
if(store_no != '')
{
$.ajax({
type: "POST",
url: "./call_from_ajax",
data: {"ajax_mode": "validate_storeno", "store_no" : store_no,_token: CSRF_TOKEN},
dataType: "html",
async:false,
success: function(data)
{
// alert(data);
if(data == 'failure')
{
store_result = '1';
}
}
});
return store_result;
}
}

$("input:radio[name='customer_mode_id']").change(function(){
var root = this;
var value = $.trim( $(root).val() );
if(parseInt(value) == 1 )
{
//Case - spouse selected
$("input#spouse_name").attr("disabled", false);
}
else
{
//Case - other than spouse selected
$("input#spouse_name").attr("disabled", true);
$("input#spouse_name").val("");
}

});

$("input:checkbox[name='not_owner']").change(function(){
var hometype_id = $.trim( $("select#hometype_id").val() ); 

$("tr.condo_townhouse_container").hide();		
if( $(this).is(":checked") )
{
$("select#hometype_id").val('');
$("div.customer_detail_container").fadeOut("slow");		
}
else
{
$("div.customer_detail_container").fadeIn("slow");		
}
});

//Script to change customer present / not present
$("input:radio[name='customer_present']").change(function(){
var value	= "";
$("input:radio[name='customer_present']").each(function(){
if( $(this).is(":checked") )
{
value = $(this).val();
}
});		
if( parseInt(value) == 1)
{
//Case - if customer radio is checked
$("div#customer_present_container").show();			
}
else
{
//Case - if customer radio is not checked
$("div#customer_present_container").hide();
}
});



$("select#hometype_id").on("change",function(){
var hometype_id = $.trim( $(this).val() ); 
$("input:checkbox[name='not_owner']").prop("checked", false);

if( parseInt(hometype_id) == 5 )
{
$("div.customer_detail_container").fadeOut("slow");
}
else
{
$("div.customer_detail_container").fadeIn("slow");		
$("div#condo_townhouse_container").hide();		
if( hometype_id == "3" || hometype_id == "4" || hometype_id == "7" )
{
$("div#condo_townhouse_container").fadeIn("slow");		
}
}

});	



//Script to hide customer details when mobile home and not owner is selected

$(document).on("click",".get_date_time",function(){
var root           = $(this);
var  get_date_time = $(this).val();
var date_get       = $(this).attr("data-date-only");
var date           = $(this).attr("data-date");
var time_get       = $(this).attr("data-time");
var month_name_get = $(this).attr("data-month-name");
$("#get_time_dis").val(time_get);
$("#get_date_dis").val(date_get);
$("#appointment_date_time").val(get_date_time+', '+month_name_get+' '+date+'@'+time_get);
$("#display_scheduled_time").html(get_date_time+', '+month_name_get+' '+date+'@'+time_get);
$(".selected_date_time").on("click",function(){
root.attr('checked', true);
var scheduleConfirm = $("#scheduleConfirm").val();
$("#selectedScheduleConfirm").val(scheduleConfirm);
});

});





$("#lld_ProductCode").on("change",function(){
var product_code_get = $(this).val();
if(product_code_get=='K')
{
$("#cabinet_refacing").show();
$("#garbage_organization").hide();
$("#closet_organization").hide();
}
else if(product_code_get=='G')
{
$("#garbage_organization").show();
$("#cabinet_refacing").hide();
$("#closet_organization").hide();
}
else if(product_code_get=='O')
{
$("#closet_organization").show();
$("#garbage_organization").hide();
$("#cabinet_refacing").hide();
}
$( "#nonproduct" ).prop( "checked", false );
$("#non_product_container").hide();
});
$(".scheduling").on("click",function(){
	$(".schedule_confirm_value").val(2);
	//var test =  $(".schedule_confirm_value").val();
	
});
$(".confirmation").on("click",function(){
   $(".schedule_confirm_value").val(34);	
   //var test =  $(".schedule_confirm_value").val();
	
});
$(document).on("blur","#zipcode",function(){
	//alert('test');
	var zipcode = $("#zipcode").val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
	type: "GET",
	url: "./ajax_zipcode",
	data: {"lcd_Zipcode" : zipcode,_token: CSRF_TOKEN},
	dataType: "json",
	beforeSend: function(){
	$("span.product_list_container").html("Please wait...");
	},
	success: function(data){
    $("#lld_ProductCode").html("");
	$("#lcd_City").html("");
	$("#lcd_County").html("");
	$("#lcd_State").html(""); 
	if(data!="")
	{
	$("#lld_ProductCode").html("");
		if(data!="")
		{
		$("#lld_ProductCode").append(
		$('<option></option>').val("").html("Select One"));
		if(data.kitchen!="")
		{
		$("#lld_ProductCode").append(
		$('<option></option>').val("K").html("Cabinet Refacing"));
		}
		if(data.bath!="")    
		{
		$("#lld_ProductCode").append(
		$('<option></option>').val("B").html("Bathroom Refacing"));
		}
		if(data.garage!="")
		{
		$("#lld_ProductCode").append(
		$('<option></option>').val("G").html("Garage Organization Systems"));
		}
		if(data.closet!="")
		{
		$("#lld_ProductCode").append(
		$('<option></option>').val("O").html("Closet Organization Systems"));
		}
		}
		
	}
 }
});
});
$("#oot").change(function(){
	
		if ($("#oot").prop('checked') == true) 
		{

			var box= confirm("Are you sure you want to do this?");
        	if (box==true)
        	{
        		var oot = $("#oot").val();
        		//alert(lld_CustomerId);
        		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
				type: "GET",
				url: "./ajax_oot",
				data: {"oot" : oot,'lld_CustomerId': lld_CustomerId,_token: CSRF_TOKEN},
				dataType: "json",
				success: function(data){
					if(data=="success")
					{
						var url = 'Confirmoutboundcallerscreen';
						window.location.href = url;
					}

				}
				});

        	}
        	else
        	{
        		//alert("no");
        	}
    	}
	});

$("input[name='non_product_status']").change(function(){

	if ($("#nonproduct").prop('checked') == true) 
		{
			if($("input[name='non_product_status']").is(':checked')) 
			{
				var box= confirm("Are you sure you want to do this?");
	        	if (box==true)
	        	{
	        		var nonproduct = $("#nonproduct").val();
	        		var non_product_status = $("input[name='non_product_status']:checked").val();
	        		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
					$.ajax({
					type: "GET",
					url: "./ajax_non_product",
					data: {"non_product_status" : non_product_status,"nonproduct" : nonproduct,'lld_CustomerId': lld_CustomerId,_token: CSRF_TOKEN},
					dataType: "json",
					success: function(data){
						if(data=="success")
						{
							var url = 'Confirmoutboundcallerscreen';
							window.location.href = url;
						}

					}
					});

	        	}
				
			}
		}
		else
		{
			alert("Please select non product checkbox");
		}

	});
});
    </script>
    <!-- /jQuery Tags Input -->    
  
<style>

.form-control
{
margin: 5px;
}
.wizard_horizontal ul.wizard_steps
{
	margin: 0px -25px 10px;
}
.wizard_horizontal ul.wizard_steps li a .step_no
{
	    width: 28px;
    height: 28px;
    line-height: 29px;
    border-radius: 100px;
    display: block;
    margin: 0 auto 5px;
    font-size: 12px;
    text-align: center;
    z-index: 5; 	
}
.wizard_horizontal ul.wizard_steps li a:before
{
	top:14px !important;
}
.x_panel
{
	padding:8px 3px !important; 
}
label
{
	margin-top:15px;
}
</style> 

<?php 
  $media_arr    = str_split(trim($ConfirmCustomerDetails['lld_ProsepctId']), 3); //personsecondphone
  $media    = $media_arr[0];
  $media    = trim( str_replace(range(0,9),"",$media) );
  $prospect_id        = $media;
  
 ?>
<form data-parsley-validate  class="form" id="formstep">
<meta name="csrf-token" content="{{ csrf_token() }}"  />
<input type="hidden" id="get_date_dis" value="">
<input type="hidden" id="get_time_dis" value="">	
<input type="hidden" id="territory_id" value="">
<input type="hidden" id="scheduleConfirm" value="">
<input type="hidden" id="selectedScheduleConfirm" value="">
<input type="hidden" id="requestId" name="requestId" value="{{$requestId}}"> 
<input type="hidden" id="lld_CustomerId" name="lld_CustomerId" value="{{$ConfirmCustomerDetails['lld_CustomerId']}}">   

				    <!-- Smart Wizard -->
                   
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">
                        
                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                           
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            
                          </a>
                        </li>
						<li>
                          <a href="#step-4">
                            <span class="step_no">4</span>
                           
                          </a>
                        </li>
						<li>
                          <a href="#step-5">
                            <span class="step_no">5</span>
                            
                          </a>
                        </li>
						<li>
                          <a href="#step-6">
                            <span class="step_no">6</span>
                           
                          </a>
                        </li>
                      </ul>
            
    <div id="step-1">
	 
	<div class="col-md-12 col-sm-12 col-xs-12">
	   <div class="x_panel">	       
	<div class="x_title">
				<h2>Associative Information </h2>
				<div class="clearfix"></div>
				<div style="float: right;position:absolute;right:11px;top:1px;">
					<select name="call_status" class="call_status form-control" id="call_status"  data-parsley-group="block1" >
					<option value="">Select</option>
					@foreach($call_status as $status)
		              <option value="{{$status->lls_CallStatusId}}">{{$status->lls_CallStatus}}</option>
		            @endforeach 
					</select>
				</div>
	</div>
	<div class="x_content">
	<input type="hidden" name="prospect_id" id="prospect_id" value="@if(isset($ConfirmCustomerDetails['lld_ProsepctId'])) {{$ConfirmCustomerDetails['lld_ProsepctId']}} @endIf"  />
	<p>Thank you for calling The Home Depot Installed Services. My name is Christudasan.</p>
	  <div class="form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">May I ask how you heard about us?<span class="required">*</span>
		</label>
		<div class="col-md-5 col-sm-5 col-xs-12">                         
		<select class="form-control" name="call_from" id="call_from" data-parsley-group="block1" required>
			<option value="">Choose option</option>
			@for($i=0;$i<count($CallerScreenRepository_data);$i++)
			<option value="{{$CallerScreenRepository_data[$i]['lcf_CallFromId']}}" code="{{$CallerScreenRepository_data[$i]['lcf_CallFromCode']}}" @if($ConfirmCustomerDetails['lld_CallFromId']==$CallerScreenRepository_data[$i]['lcf_CallFromId']){{"selected='selected'"}} @endIf">{{$CallerScreenRepository_data[$i]['lcf_CallFromName']}}
			</option>
			@endfor
		</select>
		</div>
	  </div>
		
		<div class="form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Please select the description<span class="required">*</span>
		</label>
		<div class="col-md-5 col-sm-5 col-xs-12">                         
			<select  name="call_desc_container" class="call_desc_container form-control" id="dnis_info" data-parsley-group="block1" required>
			<option>Select</option>
			@for($j=0;$j<count($lms_call_desc_data);$j++)
			<option value="{{$lms_call_desc_data[$j]['mrd_CompanyCode']}}{{$lms_call_desc_data[$j]['mrd_ProspectId']}}" @if($prospect_id==$lms_call_desc_data[$j]['mrd_CompanyCode'].$lms_call_desc_data[$j]['mrd_ProspectId']) {{'selected'}} @endIf>{{$lms_call_desc_data[$j]['mrd_Description']}}</option>
			@endFor
			</select>
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Just to confirm, I am speaking with a Home Depot<span class="required">*</span>
		</label>
		<div class="col-md-5 col-sm-5 col-xs-12">                         
		<select class="form-control" 	name="hd_type_id " id="hd_type_id" data-parsley-group="block1" required>
		  <option value="">Select One</option>
		  @for($j=0;$j<count($lms_hdtypes_data);$j++)
			  <option value="{{$lms_hdtypes_data[$j]['lht_HdTypeId']}}" @if($ConfirmCustomerDetails['lld_CallTypeId']==$lms_hdtypes_data[$j]['lht_HdTypeId']) {{"selected"}} @endIf>{{$lms_hdtypes_data[$j]['lht_HdType']}}</option>
		  @endfor
		</select>
		</div>
		</div>
		
		<p>
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">  Ok, great. And how are you doing today? Great.</span>
		</p>
		
		</div>
		
		<div name="associate_info_container" class="associate_info_container" id="associate_info_container" style="display: none;" >
		<div class="form-group">
			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Can I please have your Associate ID?<span class="required">*</span>
			</label>
			<div class="col-md-5 col-sm-5 col-xs-12">                         
			<input type="text" name="associate_id" id="associate_id" value="" size="5" maxlength="7" class="form-control col-md-7 col-xs-12" data-parsley-group="block1" />
					  <span id="span_associate_name" style="font-weight:bold;color:#F30;"></span>Ok, great.
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">And can I please have the Store # you are calling from?<span class="required">*</span>
			</label>
			<div class="col-md-5 col-sm-5 col-xs-12">                         
			<input type="text" name="store_no" id="store_no" size="3" maxlength="4" onkeypress="return isNumberKey(event)" onblur="return fillStoreNo(this.value);"  class="other_store_id form-control col-md-7 col-xs-12" data-parsley-group="block1" />
					  <span id="span_associate_name" style="font-weight:bold;color:#F30;"></span>Ok, great.
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">And are you presently with the customer?&nbsp;<span class="required">*</span>
			</label>
			<div class="col-md-5 col-sm-5 col-xs-12">                         
			<input type="radio" name="customer_presence" class="customer_presence" value="1" data-parsley-group="block1"/>
			  Yes&nbsp;
			  <input type="radio" name="customer_presence" class="customer_presence"  value="0" />
			  No
					  <span id="span_associate_name" style="font-weight:bold;color:#F30;"></span>Ok, great.
			</div>
		</div>
		<div class="form-group">
		 <div class="col-md-12 col-sm-5 col-xs-12">   
		  Please put the customer on the phone so I can schedule an appointment with them.
		</div>
		</div>
	    </div>  
	   </div>		
	</div>			  
 </div>	        
         <div id="step-2">
		  <div class="col-md-12 col-sm-12 col-xs-12">
             <div class="x_panel">
                <div class="x_title">
                    <h2>Greetings </h2>
                       <div class="clearfix"></div>
						<div style="float: right;position:absolute;right:11px;top:1px;">
						<select name="call_status" class="call_status form-control" id="call_status"  data-parsley-group="block1" >
						<option value="">Select</option>
						@foreach($call_status as $status)
						<option value="{{$status->lls_CallStatusId}}">{{$status->lls_CallStatus}}</option>
						@endforeach 
						</select>
						</div>
                 </div>
                  
	  <div class="x_content">
	  
	
		
		
	   
      <div class="form-group">
		<label class="control-label col-md-1" for="first-name"> Hello
		</label>
		<div class="col-md-3 col-sm-3 col-xs-12">                         
		<select class="form-control" id="title" name="title" data-parsley-group="block2" required>
			<option value="mr" @if((isset($ConfirmCustomerDetails['lcd_Title']) && $ConfirmCustomerDetails['lcd_Title']=='mr')) {{"selected"}} @else {{" "}} @endIf>Mr.</option>
			<option value="mrs" @if((isset($ConfirmCustomerDetails['lcd_Title']) && $ConfirmCustomerDetails['lcd_Title']=='mrs')) {{"selected"}} @else {{" "}} @endIf>Mrs.</option>
	    </select>
		</div>
		<div class="col-md-3">                         
		<input type="text" id="first_name" name="usrs_firstname" required class="form-control col-md-7 col-xs-12" value="{{$ConfirmCustomerDetails['lcd_FirstName']}}" data-parsley-group="block2">
		</div>
		<div class="col-md-3">                         
		<input type="text" id="last_name" name="usrs_lastname" required class="form-control col-md-7 col-xs-12" value="{{$ConfirmCustomerDetails['lcd_LastName']}}" data-parsley-group="block2">
		</div>
	 </div>	 

     <div class="form-group">
		<label class="control-label col-md-12" for="first-name"> This is sankar pandian from Home Depot Home Services. 
		</label>	
	</div>	
	
	<div class="form-group">
		<label class="control-label col-md-9" for="first-name"> I'm calling to confirm our appointment with you for June 30 at 11:00 AM.	
		</label>
       
		
		
	</div>
	
          
    <div class="form-group">
	<label class="control-label col-md-12" for="first-name"> Is this still a convenient time for the both of you?
	</label>	
		
	 </div>	
	 
	 <div class="form-group">
		<label class="control-label col-md-3" for="first-name"> Ok great. And I have your zip code as</label>
		<div class="col-md-3">                         
		<input type="text" id="zipcode" name="zipcode" required class="form-control col-md-3" value="@if(isset($ConfirmCustomerDetails['lcd_Zipcode'])){{$ConfirmCustomerDetails['lcd_Zipcode']}}@else {{" "}} @endIf" data-parsley-group="block2" data-parsley-type="digits" data-parsley-length="[5, 5]" data-parsley-length-message ="Please fill 5 digit Zipcode">
		</div><label class="control-label col-md-2" for="first-name">and I have product as</label>
		<div class="col-md-3">                         
			<select name="lld_ProductCode" id="lld_ProductCode" class="form-control" >
			<option value="K" @if((isset($ConfirmCustomerDetails['lld_ProductCode']) && $ConfirmCustomerDetails['lld_ProductCode']=='K')) {{"selected"}} @else {{" "}} @endIf>Cabinet Refacing</option>
			<option value="B" @if((isset($ConfirmCustomerDetails['lld_ProductCode']) && $ConfirmCustomerDetails['lld_ProductCode']=='B')) {{"selected"}} @else {{" "}} @endIf>Bathroom Refacing</option>
			<option value="G" @if((isset($ConfirmCustomerDetails['lld_ProductCode']) && $ConfirmCustomerDetails['lld_ProductCode']=='G')) {{"selected"}} @else {{" "}} @endIf>Garage Organization Systems</option>
			<option value="O" @if((isset($ConfirmCustomerDetails['lld_ProductCode']) && $ConfirmCustomerDetails['lld_ProductCode']=='O')) {{"selected"}} @else {{" "}} @endIf>Closet Organization Systems</option>	
				
			</select>
		</div>
		
		
	 </div>
	</div> 		
  </div> 
 </div> 
 </div>
 
<div id="step-3">
	 
	<div class="col-md-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
			<h2>Appointments </h2>
			<div class="clearfix"></div>
			
			</div>
			<div class="x_content">
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name"> What I would like to do is schedule a time to visit your home that is convenient for you.</label>
			</div>
			
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">  What time do you normally get home from work?</label>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">  We normally allow 2 hours for the consultation; will this time interfere with any other plans you may have?</label>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">  Ok, great. I have you scheduled for :</label>
			<div class="col-md-9 col-sm-9 col-xs-12">                         
		     <div id="display_scheduled_time"></div>
	        </div>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">  For a free in-home consultation on Garage Refacing. </label>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">  Now I'd just like to review all of your information to ensure we have it correct.
            </label>
			</div>
			
			
			</div>
		</div>
	</div>
<div class="col-md-6 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
		<h2>Appointment Calendar </h2>
		<div class="clearfix"></div>
		<div style="float: right;position:absolute;right:11px;top:1px;">
					<select name="call_status" class="call_status form-control" id="call_status"  data-parsley-group="block1" >
					<option value="">Select</option>
					@foreach($call_status as $status)
		              <option value="{{$status->lls_CallStatusId}}">{{$status->lls_CallStatus}}</option>
		            @endforeach 
					</select>
				</div>
		</div>
		<div class="x_content">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
	  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
		<li role="presentation" class=""><a href="#tab_content1" id="SchedulingCalen" role="tab" data-toggle="tab" aria-expanded="true" class="scheduling">Scheduling</a>
		</li>
		<li role="presentation" class="active"><a href="#tab_content2" role="tab" id="ConfirmCalen" data-toggle="tab" aria-expanded="false" class="confirmation">Confirmation</a>
		</li>
		
	  </ul>
	  <input type="hidden" class="schedule_confirm_value" name="schedule_confirm_value" id="schedule_confirm_value" value="34">
	  <div id="myTabContent" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="SchedulingCalen">
		<div>
		<div  style="width:60%;float:left; text-align:center;">
		<!--<h3 style="margin:0px; ">Appointment Availability  |  Territory: </h3>-->
		</div>
		<div class="navigation" style="width:100%;float:left; text-align:right;"> 
		<a href="" name="previous_week" id="previous_week" style="color:#F60; font-weight:bold;">Previous Week</a>
		&nbsp;|&nbsp;
		<a href="" name="next_week" id="next_week" style="color:#F60; font-weight:bold;">Next Week</a>
		</div>
		</div>
		<input type="hidden" id="week_id" name="lmss_week_id" value="{{$week_id}}"><input type="hidden" name="org_week_id" id="org_week_id" value="{{$week_id}}" />
		 <div id="display_calendar_id"></div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="ConfirmCalen">
		<div>
		<div  style="width:60%;float:left; text-align:center;">
		<!--<h3 style="margin:0px; ">Appointment Availability  |  Territory: </h3>-->
		</div>
		<div class="navigation" style="width:100%;float:left; text-align:right;"> 
		<a href="" name="cprevious_week" id="cprevious_week" style="color:#F60; font-weight:bold;">Previous Week</a>
		&nbsp;|&nbsp;
		<a href="" name="cnext_week" id="cnext_week" style="color:#F60; font-weight:bold;">Next Week</a>
		</div>
		</div>
		  <div id="confirm_display_calendar_id"></div>
		</div>
		
	  </div>
	 
		</div>
		</div>

	</div>
</div>
</div>
 
<div id="step-4">
  <div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
	<h2>Products </h2>

	<div class="clearfix"></div>
	<div style="float: right;position:absolute;right:11px;top:1px;">
					<select name="call_status" class="call_status form-control" id="call_status"  data-parsley-group="block1" >
					<option value="">Select</option>
					@foreach($call_status as $status)
		              <option value="{{$status->lls_CallStatusId}}">{{$status->lls_CallStatus}}</option>
		            @endforeach 
					</select>
				</div>
	</div>

	  <div class="x_content">
		  		 
		 <div class="form-group">
			<label class="control-label col-md-12" for="first-name"> 
			<input type="checkbox" name="product_mode" id="nonproduct" value="10" data-parsley-group="block4" > Non Product 
			
			                     
			<input type="checkbox" name="product_mode" id="oot" value="11" data-parsley-group="block4"> OOT / Service Not Available in <span class="zipcode">30123</span>
			
			</label>
		 </div>
		<div class="form-group">
		<label class="control-label col-md-12" for="first-name"> Mr./Mrs. {{$ConfirmCustomerDetails['lcd_FirstName']}} {{$ConfirmCustomerDetails['lcd_LastName']}}, 
		</label>	
	    </div>	
		
		<div class="form-group">
		<label class="control-label col-md-12" for="first-name"> We will be showing you our acrylic liner that covers your existing tub and the three (3) walls surrounding it.  
		</label>	
	    </div>
		
		<div class="form-group">
		<label class="control-label col-md-12" for="first-name"> Is this what you were interested in seeing? Is this a rectangular shaped tub? Is it porcelain, cast iron or fiberglass? Does your tub have three walls surrounding it?   
		</label>	
	    </div>
		
		<div class="form-group">
		<label class="control-label col-md-12" for="first-name"> Is your tub a Jacuzzi, garden or roman tub? In addition to a tub liner system what other improvements are you considering for your bathroom?   
		</label>	
	    </div>
		
		<div class="form-group">
		<label class="control-label col-md-12" for="first-name"> Great, Mr./Mrs. JESSICA JOYNER I will make a note of that for your consultant.   
		</label>	
	    </div>
		
		<div class="form-group"  id="non_product_container" style="display:none">
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name">{{$product_exist=""}}
							
							 	@foreach ($listNonProduct->chunk(10) as $chunk)
							 	
								 <div class="row" style="float:left">
								 	
								 @foreach ($chunk as $product)
								 
								     @if($product_exist!=$product->lp_ProductName)
									 {{$product_exist=$product->lp_ProductName}}
									 @endif
								 
								 <br>
								 
								 <input type="radio" name="non_product_status" id="non_product_status" value="{{$product->lnp_NonProductId}}"  />{{$product->lnp_NonProductStatus}}
								  
								  <br>

								  @endforeach
								  
								 </div>
								 
							 @endforeach
							
			</label>
		 </div>
		 
		  
		 
		 </div>
	  </div>
		</div>
	</div>

 <div id="step-5">
	 <div class="col-md-12 col-sm-12 col-xs-12">
		  <div class="x_panel">
			  <div class="x_title">
				<h2>Customer Information </h2>
				
				<div class="clearfix"></div>
				<div style="float: right;position:absolute;right:11px;top:1px;">
					<select name="call_status" class="call_status form-control" id="call_status"  data-parsley-group="block1" >
					<option value="">Select</option>
					@foreach($call_status as $status)
		              <option value="{{$status->lls_CallStatusId}}">{{$status->lls_CallStatus}}</option>
		            @endforeach 
					</select>
				</div>
			  </div>

			  <div class="x_content">
			 
<div class="col-md-6 col-xs-12">
	<div class="x_panel">
		
	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Is this a <span class="required">*</span>
	</label>
		<div class="col-md-9 col-sm-6 col-xs-12">                         
			<select id="lld_CallFromId" name="lld_CallFromId" class="form-control" required  data-parsley-group="block5">
			<option code="" value="">Select One</option>				
			@for($k=0;$k<count($lms_customerhometypes);$k++)
			<option value="{{$lms_customerhometypes[$k]['lch_HomeTypeId']}}" selected="selected">{{$lms_customerhometypes[$k]['lch_HomeTypeName']}}</option>
			@endfor
			</select>
		</div>
	</div> 
	
	<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">that You Own?<span class="required">*</span>
	</label>
		<div class="col-md-9 col-sm-9 col-xs-12">                         
			<input type="checkbox" name="not_owner" id="not_owner" value="9" data-parsley-group="block5"/> Not Owner
		</div>
	</div>
	
	<div class="form-group">
	<p><label class="control-label col-md-9 col-sm-9 col-xs-12" for="first-name">Is there a co-owner or spouse who jointly owns the property with you?</label></p>
	
		
	</div>
<div class="form-group">
	<div class="col-md-9 col-sm-9 col-xs-12">
	<div class="radio">
	<label>
	<input type="radio" class="flat" name="customer_mode_id" value="1" id="customer_mode_id" data-parsley-group="block5" required> Spouse/Co-Owner 
	</label>
	<input type="text" class="form-control" name="spouse_name" id="spouse_name"placeholder="Spouse/Co-Owner" data-parsley-group="block5">
	</div>
	<div class="radio">
	<label>
	<input type="radio" class="flat" name="customer_mode_id"  value="2">  Sole Owner
	</label>
	</div>
	<div class="radio">
	<label>
	<input type="radio" class="flat" name="customer_mode_id"  value="3"> 1-Leg
	</label>
	</div>
	</div>
</div>
<div class="form-group">
	<p><label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">Ok, great. May I please have the street address of the property?</label> 
	</p>
</div> 

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="customer_address" id="customer_address" placeholder="Address"  required value="@if(isset($ConfirmCustomerDetails['lcd_Address'])){{$ConfirmCustomerDetails['lcd_Address']}} @else {{""}} @endIf" data-parsley-group="block5">
	</div>
</div>

<div class="form-group" style="display: none;">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Apt / Unit #<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="apt_unit" id="apt_unit" size="30" value="" data-parsley-group="block5"/>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">City<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<select class="form-control"  name="lcd_City" id="lcd_City" data-parsley-group="block5" required> 
		<option value="">Select City</option>
        </select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">State<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<select class="form-control" name="lcd_State" id="lcd_State" data-parsley-group="block5" required>
		<option>Select State</option>					
	    </select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">And you said the zip code was*<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="zipcode" id="zipcode1" placeholder="zipcode1" data-parsley-group="block5" data-parsley-type="digits" data-parsley-length="[5, 5]" data-parsley-length-message ="Please fill 5 digit Zipcode">correct? Ok, Great
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">And what is the nearest cross street to help us find the home? </label>
</div> 

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cross Street<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="customer_cross_street" id="customer_cross_street" required placeholder="Cross Street" value="@if(isset($ConfirmCustomerDetails['lcd_CrossStreet'])){{$ConfirmCustomerDetails['lcd_CrossStreet']}} @else {{""}} @endIf" data-parsley-group="block5"> correct? Ok, Great
	</div>
</div>



</div>
</div>

			 
<div class="col-md-6 col-xs-12">
 <div class="x_panel">
  
 
<div class="form-group">
<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">And is it located in a Community or Development ? </label>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Community Name<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="customer_community" id="customer_community" required placeholder="Community Name" value="@if(isset($ConfirmCustomerDetails['lcd_Community'])){{$ConfirmCustomerDetails['lcd_Community']}} @else {{""}} @endIf" data-parsley-group="block5">
	</div>
</div>	

<div class="form-group">
<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">May I please have the outside color of your property to help us identify your home? </label>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">House Color<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="house_color" id="house_color" placeholder="House Color"  required value="@if(isset($ConfirmCustomerDetails['lcd_HousecColor'])){{$ConfirmCustomerDetails['lcd_HousecColor']}} @else {{""}} @endIf" data-parsley-group="block5">
	</div>
</div>

<div class="form-group">
<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">Ok, great. And what is your Home Phone Number? </label>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Home Phone<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="home_phone" id="home_phone" required placeholder="Home Phone" value="@if(isset($ConfirmCustomerDetails['lcd_HomePhone'])){{$ConfirmCustomerDetails['lcd_HomePhone']}} @else {{""}} @endIf" data-parsley-group="block5">
	</div>
</div>

<div class="form-group">
<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">Is there an alternate or cell phone number available? </label>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Work Phone<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="work_phone" id="work_phone" placeholder="Work Phone" value="@if(isset($ConfirmCustomerDetails['lcd_WorkPhone'])){{$ConfirmCustomerDetails['lcd_WorkPhone']}} @else {{""}} @endIf" data-parsley-group="block5">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">WP Title<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<select name="lcd_WPTitle" id="lcd_WPTitle" class="form-control col-md-10" style="float: left;" data-parsley-group="block5" required>
			<option value="">Select One</option>
			<option value="mr" @if($ConfirmCustomerDetails['lcd_WPTitle']="mr"){{"selected"}} @else {{""}} @endIf>Mr.</option>
			<option value="mrs" @if($ConfirmCustomerDetails['lcd_WPTitle']="mrs"){{"selected"}} @else {{""}} @endIf>Mrs.</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cell Phone<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="cell_phone" id="cell_phone" placeholder="Cell Phone" value="@if(isset($ConfirmCustomerDetails['lcd_CellPhone'])){{$ConfirmCustomerDetails['lcd_CellPhone']}} @else {{""}} @endIf" data-parsley-group="block5">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">CP Title<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<select name="lcd_CPTitle" id="	" class="form-control col-md-10" style="float: left;" data-parsley-group="block5" required>
			<option value="">Select One</option>
			<option value="mr" @if($ConfirmCustomerDetails['lcd_CPTitle']="mr"){{"selected"}} @else {{""}} @endIf>Mr.</option>
			<option value="mrs" @if($ConfirmCustomerDetails['lcd_CPTitle']="mrs"){{"selected"}} @else {{""}} @endIf>Mrs.</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Additional Comments:<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="customer_comments" id="customer_comments" placeholder="Additional Comments" value="@if(isset($ConfirmCustomerDetails['lcd_Comments'])){{$ConfirmCustomerDetails['lcd_Comments']}} @else {{""}} @endIf" data-parsley-group="block5">
	</div>
</div>

  </div>
</div>
			  






			  </div>
		  </div>
	  </div>
  </div>

<div id="step-6">
<div class="col-md-12 col-sm-12 col-xs-12">
	 <div class="x_panel">	       
		<div class="x_title">
					<h2>Review </h2>
					<div class="clearfix"></div>
		</div>
		<div class="x_content">
		  <div class="form-group" style="margin:40px 30px;">
		 
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
              Mr TEST,
			</label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
              We have you scheduled for Wednesday, 09/21/2016 at 11:00 AM for Closet Organization Systems, correct?
            </label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
              I have your address as TEST, Cassville, GA 30123, correct?
            </label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
              And the phone number I have for you is (978) 978-9790.
            </label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
             Please write down our toll free phone number in the event that you need to reach us: 1-866-646-0656.
            </label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
             Thank you again for your interest in The Home Depot Home Services. It's been a pleasure speaking with you today.
			Please mark this on your calendar as we will be making a special trip to see you and KYLE. 
			Thank you and have a WONDERFUL DAY!!
            </label>
			
		  
		</div>
		</div>
     </div>
</div>

 </div>
</form>
                    <!-- End SmartWizard Content -->
	

                 
<form >
		
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Appointment Date/Time</h4>
                        </div>
                        <div class="modal-body">
						<div id="display_prove_success"></div>
                         <p>Please confirm the appointment date and time</p>
                         
						<p><input type="text" id="appointment_date_time" name="appointment_date_time" class="form-control"></P>  
						 
						  
						  
                        </div>
                        <div class="modal-footer">
                          
                         <button type="button" class="btn btn-success selected_date_time" name="selected_date_time" id="selected_date_time" data-dismiss="modal">Ok</button>
						 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						
                        </div>

                      </div>
                    </div>
                  </div>
				  
			</form>		  
                 @endsection		  
  
