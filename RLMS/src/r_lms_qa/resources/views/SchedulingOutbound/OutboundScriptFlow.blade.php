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
	//data: {'lld_CustomerId': lld_CustomerId,'call_from': call_from,'dnis_info':dnis_info,'hd_type_id':hd_type_id,'associate_id':associate_id,'store_no':store_no,'customer_presence':customer_presence,'title':title,'first_name':first_name,'usrs_lastname':usrs_lastname,'zipcode':zipcode,'hometype_id':hometype_id,'not_owner':not_owner,'customer_mode_id':customer_mode_id,'spouse_name':spouse_name,'customer_address':customer_address,'apt_unit':apt_unit,'customer_county':customer_county,'customer_city':customer_city,'customer_state':customer_state,'customer_cross_street':customer_cross_street,'customer_territory':customer_territory,'customer_community':customer_community,'house_color':house_color,'home_phone':home_phone,'cell_phone':cell_phone,'customer_comments':customer_comments,'lcd_Address_email':lcd_Address_email,'lld_ProductCode':lld_ProductCode,'work_phone':work_phone,'get_time_dis':get_time_dis,'get_date_dis':get_date_dis,'WPTitle':WPTitle,'CPTitle':CPTitle,'territory_id':territory_id,_token: CSRF_TOKEN},
	dataType: 'html',
	data : $("#formstep").serialize(),
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
			var zipcode 		       = $.trim( $("#lcd_Zipcode").val() );
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
			$('<option></option>').val("K").html("Bath Remodeling"));
			}
			if(data.bath!="")
			{
			$("#lld_ProductCode").append(
			$('<option></option>').val("B").html("Bathroom Refacing"));
			}
			if(data.garage!="")
			{
			$("#lld_ProductCode").append(
			$('<option></option>').val("G").html("Tub-Shower Replacement"));
			}
			if(data.closet!="")
			{
			$("#lld_ProductCode").append(
			$('<option></option>').val("O").html("Walk-In Tubs"));
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
$("#nonproduct").prop( "checked", false );
$("#oot").prop( "checked", false );
$("input[name='non_product_status']").prop( "checked", false );
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
					$('#lld_ProductCode').val('');
					$("#lld_ProductCode").attr("required", false);
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
				else
				{
					$("#nonproduct").prop('checked',false);
					$('#lld_ProductCode').val('');
					$("#lld_ProductCode").attr("required", true);
					$("input[name='non_product_status']").prop( "checked", false );
					$("#non_product_container").hide();
				}	
			}
		}
		else
		{
			$('#lld_ProductCode').val('');
			$("#lld_ProductCode").attr("required", true);
			alert("Please select non product checkbox");
		}

	});
	
