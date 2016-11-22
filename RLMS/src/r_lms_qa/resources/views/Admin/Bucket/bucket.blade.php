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
<div class="x_panel">
 <div class="x_title">
                    <h2>Add Bucket <!-- <small>different form elements</small>--></h2>
                  
                    <div class="clearfix"></div>
 </div>
          
 <div class="x_content">


 {!! Form::open(['url' => '/bucket', 'method' => 'post', 'role' => 'form','id'=>'demo-form2','class'=>'form-horizontal form-label-left','data-parsley-validate']) !!}  

					  <?php //echo $status;?>
					
					           
                      <input type="hidden" name="lb_CompanyId" value="3">
					   <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bucket Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input name="lb_BucketName" id="lb_BucketName" class="form-control col-md-7 col-xs-12" type="text"  required data-parsley-required-message="Please enter the Bucket name">
                        </div>
                      </div>
					   
					   
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <!-- <button type="submit" class="btn btn-primary">Cancel</button>
                         <button type="submit" class="btn btn-success">Submit</button>-->
						  {{Form::submit('submit', array('class' => 'btn btn-success'))}}
						 <!-- <button type="button" class="btn btn-secondary"><a href="dataentry_cusdetails">Skip</a></button>-->
                        </div>
                      </div>
					
            {!! Form::close() !!}

 </div>           
   </div> 
		@endsection	  