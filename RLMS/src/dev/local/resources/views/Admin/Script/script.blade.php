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
$("#editor").blur("change",function(){
var content =  $(this).html();
$("#descr").val(content);
});
$("#BucketId").on("change",function(){
	var BucketId = $(this).val();
	//alert(BucketId);
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
	type: "GET",
	url: "./BucketIdAjaxGetScreenData",
	data: {'BucketId':BucketId,_token: CSRF_TOKEN},
	dataType: "json",
	success: function(data){
		var countData = Object.keys(data).length;
		$("#ScreenId").html("");
		$("#ScreenId").append("<option value=''>Select</option>");
		for(var i=0;i<countData;i++)
		{
			//alert(data[i]['lsn_ScreentId']);
			$("#ScreenId").append("<option value="+data[i]['lsn_ScreentId']+">"+data[i]['lsn_ScreenName']+"</option>");
		}
	}
	});
});

$("#ScreenId").on("change",function(){
	var ScreenName = $("#ScreenId option:selected").text();
	if(ScreenName=='Products')
	{
	  $("#ForProduct").show();
	  $("#ForScript").hide();
	  $("#ScriptOne").removeAttr('required');
	  if($("#descr").prop("required"))
	  {
		//alert('Iam in');
	  }
	  else
	  {
		  //alert('Iam not ');
		  $("#descr").attr('required','required');  
	  }
	  
	}
	else
	{
	  $("#ForProduct").hide();
	  $("#ForScript").show();
	  $("#descr").removeAttr('required');
	  if($("#ScriptOne").prop("required"))
	  {
		
	  }
	  else
	  {
		  $("#ScriptOne").attr('required','required');  
	  }
	}
});
});
</script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="x_panel">
 <div class="x_title">
                    <h2>Add Script  <!-- <small>different form elements</small>--></h2>
                  
                    <div class="clearfix"></div>
                  </div>
  <br/> 
<div class="x_content">
@if(isset($success_msg))
<div class="alert alert-success alert-dismissible fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
</button>
<div align="center"><b>{{$success_msg}}<b></div>
</div>
@endIf
{!! Form::open(['url' => '/script', 'method' => 'post', 'role' => 'form','id'=>'demo-form2','class'=>'form-horizontal form-label-left','data-parsley-validate']) !!}  

	<input type="hidden" name="CompanyId" value="3"> 
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Bucket Name <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select id="BucketId" name="BucketId" class="form-control" required  data-parsley-required-message="Please select the bucket name">
	<option value="">Select One</option>				
    @for($i=0;$i<count($ListBuckets);$i++)
		<option value="{{$ListBuckets[$i]['lb_BucketId']}}">{{$ListBuckets[$i]['lb_BucketName']}}</option>
	@endFor
	</select>
	</div>
	</div>
    
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Screen Name <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select id="ScreenId" name="ScreenId" class="form-control" required  data-parsley-required-message="Please select the screen name">
	<option value="">Select One</option>				
   
	</select>
	</div>
	</div>
	<div id="ForScript" style="display:none">
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Script One <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input name="ScriptOne" id="ScriptOne" class="form-control col-md-7 col-xs-12" type="text"  required data-parsley-required-message="Please enter the script one" value="">
	</div>
	</div>
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Script Two <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input name="ScriptTwo" id="ScriptTwo" class="form-control col-md-7 col-xs-12" type="text" value="">
	</div>
	</div>
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Script Three <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input name="ScriptThree" id="ScriptThree" class="form-control col-md-7 col-xs-12" type="text" value="" >
	</div>
	</div>
	</div>
	<div id="ForProduct" style="display:none">
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product Name <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select id="ProductCode" name="ProductCode" class="form-control"   data-parsley-required-message="Please select the screen name">
	<option value="">Select One</option>				
    @for($i=0;$i<count($ListProduct);$i++)
		<option value="{{$ListProduct[$i]['lp_ProductCode']}}">{{$ListProduct[$i]['lp_ProductName']}}</option>
	@endFor	
	</select>
	</div>
	</div>
	
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product Decription <span class="required">*</span></label>
    <div class="col-md-9 col-sm-12 col-xs-12">
              <div class="x_panel">
               
                <div class="x_content">
                  <div id="alerts"></div>
                  <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                      <ul class="dropdown-menu">
                      </ul>
                    </div>

                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li>
                          <a data-edit="fontSize 5">
                            <p style="font-size:17px">Huge</p>
                          </a>
                        </li>
                        <li>
                          <a data-edit="fontSize 3">
                            <p style="font-size:14px">Normal</p>
                          </a>
                        </li>
                        <li>
                          <a data-edit="fontSize 1">
                            <p style="font-size:11px">Small</p>
                          </a>
                        </li>
                      </ul>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                      <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                      <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                      <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                      <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                      <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                      <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                      <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                      <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                      <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                      <div class="dropdown-menu input-append">
                        <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                        <button class="btn" type="button">Add</button>
                      </div>
                      <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                      <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                      <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                    </div>
                  </div>

                  <div id="editor" class="editor-wrapper"></div>

                  <textarea name="descr" id="descr" required data-parsley-required-message="Please enter the product details"  style="display:none" ></textarea>
                  
                  

                
                </div>
              </div>
            </div>
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