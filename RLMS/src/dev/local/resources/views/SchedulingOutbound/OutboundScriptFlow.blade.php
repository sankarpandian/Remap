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

jQuery("document").ready(function($){
	
	
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
			var url = 'Shedoutboundcallerscreen';
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
        //alert(stepnumber);
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
    var WPTitle               =  "";
	WPTitle                   =  $.trim( $("#lcd_WPTitle").val() );
	var CPTitle               = "";
	CPTitle                   =  $.trim( $("#lcd_CPTitle").val() );
	var territory_id          =  $("#territory_id").val();
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
	url: './updateoutbounddata',
	type: 'GET',
	data: {'lld_CustomerId': lld_CustomerId,'call_from': call_from,'dnis_info':dnis_info,'hd_type_id':hd_type_id,'associate_id':associate_id,'store_no':store_no,'customer_presence':customer_presence,'title':title,'first_name':first_name,'usrs_lastname':usrs_lastname,'zipcode':zipcode,'hometype_id':hometype_id,'not_owner':not_owner,'customer_mode_id':customer_mode_id,'spouse_name':spouse_name,'customer_address':customer_address,'apt_unit':apt_unit,'customer_county':customer_county,'customer_city':customer_city,'customer_state':customer_state,'customer_cross_street':customer_cross_street,'customer_territory':customer_territory,'customer_community':customer_community,'house_color':house_color,'home_phone':home_phone,'cell_phone':cell_phone,'customer_comments':customer_comments,'lcd_Address_email':lcd_Address_email,'lld_ProductCode':lld_ProductCode,'work_phone':work_phone,'get_time_dis':get_time_dis,'get_date_dis':get_date_dis,'WPTitle':WPTitle,'CPTitle':CPTitle,'territory_id':territory_id,_token: CSRF_TOKEN},
	dataType: 'html',
	success: function (data)
	{
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
            //alert(stepnumber);
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
            //alert(stepnumber);
			var zipcode 		       = $.trim( $("#zipcode").val() );
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
			$("#lld_ProductCode").html("");
			$("#lcd_City").html("");
			$("#lcd_County").html("");
			$("#lcd_State").html(""); 
			if(data!="")
			{
			$("#lld_ProductCode").append(
			$('<option></option>').val("").html("Select One"));
			$("#lcd_City").append(
			$('<option></option>').val("").html("Select City"));
			$("#lcd_County").append(
			$('<option></option>').val("").html("Select County"));
			$("#lcd_State").append(
			$('<option></option>').val("").html("Select State"));
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
            //alert(stepnumber);
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
            //alert(stepnumber);
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
            //alert(stepnumber);
		// Update the request id to database
		var getDate       = $("input[name='radio']:checked").attr('data-date-only');
		var dateMasterId  = $("input[name='radio']:checked").attr('data-datemasterid');
		alert(dateMasterId);
		var timeMasterId  = $("input[name='radio']:checked").attr('data-datetimeid');
		alert(timeMasterId);
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
	//return true;
	}
	else if(stepnumber ==6)
	{
		$("#formstep").parsley().validate("block6");
        if($("#formstep").parsley().isValid("block6"))
        {
           // alert(stepnumber);
            return true;
        }
        else
        {
            return false;
        }
	//return true;
	}

}

function validate_form(call_from_err_msg,display_id_call_from)
{
$("#"+display_id_call_from).html(call_from_err_msg).show();
}
$("input#first_name").keyup(function(){ 
var root = this;
$("span.first_name").html("<strong>"+$.trim( $(root).val().toUpperCase() )+"</strong>");		
});
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
function isNumberKey(evt)
{
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
{
return false;
}
return true;
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


$(".form-control").on("change",function()
{
$(".error_msg").hide();
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
var root                = $(this);
var  get_date_time      = $(this).val();
var date_get            = $(this).attr("data-date");
var date_get_full       = $(this).attr("data-date-only");
var day_only            = $(this).attr("data-date");
var time_get            = $(this).attr("data-time");
var month_name_get      = $(this).attr("data-month-name");
$("#get_time_dis").val(time_get);
$("#get_date_dis").val(date_get_full);
$("#appointment_date_time").val(get_date_time+', '+month_name_get+' '+day_only+'@'+time_get);
$("#display_scheduled_time").html(get_date_time+', '+month_name_get+' '+day_only+'@'+time_get);
$(".selected_date_time").on("click",function(){
root.attr('checked', true);
});

});

//previous week script






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
							var url = 'Shedoutboundcallerscreen';
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
						var url = 'Shedoutboundcallerscreen';
						window.location.href = url;
					}

				}
				});

        	}
        	
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

