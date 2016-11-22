 @extends('layouts.master')
 @section('content')
  
  <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>
  
  <script src="{{ URL::asset('assets/datePicker/jquery-1.12.4.js') }}"></script>
  <script src="{{ URL::asset('assets/datePicker/1.12.0/jquery-ui.js')}}"></script>
  <link rel="stylesheet" href="{{ URL::asset('assets/datePicker/jquery-ui.css') }}" type="text/css" media="screen" />

<script type="text/javascript" src="{{ URL::asset('vendors/mask/jquery.maskedinput.min.js') }}"></script>
  <script>
  jQuery(document).ready(function($){ 
    $('#lcd_HomePhone').mask('(999) 999-9999');
    $('#lcd_WorkPhone').mask('(999) 999-9999');
    $('#lcd_CellPhone').mask('(999) 999-9999');
  
    //$("#lcd_CoownerName").hide();
   /* $("#OwnerType1").click (function () {
      $("#lcd_CoownerName").html("");
        document.getElementById('lcd_CoownerName').style.display = 'block';
    });
    $("#OwnerType2").click (function () {
      $("#lcd_CoownerName").html("");
        document.getElementById('lcd_CoownerName').style.display = 'none';
    });
    $("#OwnerType3").click (function () {
      $("#lcd_CoownerName").html("");
        document.getElementById('lcd_CoownerName').style.display = 'none';
    });*/
    $('#datepicker1').datepicker({
      //minDate: new Date(),
    inline : true,
    altField : '#appointment_date',
    altFormat: "yy-mm-dd",
    onSelect: function (date) {
         var appointment_date = $('#appointment_date').val();
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 var lcd_Zipcode = $("#lcd_Zipcode").val();
        alert(lcd_Zipcode);
        //var url="/dataentry_cusdetails";
        //alert("helloee");
     $.ajax({
     type: "GET",
     url: "./ajax_appointment_date",
    
     data:{"date":appointment_date,'zipcode':lcd_Zipcode,_token:CSRF_TOKEN},
     dataType: "json",
     success: function(data){ 
      //alert("hhh");
      //alert(data);
      //alert(element.lmst_time_master);
      $(appointment_time).html("");
              
              if(data!="")
              {
                $("#appointment_time").append(
                   $('<option></option>').val("").html("Select One"));
               
            $.each(data, function(index, element) {
            
            $("#appointment_time").append(
                   $('<option></option>').val(element.lt_TimeMaster).html(element.lt_TimeMaster));
            });
          }
          else
          {
            
            $("#appointment_time").append(
                   $('<option></option>').val("").html('No free slots'));

          }
   }
   
  // 
   });
    }
  });

 $('#appointment_time').change(function() {

var appointment_date = document.getElementById('appointment_date').value;
var appointment_time = document.getElementById('appointment_time').value;
var datestring=appointment_date+" "+appointment_time;

var org=new Date(datestring);
var add=new Date(datestring);
var sub=new Date(datestring);
//add.toLocaleString();

var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
var day=days[org.getDay()];
var monthname = ["January","February","March","April","May","June","July","August","September","October","November","December"];
var month=monthname[org.getMonth()];
var date=org.getDate();

var org_hours = org.getHours();
var org_minutes = org.getMinutes();
var org_ampm = org_hours >= 12 ? 'PM' : 'AM';
org_hours = org_hours % 12;
org_hours = org_hours ? org_hours : 12; // the hour '0' should be '12'
org_minutes = org_minutes < 10 ? '0'+org_minutes : org_minutes;
var org_datetime=day+", "+month+" "+date+" @ "+org_hours + ':' + org_minutes + ' ' + org_ampm;

add.setTime(add.getTime() + (30 * 60 * 1000));
var add_hours = add.getHours();
var add_minutes = add.getMinutes();
var add_ampm = add_hours >= 12 ? 'PM' : 'AM';
add_hours = add_hours % 12;
add_hours = add_hours ? add_hours : 12; // the hour '0' should be '12'
add_minutes = add_minutes < 10 ? '0'+add_minutes : add_minutes;
var add_datetime=day+", "+month+" "+date+" @ "+add_hours + ':' + add_minutes + ' ' + add_ampm;

sub.setTime(sub.getTime() - (30 * 60 * 1000));
var sub_hours = sub.getHours();
var sub_minutes = sub.getMinutes();
var sub_ampm = sub_hours >= 12 ? 'PM' : 'AM';
sub_hours = sub_hours % 12;
sub_hours = sub_hours ? sub_hours : 12; // the hour '0' should be '12'
sub_minutes = sub_minutes < 10 ? '0'+sub_minutes : sub_minutes;
var sub_datetime=day+", "+month+" "+date+" @ "+sub_hours + ':' + sub_minutes + ' ' + sub_ampm;
 
//var sub=formatDate('l, F d, Y @ h:i A', new Date(datestring));

$(appointment_datetime).html("");
$("#appointment_datetime").append($('<option></option>').val(org_datetime).html(org_datetime));
$("#appointment_datetime").append($('<option></option>').val(add_datetime).html(add_datetime));
$("#appointment_datetime").append($('<option></option>').val(sub_datetime).html(sub_datetime));
 });

 $('#lcd_Zipcode').change(function() {

var lcd_Zipcode = document.getElementById('lcd_Zipcode').value;
var half_id = document.getElementById('half_id').value;

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//alert(lld_CallFromId);
$.ajax({
     type: "GET",
     url: "./ajax_zipcode",
    
     data:{"lcd_Zipcode":lcd_Zipcode,_token:CSRF_TOKEN},
     dataType: "json",
     success: function(data){ 
	
      $("#lld_ProsepctId").html("");
      $("#ProsepctId").html("");
      $("#territory_code").val(data.territory_code[0].lb_TerritoryName);
	  $("#territory_id").val(data.territory_id[0].lb_TerritoryId);
      var territory_code = document.getElementById('territory_code').value;
      $("#lld_ProsepctId").val(half_id + territory_code);
      $("#ProsepctId").text(half_id + territory_code);
      
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
   
  // 
   });

});
 $('#lld_ProductCode').change(function() {

var lld_ProductCode = document.getElementById('lld_ProductCode').value;
var half_id = document.getElementById('half_id').value;
var territory_code = document.getElementById('territory_code').value;
$("#lld_ProsepctId").val(half_id + territory_code + lld_ProductCode);
$("#ProsepctId").text(half_id + territory_code + lld_ProductCode);
});

 $("input[name=lcd_OwnerTypeId]").on('click', function() {
      var CoownerName = $('#CoownerName');
      //alert("checked");
      // if is company
      if ($(this).val() == 1) {
        // show panel
        $('#lcd_CoownerName').val('');
       // CoownerName.show();
        document.getElementById('CoownerName').style.display = 'block';

        // remove disabled prop
        CoownerName.find('input,select,radio').prop('disabled', false);
      } 
      else {
        $('#lcd_CoownerName').val('');
        document.getElementById('CoownerName').style.display = 'none';
       // alert("else checked");
        // if is not company, hide the panel and add disabled prop
        //CoownerName.hide();
        CoownerName.find('input,select,radio').prop('disabled', true);
      }
    });
 $('#confirm_lead').change(function(){
  $('#conf_number').val('');
    if($(this).is(":checked"))
    {
      
      $('#conf').fadeIn('fast');
    }
    
    else
    {
      //$('#conf_number').val('');
      $('#conf').fadeOut('fast');
    }
    

    });
 $('#appointment_date_na').change(function(){
  $('#appointment_date').val('');
  $('#appointment_time').val('');
  $('#appointment_datetime').val('');
  $('#confirm_lead').val('');
 // $.datepicker._clearDate('datepicker1');
  $('#datepicker1').datepicker('setDate', null);
    if($(this).is(":checked"))
    {
      
      $('#date_na1').fadeOut('fast');
      $('#date_na2').fadeOut('fast');
    }
    
    else
    {
      //$('#conf_number').val('');
      $('#date_na1').fadeIn('fast');
      $('#date_na2').fadeIn('fast');
    }
    

    });
 
 /*$("#confirm_lead").click (function () {
      $("#conf_number").html("");
        document.getElementById('conf').style.display = 'block';
    });
$('#form').parsley({
      excluded: 'input[type=text], input[type=submit], input[type=reset], input[type=hidden], :disabled'
    });
$('#form').submit(function(e) {
      // validate form
      $('#form').parsley().validate();

      // if is valid submit form
      if ($("#form").parsley().isValid()) {
        return true;
      }
      e.preventDefault();
    });*/

  });
  </script>
	<div class="row">
              <div class="clearfix"></div>
  {!! Form::open(['url' => '/dataentry_cusdetails1', 'method' => 'post', 'role' => 'form', 'class'=>'form-horizontal form-label-left', 'data-parsley-validate']) !!}   
<input type="hidden" id="lld_CallFromId" name="lld_CallFromId" value="@if(isset($lld_CallFromId)){{$lld_CallFromId}}@endIf" >
<input type="hidden" id="lld_calldescription" name="lld_calldescription" value="@if(isset($lld_calldescription)){{$lld_calldescription}}@endIf" >
<input type="hidden" id="lld_AssociateId" name="lld_AssociateId" value="@if(isset($lld_AssociateId)){{$lld_AssociateId}}@endIf" >
<input type="hidden" id="lld_StoreId" name="lld_StoreId" value="@if(isset($lld_StoreId)){{$lld_StoreId}}@endIf" >
<input type="hidden" id="lld_ProsepctId" name="lld_ProsepctId" >
<input type="hidden" id="half_id" name="half_id" value="@if(isset($calldescription)){{$calldescription}}@endIf" >
<input type="hidden" id="territory_code" name="territory_code" >
<input type="hidden" id="territory_id" name="territory_id" > 
<!--<form class="form-horizontal form-label-left input_mask" method="POST" action="dataentry_cusdetails1">-->
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Basic Details <!-- <small>different form elements</small>--></h2>
                   <!-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> -->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    
                    
                    
                      <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">First Name</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" class="form-control" id="lcd_FirstName" name="lcd_FirstName" placeholder="First Name" required  data-parsley-required-message="Please insert your name">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" class="form-control" id="lcd_LastName" name="lcd_LastName" placeholder="Last Name" required data-parsley-pattern="^[A-Za-z]+((\s)?((\')?([A-Za-z])+))*$" data-parsley-pattern-message="Please fill a Valid Name" data-parsley-required-message="Please fill your Last Name" >
						</div>
					</div>

                     <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="email" class="form-control" id="lcd_EmailAddress" name="lcd_EmailAddress" placeholder="Email" data-parsley-type-message="Please fill a Valid Email">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Home Phone</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" id="lcd_HomePhone" name="lcd_HomePhone" required data-parsley-required-message="Please fill Phone Number" >
						</div>
					</div>

                     

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" id="lcd_Zipcode" name="lcd_Zipcode"  placeholder="Zipcode" required data-parsley-type="digits" data-parsley-length="[5, 5]" data-parsley-length-message ="Please fill 5 digit Zipcode" data-parsley-required-message="Please fill Zipcode">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select name="lld_ProductCode" id="lld_ProductCode" class="form-control" required data-parsley-required-message="Please select Product" >
                            
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Prospect ID</label>
                        <div class="col-md-9 col-sm-9 col-xs-12" >
                         <label id="ProsepctId">{{$calldescription}}</label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">House Type</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<select id="lcd_HomeTypeId" name="lcd_HomeTypeId" class="form-control" required data-parsley-required-message="Please select House Type">
						<option value="">Select One</option>
						@foreach($hometypes as $hometype)
              <option value="{{$hometype->lch_HomeTypeId}}">{{$hometype->lch_HomeTypeName}}</option>
            @endforeach 
						</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Co-Owner 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="radio">
                            <label>
                              <input type="radio" class="flat" name="lcd_OwnerTypeId" id="OwnerType1" value="1" required data-parsley-required-message="Please select Owner Type"> Spouse/Co-Owner 
                            </label>
                            <div id="CoownerName" style="display: none;">
							<input type="text" class="form-control" name="lcd_CoownerName" id="lcd_CoownerName"placeholder="Spouse/Co-Owner"  data-parsley-required-message="Please fill Co-Owner Name" >
                         </div>
                          </div>
						  <div class="radio">
                            <label>
                              <input type="radio" class="flat" name="lcd_OwnerTypeId"  id="OwnerType2" value="2">  Sole Owner
                            </label>
                          </div>
						  <div class="radio">
                            <label>
                              <input type="radio" class="flat" name="lcd_OwnerTypeId"  id="OwnerType3" value="3"> 1-Leg
                            </label>
                          </div>
						  
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="lcd_Address" id="lcd_Address" placeholder="Address" required data-parsley-required-message="Please fill Address">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control"  name="lcd_City" id="lcd_City" required data-parsley-required-message="Please select City" > 
							              <option value="">Select City</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">County</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="lcd_County" id="lcd_County" required data-parsley-required-message="Please select County">                                                 
                          <option value="">Select County</option></select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="lcd_State" id="lcd_State" required data-parsley-required-message="Please select State">
                            <option>Select State</option>					
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cross Street</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control"  name="lcd_CrossStreet" id="lcd_CrossStreet" value=""  placeholder="Cross Street">
                        </div>
                      </div>

                    
                  </div>
                </div>

              </div>

              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Additional Details<!-- <small>different form elements</small> --></h2>
                   <!-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> -->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left">

                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Comm. Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text"  name="lcd_Community" id="lcd_Community" class="form-control col-md-10" style="float: left;" placeholder="Community Name"/>
                      </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">House Color</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="text"  name="lcd_HousecColor" id="lcd_HousecColor" class="form-control col-md-10" style="float: left;" placeholder="House Color"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Work phone</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="lcd_WorkPhone" id="lcd_WorkPhone" class="form-control col-md-10" style="float: left;" placeholder="Work phone"/>
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">WP Title</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">   
                        <select name="lcd_WPTitle" id="lcd_WPTitle" class="form-control col-md-10" style="float: left;">
                          <option value="">Select One</option>
                          <option value="mr">Mr.</option>
                          <option value="mrs">Mrs.</option>
                        </select>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cell phone</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="lcd_CellPhone" id="lcd_CellPhone" class="form-control col-md-10" style="float: left;" placeholder="Cell phone" />
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CP Title</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">   
                        <select name="lcd_CPTitle" id="lcd_CPTitle" class="form-control col-md-10" style="float: left;">
                          <option value="">Select One</option>
                          <option value="mr">Mr.</option>
                          <option value="mrs">Mrs.</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Comments</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <textarea class="resizable_textarea form-control" name="lcd_Comments" id="lcd_Comments" placeholder="Comments"></textarea>
                        </div>
                      </div>
                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Appt.Date</label>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="checkbox" id="appointment_date_na" name="appointment_date_na" value="0">N/A
                          <div id="date_na1">
                          <input type="hidden" id="appointment_date" name="appointment_date" value="">
                       <div id="datepicker1"></div>
                        </div>
                        </div>
                      </div>
                      <div id="date_na2">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Appt.Time</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="appointment_time" name="appointment_time" class="form-control"  data-parsley-required-message="Please select appointment time">
                        
                        </select>
                        </div>
                      </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Appt.Date & Time</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="appointment_datetime" name="appointment_datetime" class="form-control"  data-parsley-required-message="Please select appointment date & time">
                        <option value="">Select One</option>
                          
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Lead</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="checkbox" id="confirm_lead" name="confirm_lead" value="1">
                        </div>
                      </div>
                    </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">TSR #</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="tsr_number" name="tsr_number" class="form-control" required>
                        <option value="">Select One</option>
                        @for($k=0;$k<count($agent_user_list);$k++)
							<option value="{{$agent_user_list[$k]['ru_UserId']}}">{{$agent_user_list[$k]['ru_FirstName']}}&nbsp;{{$agent_user_list[$k]['ru_LastName']}}</option>
						@endFor
                        
                        </select>
                        </div>
                      </div>
                      <div class="form-group" id="conf" style="display: none;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Conf #</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="conf_number" name="conf_number" class="form-control" >
                        <option value="">Select One</option>
                        @for($k=0;$k<count($agent_user_list);$k++)
							<option value="{{$agent_user_list[$k]['ru_UserId']}}">{{$agent_user_list[$k]['ru_FirstName']}}&nbsp;{{$agent_user_list[$k]['ru_LastName']}}</option>
						@endFor
                        </select>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                         <!-- <button type="submit" class="btn btn-primary">Cancel</button>-->
                         <!-- <button type="submit" name="submit" class="btn btn-success">Submit</button>-->
						 {{Form::submit('submit', array('class' => 'btn btn-primary'))}}
                        </div>
                      </div>
            
            {!! Form::close() !!}
                  <!--  </form>-->
                  </div>
                </div>
              </div>


             
            </div>

         
          </div>
        </div>
        <!-- /page content -->

       </form>
      </div>
    </div>
	  
  
		@endsection	  