$("#oot").change(function(){
	
		if ($("#oot").prop('checked') == true) 
		{
			var box= confirm("Are you sure you want to do this?");
        	if (box==true)
        	{
				$('#lld_ProductCode').val('');
				$("#lld_ProductCode").attr("required", false);
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
			else
        	{
        		$("#oot").prop('checked',false);
				$('#lld_ProductCode').val('');
				$("#lld_ProductCode").attr("required", true);
			}
    	}
		else
		{
			$('#lld_ProductCode').val('');
			$("#lld_ProductCode").attr("required", true);
		}
	});	
	
	// When call this page this dynamic script will be loaded	
function ajaxcallSelectData(lm_FieldID,GET,Json,dataList,url,classAttr,nameAttr,lm_ElementValidStatus,lm_ScreenId,valueGet)
{
	var callList = "";
					if(lm_ElementValidStatus=='yes')
					var validation = 'data-parsley-group="block'+lm_ScreenId+'" required';
					else
					var validation = '';
					$.ajax({type:GET,dataType:Json,async:false,data:dataList,url:url
						 ,success:function(result)
						 {
							callList = callList+'<select name="'+nameAttr+'" '+validation+' class="'+classAttr+'"  id="'+lm_FieldID+'"><option value="">Select</option>';
								for(var i=0;i<result.length;i++)
								{
									
								  if(lm_FieldID=='lld_CallFromId')
							       {
									 if(valueGet==result[i].id)
									{
									  var valueSel = "selected";	
									}
									else
									{
									  var valueSel = "";		
									}  
									callList = callList+'<option value="'+result[i].id+'" code="'+result[i].code+'" '+valueSel+'>'+result[i].value+'</option>';
								   }
								   else
								   {
									   if(valueGet==result[i].id)
									{
									  var valueSel = "selected";	
									}
									else
									{
									  var valueSel = "";		
									}
									  callList = callList+'<option value="'+result[i].id+'" '+valueSel+'>'+result[i].value+'</option>'; 
								   }
                                }
								callList = callList+'</select>'; 
							    $("."+lm_FieldID).html(callList);
						 }
					});
				
}

function CreateFieldInfoFunc(lm_FieldID,lm_FieldClass,lm_FieldName,lm_FieldType,SreenName,lm_MasterData,lm_ElementValidStatus,lm_ScreenId)
{ 
	          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			  var AllInfo = "";
			  var callList="";
			  if(lm_ElementValidStatus=='yes')
				var validation = 'data-parsley-group="block'+lm_ScreenId+'" required';
				else
				var validation = '';
				var jQueryArray = <?php echo json_encode($customerDetails); ?>;
				if(typeof(jQueryArray[lm_FieldID]) ==="undefined" || jQueryArray[lm_FieldID] === null || jQueryArray[lm_FieldID] === "")
				{
                 var valueGet = "";
				}
				else
				{
				var valueGet = jQueryArray[lm_FieldID];
				}	
			  //alert(valueGet);				
	          if(lm_FieldType=='select')
				{
					if(lm_MasterData=='yes')
					{
						//alert(valueGet);
						data = {callFromData:lm_FieldID,DataFieldID:lm_FieldID,_token: CSRF_TOKEN};
						// ajax function call for List of all data for call from
						ajaxcallSelectData(lm_FieldID,'GET','json',data,'./ListOfAllDataSelect',lm_FieldClass,lm_FieldName,lm_ElementValidStatus,lm_ScreenId,valueGet); 
					}
					else
					{
						
						if(lm_FieldID=='lcd_Title' || lm_FieldID=='lcd_WPTitle' ||lm_FieldID=='lcd_CPTitle')
						{
							if(valueGet=='Mr' || valueGet=='Mrs')
							var valueSelected = 'selected';
						    else
							var valueSelected = '';
						var AllInfo = AllInfo+"<select class='form-control' "+validation+" name='"+lm_FieldName+"' id='"+lm_FieldID+"'><option value=''>Select</option><option  "+valueSelected+" value='Mr'>Mr</option><option value='Mrs'>Mrs</option>";
						$("."+lm_FieldID).html(AllInfo);
						}
						else
						{
							var AllInfo = AllInfo+"<select class='form-control' "+validation+" name='"+lm_FieldName+"' id='"+lm_FieldID+"'><option value=''>Select</option>";
						$("."+lm_FieldID).html(AllInfo);
						}
					}
					
				
				}
				else if(lm_FieldType=='text' || lm_FieldType=='hidden' || lm_FieldType=='checkbox' || lm_FieldType=='radio')
				{
					
					callList = callList+'<input type="'+lm_FieldType+'" name="'+lm_FieldName+'" value="'+valueGet+'" class="'+lm_FieldClass+'" '+validation+' id="'+lm_FieldID+'">'; 
					$("."+lm_FieldID).html(callList);
					
					
				}
				else if(lm_FieldType=='textarea')
				{
					var callList = '<textarea name="'+lm_FieldName+'" '+validation+' class="'+lm_FieldClass+'" id="'+lm_FieldID+'"></textarea>';
					if(lm_FieldID=='customer_comments')
					{
						$(".customer_comments").html(callList);
					}
				}
	

}

function AllSlideListInbound(typeMeth,dataType,urlPass,dataReq,SreenName)
{
	$.ajax({type:typeMeth,dataType:dataType,async:false,data:dataReq,url:urlPass,success:function(data){
      
        for(var i=0;i<data.length;i++)
        {
		  
            lm_FieldID     = data[i].lm_FieldID;
			lm_FieldClass  = data[i].lm_FieldClass;
			lm_FieldName   = data[i].lm_FieldName;
			lm_FieldType   = data[i].lm_FieldType;
			lm_MasterData  = $.trim(data[i].lm_MasterData);
			lm_ElementValidStatus   = $.trim(data[i].lm_ElementValidStatus);
			lm_ScreenId    = data[i].lm_ScreenId;
		    CreateFieldInfoFunc(lm_FieldID,lm_FieldClass,lm_FieldName,lm_FieldType,SreenName,lm_MasterData,lm_ElementValidStatus,lm_ScreenId);
          
        
	     }
	
    }
});
}

// start on dynamic script js
    function getFieldClass(GetClass)
	{
		if(($(".call_from").length)>0)
		{
			var callFrom     = $("."+GetClass).attr('class');
			//alert(callFrom);
		}
	}
    var lm_FieldID    = "";
    var lm_FieldClass = "";
    var lm_FieldName  = "";
    var lm_FieldType  = "";
	var lm_MasterData = "";
	
	//Associate Info
	var callFrom      = getFieldClass("call_from");
    var dnis_info     = getFieldClass("dnis_info");
    var hd_type_id    = getFieldClass("hd_type_id");
    var data = {screenId:'1'};
    AllSlideListInbound('GET','json','./getmanagefield',data,'AssociateInfo');
	
	// Greetings
	var title           = getFieldClass("title");
	var first_name      = getFieldClass("first_name");
	var last_name       = getFieldClass("last_name");
	var zipcode         = getFieldClass("zipcode");
		    
	var data = {screenId:'2'};
    AllSlideListInbound('GET','json','./getmanagefield',data,'Greetings');
    
	// Customer Info page left
	var lld_CallFromId           = getFieldClass("lld_CallFromId");
	var not_owner                = getFieldClass("not_owner");
	var customer_address         = getFieldClass("customer_address");
	var lcd_City                 = getFieldClass("lcd_City");
	var lcd_State                = getFieldClass("lcd_State");
	var zipcode2                 = getFieldClass("zipcode2");
	var customer_cross_street    = getFieldClass("customer_cross_street");
	
	// Customer Info page right
	
	var data = {screenId:'4'};
    AllSlideListInbound('GET','json','./getmanagefield',data,'CustomerIfo');
	
	
	// Appointment page
	var lcd_email                = getFieldClass("lcd_email");
	var data = {screenId:'5'};
    AllSlideListInbound('GET','json','./getmanagefield',data,'CustomerIfo');
	
	
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
<input type="hidden" id="get_date_dis" name="get_date_dis" value="">
<input type="hidden" id="get_time_dis" name="get_time_dis" value="">
<input type="hidden" id="lld_CustomerId" name="lld_CustomerId" value="@if(isset($customerDetails['lld_CustomerId'])){{$customerDetails['lld_CustomerId']}}@endIf">
<input type="hidden" id="territory_id" name="lmss_territory_id" value="">
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
	<h2>Associate Information </h2>
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

    {!!$ScriptAssociate!!}
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
					    <div style="float: right;position:absolute;right:20px;top:20px;">
						<select name="call_status" style="margin: -14px;" class="call_status form-control" id="call_status"  >
						<option value="">Select</option>
						@foreach($call_status as $status)
						  <option value="{{$status->lls_CallStatusId}}">{{$status->lls_CallStatus}}</option>
						@endforeach 
						</select>
				       </div>
                 </div>
                  
	  <div class="x_content">
	  
	  {!!$ScriptGreetings!!}
	 
	  
	 
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
			<select name="lld_ProductCode" id="lld_ProductCode" class="form-control" data-parsley-group="block3" required >
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
		 <br>
		 {!! $ScriptCabinet['ls_ScriptProduct'] !!}
			 
			
			</div>
			
			<div id="garbage_organization" style="display:none">
			<br>
			{!! $ScriptGarbage['ls_ScriptProduct'] !!}
			
			</div>
			<div id="closet_organization" style="display:none;">
			<br>
			 {!! $ScriptCloset['ls_ScriptProduct']!!}
			
			
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
				 <div style="float: right;position:absolute;right:20px;top:20px;">
						<select name="call_status" style="margin: -14px;" class="call_status form-control" id="call_status"   >
						<option value="">Select</option>
						@foreach($call_status as $status)
						  <option value="{{$status->lls_CallStatusId}}">{{$status->lls_CallStatus}}</option>
						@endforeach 
						</select>
				       </div>
			  </div>

			  <div class="x_content">
			 
			 {!!$ScriptCustomerInfo!!}

			  </div>
		  </div>
	  </div>
</div>
<div id="step-5">
<input type="hidden" id="week_id" name="lmss_week_id" value="{{$week_id}}">
<input type="hidden" name="org_week_id" id="org_week_id" value="{{$week_id}}" />
{!!$appointmentInfoAll!!} 
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
		 
			{!!$reviewInfoAll!!}
		  
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
  