</style> 
<?php 
  $media_arr    = str_split(trim($customerDetails['lld_ProsepctId']), 3); //personsecondphone
  $media    = $media_arr[0];
  $media    = trim( str_replace(range(0,9),"",$media) );
  $prospect_id        = $media;
 
 ?>
<form data-parsley-validate  class="form" id="formstep" action="OutboundUpdateInfo"  method="POST">
<meta name="csrf-token" content="{{ csrf_token() }}"  />	
<input type="hidden" id="get_date_dis" value="">
<input type="hidden" id="get_time_dis" value="">
<input type="hidden" id="lld_CustomerId" name="lld_CustomerId" value="@if(isset($customerDetails['lld_CustomerId'])){{$customerDetails['lld_CustomerId']}}@endIf">
<input type="hidden" id="territory_id" value="">
<input type="hidden" id="requestId" name="requestId" value="{{$requestId}}">
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
	<input type="hidden" name="prospect_id" id="prospect_id" value=""  />
	<p>Thank you for calling The Home Depot Installed Services. My name is Christudasan.</p>
	  <div class="form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name">May I ask how you heard about us?<span class="required">*</span>
		</label>
		<div class="col-md-5 col-sm-5 col-xs-12">                         
		<select class="form-control" name="call_from" id="call_from" data-parsley-group="block1" required>
			<option value="">Choose option</option>
			@for($i=0;$i<count($CallerScreenRepository_data);$i++)
			<option value="{{$CallerScreenRepository_data[$i]['lcf_CallFromId']}}" code="{{$CallerScreenRepository_data[$i]['lcf_CallFromCode']}}" @if($customerDetails['lld_CallFromId']==$CallerScreenRepository_data[$i]['lcf_CallFromId']){{"selected"}} @endIf>{{$CallerScreenRepository_data[$i]['lcf_CallFromName']}}
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
			  <option value="{{$lms_hdtypes_data[$j]['lht_HdTypeId']}}" @if($customerDetails['lld_CallTypeId']==$lms_hdtypes_data[$j]['lht_HdTypeId']) {{"selected"}} @endIf>{{$lms_hdtypes_data[$j]['lht_HdType']}}</option>
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
		<p>
		  Please put the customer on the phone so I can schedule an appointment with them.
		</p>
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
	  
	<p><label class="control-label col-md-8 col-sm-3 col-xs-12" for="first-name"> 
     Good (Morning/Afternoon/Evening)</label>
		</p>
		
	
	  </div> 
      <div class="form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Title<span class="required">*</span>
		</label>
		<div class="col-md-5 col-sm-5 col-xs-12">                         
		<select class="form-control" id="title" name="title" data-parsley-group="block2" required>
			<option value="">Select One</option>
			<option value="mr" @if($customerDetails['lcd_Title']=='mr') {{"selected"}} @else {{" "}} @endIf>Mr.</option>
			<option value="mrs" @if($customerDetails['lcd_Title']=='mrs') {{"selected"}} @else {{" "}} @endIf>Mrs.</option>
	    </select>
		</div>
	 </div>	 

     <div class="form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> First Name <span class="required">*</span>
		</label>
		<div class="col-md-5 col-sm-5 col-xs-12">                         
		<input type="text" id="first_name" name="usrs_firstname"  class="form-control col-md-7 col-xs-12" value="{{$customerDetails['lcd_FirstName']}}" data-parsley-group="block2" required>
		</div>
	 </div>	

     <div class="form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Last Name <span class="required">*</span>
		</label>
		<div class="col-md-5 col-sm-5 col-xs-12">                         
		<input type="text" id="last_name" name="usrs_lastname"  class="form-control col-md-7 col-xs-12" value="{{$customerDetails['lcd_LastName']}}" data-parsley-group="block2" required>
		</div>
	 </div>	
	 
	 <div class="form-group">
		<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> Just to verify, I have your zip code as <span class="required">*</span>
		</label>
		<div class="col-md-5 col-sm-5 col-xs-12">                         
		<input type="text" id="zipcode" name="zipcode"  class="form-control col-md-7 col-xs-12" value="@if(isset($customerDetails['lcd_Zipcode'])){{$customerDetails['lcd_Zipcode']}}@else{{" "}}@endIf" data-parsley-group="block2" required data-parsley-type="digits" data-parsley-length="[5, 5]" data-parsley-length-message ="Please fill 5 digit Zipcode">Is that correct?
		</div>
	 </div>
	</div> 		
  </div> 
 </div> 
