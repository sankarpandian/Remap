 @extends('layouts.master')
 @section('content')
  
  <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>
  
<script>
jQuery(document).ready(function($){ 
$('#lld_CallFromId').change(function() {
//alert("changed");
var lld_CallFromId = document.getElementById('lld_CallFromId').value;
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
if(lld_CallFromId==1)
{
	$("#hd_type_id_display").show();
}
else
{
	$("#hd_type_id_display").hide();
	$("#hd_type_id").removeAttr('data-parsley-id');
	$("#hd_type_id").removeAttr('data-parsley-required-message');
	$("#hd_type_id").removeAttr('required');
}
$.ajax({
     type: "GET",
     url: "./ajax_call_from",
    
     data:{"lld_CallFromId":lld_CallFromId,_token:CSRF_TOKEN},
     dataType: "json",
     success: function(data){ 
      //alert("h");
      //alert(data);
      //alert(element.lmst_time_master);
      $(lld_Calldesc).html("");
              
              if(data!="")
              {
                $("#lld_Calldesc").append(
                   $('<option></option>').val("").html("Select One"));
               
            $.each(data, function(index, element) {
            var value= element.mrd_CompanyCode+element.mrd_ProspectId;
            
            $("#lld_Calldesc").append(
                   $('<option></option>').val(value).html(element.mrd_Source));
            });
          }
          
   }
   
  // 
   });
});

$("#hd_type_id").on("change",function(){
	var hd_type_id = $(this).val();
	if(hd_type_id==2)
	{
		$("#lld_AssociateId").attr('required','required');
		$("#lld_StoreId").attr('required','required');
	}
	else{
        $("#lld_AssociateId").removeAttr('required');
		$("#lld_StoreId").removeAttr('required');
	}
	
});



    });
</script> 
@if(isset($validator))
{{print_r($validator)}} 
@endIf
	<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Lead Source Details <small>Without Script</small></h2>
                    <!--<ul class="nav navbar-right panel_toolbox">
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
                    {!! Form::open(['url' => '/createlead_cusdetails', 'method' => 'post', 'role' => 'form','id'=>'demo-form2','class'=>'form-horizontal form-label-left' , 'data-parsley-validate']) !!}  

					  <?php //echo $status;?>
					
					
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Call From <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">                         
						 <select id="lld_CallFromId" name="lld_CallFromId" class="form-control" required  data-parsley-required-message="Please select the call from">
						<option code="" value="">Select One</option>				
						@foreach($call_froms as $call_from)
              <option value="{{$call_from->lcf_CallFromId}}">{{$call_from->lcf_CallFromName}}</option>
            @endforeach
						</select>
                        </div>
                      </div>  
					   <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Call From Description <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <select id="lld_Calldesc" name="lld_Calldesc" class="form-control" required  data-parsley-required-message="Please select the call from description">
						
						</select>
                        </div>
                      </div>
					  <div class="form-group" id="hd_type_id_display" style="display:none">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Home depot <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <select id="hd_type_id" name="hd_type_id" class="form-control" required data-parsley-required-message="Please select the home depot">
						 <option  value="">Select</option>
						 <option  value="1">Customer</option>
						 <option  value="2">Associate</option>
						</select>
                        </div>
                      </div>
					   <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" required >Associate ID <span class="required"></span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="lld_AssociateId" id="lld_AssociateId" class="form-control col-md-7 col-xs-12" type="text"  data-parsley-required-message="Please enter the associate id">
                        </div>
                      </div>
					  <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12" >Store Number <span class="required"></span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="lld_StoreId" id="lld_StoreId" class="form-control col-md-7 col-xs-12" type="text"  data-parsley-required-message="Please enter the store id">
                        </div>
                      </div>
					  <div class="form-group" style="display:none">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Prospect ID <span class="required"></span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="lld_ProsepctId" id="lld_ProsepctId" class="form-control col-md-7 col-xs-12" type="hidden" >
                        </div>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <!-- <button type="submit" class="btn btn-primary">Cancel</button>
                         <button type="submit" class="btn btn-success">Submit</button>-->
						  {{Form::submit('submit', array('class' => 'btn btn-success'))}}
						  <!--<button type="button" class="btn btn-secondary"><a href="dataentry_cusdetails">Skip</a></button>-->
                        </div>
                      </div>
					
            {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
	  
		@endsection	  