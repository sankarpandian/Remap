@extends('layouts.master')
 @section('content')
  
  <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('vendors/mask/jquery.maskedinput.min.js') }}"></script>
@foreach($cust_detail as $cust_details)
<script>
jQuery(document).ready(function($){ 
    $('#lcd_HomePhone').mask('(999) 999-9999');
    $('#lcd_WorkPhone').mask('(999) 999-9999');
    $('#lcd_CellPhone').mask('(999) 999-9999');	

 $('#lcd_Zipcode').change(function() {

var lcd_Zipcode = document.getElementById('lcd_Zipcode').value;
var half_id = document.getElementById('half_id').value;
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$.ajax({
     type: "GET",
     url: "./ajax_zipcode",
    
     data:{"lcd_Zipcode":lcd_Zipcode,_token:CSRF_TOKEN},
     dataType: "json",
	 async:false,
     success: function(data){ 
     // alert("h");
	  
      //alert(data.territory_code[0].lb_TerritoryCode);
      //alert(element.lmst_time_master);
      $("#lld_ProsepctId").html("");
      $("#ProsepctId").html("");
      $("#territory_code").val(data.territory_code[0].lb_TerritoryCode);
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
			if(lcd_Zipcode=='{{$cust_details->lcd_Zipcode}}')
				{
					
					$("#lld_ProductCode").val('{{$cust_details->lld_ProductCode}}');
					$("#lcd_City").val('{{$cust_details->lcd_City}}');
					$("#lcd_County").val('{{$cust_details->lcd_County}}');
					$("#lcd_State").val('{{$cust_details->lcd_State}}');
					$('#lld_ProductCode').trigger('change');
				}
			
        
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

$('input:radio[name="lcd_OwnerTypeId"]').change(function(){
	
	var CoownerName = $('#CoownerName');
      
      // if is company
      if ($(this).val() == 1) {
        // show panel
        $('#lcd_CoownerName').val('{{$cust_details->lcd_CoownerName}}');
       // CoownerName.show();
        document.getElementById('CoownerName').style.display = 'block';
        // remove disabled prop
        CoownerName.find('input,select,radio').prop('disabled', false);
		$('#lcd_CoownerName').attr('required', true);
      } 
      else {
        $('#lcd_CoownerName').val('');
        document.getElementById('CoownerName').style.display = 'none';
        // if is not company, hide the panel and add disabled prop
        //CoownerName.hide();
        CoownerName.find('input,select,radio').prop('disabled', true);
		$('#lcd_CoownerName').removeAttr('required');
      }
     
    });
	
	
	
	$('#lcd_Zipcode').trigger('change');
	$('#lld_ProductCode').trigger('change');
	
	
	
	$('input:radio[name="lcd_OwnerTypeId"][value="{{$cust_details->lcd_OwnerTypeId}}"]').prop('checked', true);
	$("#lcd_HomeTypeId").val('{{$cust_details->lcd_HomeTypeId}}');
	$("#lcd_WPTitle").val('{{$cust_details->lcd_WPTitle}}');
	$("#lcd_CPTitle").val('{{$cust_details->lcd_CPTitle}}');
	$("#tsr_number").val('{{$cust_details->lld_AgentCreatedBy}}');
	$("#conf_number").val('{{$cust_details->lld_AgentUpdatedBy}}');	
});
</script>	
	<div class="row">
              <div class="clearfix"></div>
  {!! Form::open(['url' => '/update_custdetails', 'method' => 'post', 'role' => 'form', 'class'=>'form-horizontal form-label-left', 'data-parsley-validate']) !!}   

<input type="hidden" id="lld_ProsepctId" name="lld_ProsepctId" >
<input type="hidden" id="half_id" name="half_id" value="{{$cust_details->lld_CallDescription}}<?php echo date('my');?>" >
<input type="hidden" id="territory_code" name="territory_code" >
<input type="hidden" id="lcd_CustomerId" name="lcd_CustomerId" value="{{$cust_details->lcd_CustomerId}}" >
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
							  <input type="text" class="form-control" id="lcd_FirstName" name="lcd_FirstName" value="{{$cust_details->lcd_FirstName}}" placeholder="First Name" required  data-parsley-required-message="Please insert your name">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" class="form-control" id="lcd_LastName" name="lcd_LastName" value="{{$cust_details->lcd_LastName}}" placeholder="Last Name" required data-parsley-pattern="^[A-Za-z]+((\s)?((\')?([A-Za-z])+))*$" data-parsley-pattern-message="Please fill a Valid Name" data-parsley-required-message="Please fill your Last Name" >
						</div>
					</div>

                     <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="email" class="form-control" id="lcd_EmailAddress" name="lcd_EmailAddress" value="{{$cust_details->lcd_EmailAddress}}" placeholder="Email" data-parsley-type-message="Please fill a Valid Email">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Home Phone</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" class="form-control" id="lcd_HomePhone" name="lcd_HomePhone" value="{{$cust_details->lcd_HomePhone}}" required data-parsley-required-message="Please fill Phone Number" >
						</div>
					</div>

                     

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" id="lcd_Zipcode" name="lcd_Zipcode"  value="{{$cust_details->lcd_Zipcode}}" placeholder="Zipcode" required data-parsley-type="digits" data-parsley-length="[5, 5]" data-parsley-length-message ="Please fill 5 digit Zipcode" data-parsley-required-message="Please fill Zipcode">
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
                         <label id="ProsepctId">{{$cust_details->lld_ProsepctId}}</label>
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
							 <input type="radio"  name="lcd_OwnerTypeId" id="OwnerType1" value="1" required data-parsley-required-message="Please select Owner Type"> Spouse/Co-Owner &nbsp;
                            </label>
                          
						  
                            <label>
                              <input type="radio"  name="lcd_OwnerTypeId"  id="OwnerType2" value="2"> Sole Owner &nbsp;
                            </label>
                          
                            <label>
                              <input type="radio" name="lcd_OwnerTypeId"  id="OwnerType3" value="3"> 1-Leg &nbsp;
                            </label>
                          </div>
						  <div id="CoownerName" style="display: none;">
							<input type="text" class="form-control" name="lcd_CoownerName" id="lcd_CoownerName"placeholder="Spouse/Co-Owner"  data-parsley-required-message="Please fill Co-Owner Name" >
                         </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="lcd_Address" id="lcd_Address" value="{{$cust_details->lcd_Address}}" placeholder="Address" required data-parsley-required-message="Please fill Address">
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
                            <option value="">Select State</option>					
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cross Street</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control"  name="lcd_CrossStreet" id="lcd_CrossStreet" value="{{$cust_details->lcd_CrossStreet}}"  placeholder="Cross Street">
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
                          <input type="text"  name="lcd_Community" id="lcd_Community" class="form-control col-md-10" style="float: left;" value="{{$cust_details->lcd_Community}}" placeholder="Community Name"/>
                      </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">House Color</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="text"  name="lcd_HousecColor" id="lcd_HousecColor" class="form-control col-md-10" style="float: left;" value="{{$cust_details->lcd_HousecColor}}" placeholder="House Color"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Work phone</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="lcd_WorkPhone" id="lcd_WorkPhone" class="form-control col-md-10" style="float: left;" value="{{$cust_details->lcd_WorkPhone}}" placeholder="Work phone"/>
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
                          <input type="text" name="lcd_CellPhone" id="lcd_CellPhone" class="form-control col-md-10" style="float: left;" value="{{$cust_details->lcd_CellPhone}}" placeholder="Cell phone" />
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
                           <textarea class="resizable_textarea form-control" name="lcd_Comments" id="lcd_Comments" placeholder="Comments">{{$cust_details->lcd_Comments}}</textarea>
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
                      <div class="form-group" id="conf">
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
            @endforeach
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