<div id="step-3">
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
			<label class="control-label col-md-12 col-sm-3 col-xs-12" for="first-name"> 
What I would like to do is arrange a time to provide you with a free in-home consultation.  </label>
			</div>
		  <div class="form-group">
			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> But first, are you familiar with our  <span class="required">*</span>
			</label>
			<div class="col-md-5 col-sm-5 col-xs-12">                         
			<select name="lld_ProductCode" id="lld_ProductCode" class="form-control" data-parsley-group="block3" >
			</select>
			</div>
		 </div>
		 
		 <div class="form-group">
			<label class="control-label col-md-4 col-sm-3 col-xs-12" for="first-name"> <input type="checkbox" name="product_mode" id="nonproduct" value="10" data-parsley-group="block3"> Non Product 
			</label>
			<div class="col-md-5 col-sm-5 col-xs-12">                         
			<input type="checkbox" name="product_mode" id="oot" value="11"> OOT / Service Not Available in <span class="zipcode">30123</span>
			</div>
		 </div>
		 
		 <div class="form-group" style="margin:80px 30px;">
		  <div id="cabinet_refacing" style="display:none">
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> What I would like to do is arrange a time to provide you with a free in-home consultation. But first, are you familiar with Garage Organization?
			</label>
			<br>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> Our Garage Organization System is comprised of a high quality Slat Wall Panel System that is attached to your existing walls. The systems versatility allows you to move shelving, baskets, hooks and cabinets to meet your ever changing needs.
			</label>
			<br>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> We offer five accessory packages with numerous colors and trim combinations. When our design consultant comes to your home he or she will show you how to professionally organize your garage.<br>What are you trying to accomplish with a Garage Organization System? More storage space, less clutter or just get the cars back in the garage?
			</label>
			<br>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name" style="align:center"> ***Wait For Response***
			</label>
			</div>
			
			<div id="garbage_organization" style="display:none">
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> What I would like to do is arrange a time to provide you with a free in-home consultation. But first, are you familiar with Garage Organization?
			</label>
			<br>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> Our Garage Organization System is comprised of a high quality Slat Wall Panel System that is attached to your existing walls. The systems versatility allows you to move shelving, baskets, hooks and cabinets to meet your ever changing needs.
			</label>
			<br>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> We offer five accessory packages with numerous colors and trim combinations. When our design consultant comes to your home he or she will show you how to professionally organize your garage.
			</label>
			
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> What are you trying to accomplish with a Garage Organization System? More storage space, less clutter or just get the cars back in the garage?
			</label>
			
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> ***Wait For Response***
			</label>
			</div>
			<div id="closet_organization" style="display:none;">
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> What I would like to do is arrange a time to provide you with a free in-home consultation. But first, are you familiar with Home Organization products?
			</label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> Our custom home organization system includes closets, pantries, and utility rooms. We offer a complete line of drawer units, shelving, shoe racks and many other accessories. Our design consultant will come to your home, review your needs and provide you with an exact cost to complete your project.
			</label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> Is it important to note that we do not offer wire shelving.
			</label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> What are you trying to accomplish with a Closet Organization System - more storage space, less clutter or better organized?
			</label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> ***Wait For Response***
			</label>
			
			</div>
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

 <div id="step-4">
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
			<select id="lld_CallFromId" name="lld_CallFromId" class="form-control" data-parsley-group="block4" required>
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
			<input type="checkbox" name="not_owner" id="not_owner" value="9" data-parsley-group="block4"/> Not Owner
		</div>
	</div>
	
	<div class="form-group">
	<p><label class="control-label col-md-12 col-sm-9 col-xs-12" for="first-name">Is there a co-owner or spouse who jointly owns the property with you?</label></p>
	
		
	</div>
