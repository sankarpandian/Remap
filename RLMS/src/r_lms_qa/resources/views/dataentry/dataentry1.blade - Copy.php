 @extends('layouts.master')
 @section('content')
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  
  
  
  <script src="{{ URL::asset('assets/datePicker/jquery-1.12.4.js') }}"></script>
  <script src="{{ URL::asset('assets/datePicker/1.12.0/jquery-ui.js')}}"></script>
  <link rel="sylesheet" href="{{ URL::asset('assets/datePicker/jquery-ui.css') }}" type="text/css" media="screen" />
  
  <script>
  jQuery(document).ready(function($){ 
    //$("#lcd_CoownerName").hide();
    $("#OwnerType1").click (function () {
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
    });
    $('#datepicker1').datepicker({
    inline : true,
    altField : '#appointment_date',
    altFormat: "yy-mm-dd",
    onSelect: function (date) {
         var appointment_date = $('#appointment_date').val();
		 var lcd_Zipcode      = $('#lcd_Zipcode').val();
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //alert(appointment_date);
        //var url="/dataentry_cusdetails";
        //alert("helloee");
     $.ajax({
     type: "GET",
     url: "ajax_appointment_date",
    
     data:{"date":appointment_date,"zipcode":lcd_Zipcode,_token:CSRF_TOKEN},
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
//alert("changed");
var appointment_date = document.getElementById('appointment_date').value;
var appointment_time = document.getElementById('appointment_time').value;
var datestring=appointment_date+" "+appointment_time;
//alert(datestring);
//var date1 = Date.parse(dateString, "yyyy-MM-dd HH:mm:a");
//alert(date1);
var add=new Date(datestring);
var sub=new Date(datestring);
var org=new Date(datestring);
//var t=new Date(appointment_time);
//var thetime=t.getHours()+t.getMinutes();
//alert(thetime);
org.setTime(org.getTime());
add.setTime(add.getTime() + (30 * 60 * 1000));
sub.setTime(sub.getTime() - (30 * 60 * 1000));
//alert(sub.toLocaleString());
//alert(sub);
//alert(appointment_time);
//var time = date(strtotime( "$appointment_time + 30 mins")) ;
//alert(time);
//time.setTime(time.getTime() + 30);
//alert(time);
//var theDate = d.getFullYear() + '-' + ( d.getMonth() + 1 ) + '-' + d.getDate(); alert(theDate);
//var theDate =d.format.Date("YYYY-MM-DD");alert(theDate);
//var theTime = theDate + appointment_time;
//alert(theTime);
//var newTime = new Date( Date.parse( theTime ) + 30*60*1000 );
//alert(tt);
$(appointment_datetime).html("");
$("#appointment_datetime").append($('<option></option>').val(org.toLocaleString()).html(org.toLocaleString()));
$("#appointment_datetime").append($('<option></option>').val(add.toLocaleString()).html(add.toLocaleString()));
$("#appointment_datetime").append($('<option></option>').val(sub.toLocaleString()).html(sub.toLocaleString()));
 });

 $('#lcd_Zipcode').change(function() {
//alert("changed");
var lcd_Zipcode = document.getElementById('lcd_Zipcode').value;
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//alert(lld_CallFromId);
$.ajax({
     type: "GET",
     url: "./ajax_zipcode",
    
     data:{"lcd_Zipcode":lcd_Zipcode,_token:CSRF_TOKEN},
     dataType: "json",
     success: function(data){ 
      //alert("h");
      //alert(data)
      //alert(element.lmst_time_master);
      $(lld_ProductCode).html("");
        $(lcd_City).html("");
        $(lcd_County).html("");
        $(lcd_State).html("");      
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
  });
  </script>
  
<style>
.form-control
{
	margin:3px;
}
</style> 
	<div class="row">
              <div class="clearfix"></div>
  {!! Form::open(['url' => '/dataentry_cusdetails1', 'method' => 'post', 'role' => 'form', 'class'=>'form-horizontal form-label-left', 'data-parsley-validate']) !!}    
<input type="hidden" id="lld_CallFromId" name="lld_CallFromId" value="@if(isset($lld_CallFromId)){{$lld_CallFromId}}@endIf" >
<input type="hidden" id="lld_calldescription" name="lld_calldescription" value="@if(isset($lld_calldescription)){{$lld_calldescription}}@endIf" >
<input type="hidden" id="lld_AssociateId" name="lld_AssociateId" value="@if(isset($lld_AssociateId)){{$lld_AssociateId}}@endIf" >
<input type="hidden" id="lld_StoreId" name="lld_StoreId" value="@if(isset($lld_StoreId)){{$lld_StoreId}}@endIf" >  
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
							  <input type="text" class="form-control has-feedback-left" id="lcd_FirstName" name="lcd_FirstName" required  data-parsley-required-message="Please insert your name">
						</div>
					</div>
                      

                     <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" class="form-control" id="lcd_LastName" name="lcd_LastName"  >
						</div>
					</div>

                     <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="email" class="form-control has-feedback-left" id="lcd_EmailAddress" name="lcd_EmailAddress" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Home Phone</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" id="lcd_HomePhone" name="lcd_HomePhone" >
						</div>
					</div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" id="lcd_Zipcode" name="lcd_Zipcode"  >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select name="lld_ProductCode" id="lld_ProductCode" class="form-control" >
                            
                          </select>
                        </div>
                      </div>
                     <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Prospect ID</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                         <label>{{$lld_calldescription}}</label>
                        </div>
                      </div>-->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">House Type</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<select id="lcd_HomeTypeId" name="lcd_HomeTypeId" class="form-control" required>
						<option value="">Select One</option>
						@foreach($hometypes as $hometype)
              <option value="{{$hometype->hometype_id}}">{{$hometype->hometype_name}}</option>
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
                              <input type="radio" class="flat" name="lcd_OwnerTypeId" id="OwnerType1" value="1"> Spouse/Co-Owner 
                            </label>
							<input type="text" class="form-control" name="lcd_CoownerName" id="lcd_CoownerName"  style="display: none;">
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
                          <input type="text" class="form-control" name="lcd_Address" id="lcd_Address" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">City </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control"  name="lcd_City" id="lcd_City" > 
							              <option value="">Select City</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">County</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="lcd_County" id="lcd_County">                                                 
                          <option value="">Select County</option></select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">State <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="lcd_State" id="lcd_State">
                            <option>Select State</option>					
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cross Street</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control"  name="lcd_CrossStreet" id="lcd_CrossStreet" value=""  >
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
                          <input type="text"  name="lcd_Community" id="lcd_Community" class="form-control col-md-10" style="float: left;" />
                      </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">House Color</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="text"  name="lcd_HousecColor" id="lcd_HousecColor" class="form-control col-md-10" style="float: left;" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Work phone</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="lcd_WorkPhone" id="lcd_WorkPhone" class="form-control col-md-10" style="float: left;"  />
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
                          <input type="text" name="cd_CellPhone" id="cd_CellPhone" class="form-control col-md-10" style="float: left;"/>
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">CP Title</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">   
                        <select name="lcd_CPTitle" id="	" class="form-control col-md-10" style="float: left;">
                          <option value="">Select One</option>
                          <option value="mr">Mr.</option>
                          <option value="mrs">Mrs.</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Comments</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <textarea class="resizable_textarea form-control" name="lcd_Comments" id="lcd_Comments" ></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Appt.Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="hidden" id="appointment_date" name="appointment_date" value="">
                       <div id="datepicker1"></div>
                        </div>
                        </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">App.Time</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="appointment_time" name="appointment_time" class="form-control" required>
                        
                        </select>
                        </div>
                      </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Appt.Date & Time</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                        <select id="appointment_datetime" name="appointment_datetime" class="form-control" required>
                        <option value="">Select One</option>
                          
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
            
            
                  <!--  </form>-->
                  </div>
                </div>
              </div>


             
            </div>

         {!! Form::close() !!}
          </div>
       
	  
  
		@endsection	  