<div class="form-group">
	<div class="col-md-9 col-sm-9 col-xs-12">
	<div class="radio">
	<label>
	<input type="radio" class="flat" name="customer_mode_id" value="1" id="customer_mode_id" data-parsley-group="block4" required> Spouse/Co-Owner 
	</label>
	<input type="text" class="form-control" name="spouse_name" id="spouse_name"placeholder="Spouse/Co-Owner">
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
		<input type="text" class="form-control" name="customer_address" id="customer_address" placeholder="Address" value="@if(isset($customerDetails['lcd_Address'])){{$customerDetails['lcd_Address']}}@else{{""}}@endIf" data-parsley-group="block4" required>
	</div>
</div>

<div class="form-group" style="display: none;">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Apt / Unit #<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="apt_unit" id="apt_unit" size="30" value="" data-parsley-group="block4"/>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">City<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<select class="form-control"  name="lcd_City" id="lcd_City" data-parsley-group="block4" required> 
		<option value="">Select City</option>
        </select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">State<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<select class="form-control" name="lcd_State" id="lcd_State" data-parsley-group="block4" required>
		<option>Select State</option>					
	    </select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">And you said the zip code was*<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="zipcode" id="zipcode1" placeholder="zipcode1" data-parsley-group="block4" required data-parsley-type="digits" data-parsley-length="[5, 5]" data-parsley-length-message ="Please fill 5 digit Zipcode">correct? Ok, Great
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">And what is the nearest cross street to help us find the home? </label>
</div> 

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cross Street<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="customer_cross_street" id="customer_cross_street" placeholder="Cross Street" value="@if(isset($customerDetails['lcd_CrossStreet'])){{$customerDetails['lcd_CrossStreet']}} @else {{""}} @endIf" data-parsley-group="block4" required> correct? Ok, Great
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
		<input type="text" class="form-control" name="customer_community" id="customer_community" placeholder="Community Name" value="@if(isset($customerDetails['lcd_Community'])){{$customerDetails['lcd_Community']}} @else {{""}} @endIf" data-parsley-group="block4" required>
	</div>
</div>	

<div class="form-group">
<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">May I please have the outside color of your property to help us identify your home? </label>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">House Color<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="house_color" id="house_color" placeholder="House Color" value="@if(isset($customerDetails['lcd_HousecColor'])){{$customerDetails['lcd_HousecColor']}} @else {{""}} @endIf" data-parsley-group="block4" required>
	</div>
</div>

<div class="form-group">
<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">Ok, great. And what is your Home Phone Number? </label>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Home Phone<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="home_phone" id="home_phone" placeholder="Home Phone" value="@if(isset($customerDetails['lcd_HomePhone'])){{$customerDetails['lcd_HomePhone']}} @else {{""}} @endIf" data-parsley-group="block4" required>
	</div>
</div>

<div class="form-group">
<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">Is there an alternate or cell phone number available? </label>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Work Phone<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="work_phone" id="work_phone" placeholder="Work Phone" value="@if(isset($customerDetails['lcd_WorkPhone'])){{$customerDetails['lcd_WorkPhone']}} @else {{""}} @endIf" data-parsley-group="block4">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">WP Title<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<select name="lcd_WPTitle" id="lcd_WPTitle" class="form-control col-md-10" style="float: left;" data-parsley-group="block4" required>
			<option value="">Select One</option>
			<option value="mr" @if($customerDetails['lcd_WPTitle']="mr"){{"selected"}} @else {{""}} @endIf>Mr.</option>
			<option value="mrs" @if($customerDetails['lcd_WPTitle']="mrs"){{"selected"}} @else {{""}} @endIf>Mrs.</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cell Phone<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="cell_phone" id="cell_phone" placeholder="Cell Phone" value="@if(isset($customerDetails['lcd_CellPhone'])){{$customerDetails['lcd_CellPhone']}} @else {{""}} @endIf" data-parsley-group="block4">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">CP Title<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<select name="lcd_CPTitle" id="lcd_CPTitle" class="form-control col-md-10" style="float: left;" data-parsley-group="block4" required>
			<option value="">Select One</option>
			<option value="mr" @if($customerDetails['lcd_CPTitle']="mr"){{"selected"}} @else {{""}} @endIf>Mr.</option>
			<option value="mrs" @if($customerDetails['lcd_CPTitle']="mrs"){{"selected"}} @else {{""}} @endIf>Mrs.</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Additional Comments:<span class="required">*</span>
	</label>
	<div class="col-md-9 col-sm-9 col-xs-12">                         
		<input type="text" class="form-control" name="customer_comments" id="customer_comments" placeholder="Additional Comments" value="@if(isset($customerDetails['lcd_Comments'])){{$customerDetails['lcd_Comments']}} @else {{""}} @endIf" data-parsley-group="block4">
	</div>
</div>

  </div>
</div>
			  






			  </div>
		  </div>
	  </div>
  </div>
<div id="step-5">
	 
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
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name"> What time do you normally get home from work?</label>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">  We normally allow 2 hours for the consultation; will this time interfere with any other plans you may have?</label>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name"> Ok, great. I have you scheduled for : </label>
			<div class="col-md-9 col-sm-9 col-xs-12">                         
		     <div id="display_scheduled_time"></div>
	        </div>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">For a free in-home consultation on Cabinet Refacing. </label>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">  Do you have an email address that we can send an appointment reminder and introduction video to? </label>
			</div>
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name">   Do you have an email address that we can send an appointment reminder and introduction video to?  </label>
			</div>
			
			<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email Address<span class="required">*</span>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">                         
			<input type="email" class="form-control" name="lcd_Address" id="lcd_Address" placeholder="Email Address" value="@if(isset($customerDetails['lcd_EmailAddress'])){{$customerDetails['lcd_EmailAddress']}} @else {{""}} @endIf" data-parsley-group="block5" >
			</div>
			</div>
			
			<div class="form-group">
			<label class="control-label col-md-10 col-sm-3 col-xs-12" for="first-name"> Ok, great. Now I'd just like to review all of your information to ensure we have it correct. </label>
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
		<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Scheduling</a>
		</li>
		<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Callback</a>
		</li>
		
	  </ul>
	   <input type="hidden" class="schedule_confirm_value" name="schedule_confirm_value" id="schedule_confirm_value" value="2">
	  <div id="myTabContent" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
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
		<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
		  callback
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
              We will be calling you within 48 hours of your appointment to confirm.
            </label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
              Please write down our toll free phone number in the event that you need to reach us: 1-866-646-0656.
            </label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
              Please make a note of this appointment on your calendar, we'll be making a special trip to see you.
            </label>
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
              Thank you again for your interest in The Home Depot Home Services. It's been a pleasure speaking with you today.
            </label>
			
			<label class="control-label col-md-9 col-sm-3 col-xs-12" for="first-name"> 
              Verification Code : LL00seryAT
            </label>
		  
		</div>
		</div>
     </div>
</div>

 </div>
                    <!-- End SmartWizard Content -->
	
</form>
                 
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
  
