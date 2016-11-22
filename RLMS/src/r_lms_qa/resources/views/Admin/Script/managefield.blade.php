 @extends('layouts.master')
 @section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>

<script>
jQuery(document).ready(function($){
});
</script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="x_panel">
 <div class="x_title">
                    <h2>Manage Form Fields  <!-- <small>different form elements</small>--></h2>
                  
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
{!! Form::open(['url' => '/managefield', 'method' => 'post', 'role' => 'form','id'=>'demo-form2','class'=>'form-horizontal form-label-left','data-parsley-validate']) !!}

	<input type="hidden" name="CompanyId" value="3"> 
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Field Name <span class="required">*</span></label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input name="FieldName" id="FieldName" class="form-control col-md-7 col-xs-12" type="text" required="" data-parsley-required-message="Please enter the Field Name">
        </div>
	</div>
    
	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Field Class <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input name="FieldClass" id="FieldClass" class="form-control col-md-7 col-xs-12" type="text" required="" data-parsley-required-message="Please enter the Field Class">
        </div>
	</div>
	

	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Field ID <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input name="FieldID" id="FieldID" class="form-control col-md-7 col-xs-12" type="text" required="" data-parsley-required-message="Please enter the Field ID">
        </div>
	</div>

    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Field Type <span class="required">*</span></label>
        <div class="col-md-9 col-sm-6 col-xs-12">
            <div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" name="FieldType" value="text" required="" data-parsley-required-message="please select the element type"> Text
                </label>
            </div>
            <div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" name="FieldType" value="textarea" data-parsley-required-message="please select the element type"> Textarea
                </label>
            </div>
            <div class="radio" style="float:left" >
                <label>
                    <input type="radio" class="flat" name="FieldType" value="select" data-parsley-required-message="please select the element type"> Selectbox
                </label>
            </div>
            <div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" name="FieldType" value="checkbox" data-parsley-required-message="please select the element type"> Checkbox
                </label>
            </div>
            <div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" name="FieldType" value="radio" data-parsley-required-message="please select the element type"> Radio
                </label>
            </div>
            <div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" name="FieldType" value="hidden" data-parsley-required-message="please select the element type"> Hidden
                </label>
            </div>
        </div>
	
    </div>

	<div class="form-group">
	<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Screen Name  <span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<select id="ScreenId" name="ScreenId" class="form-control" required  data-parsley-required-message="Please select the screen name">
	<option value="">Select</option>
	<option value="1">Associate Info</option>				
    <option value="2">Greetings</option>	
	<option value="3">Products</option>	
	<option value="4">Customer Info</option>	
	<option value="5">Appointment</option>	
	<option value="6">Review</option>	
	</select>
	</div>
	</div>
    <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Master Data <span class="required">*</span></label>
        <div class="col-md-9 col-sm-6 col-xs-12">
            <div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" name="lm_MasterData" id="lm_MasterData" value="yes" required="" data-parsley-required-message="please select this option"> Yes
                </label>
            </div>
			<div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" name="lm_MasterData" id="lm_MasterData" value="no" required="" data-parsley-required-message="please select this option"> No
                </label>
            </div>
            
        </div>
	
    </div>
		
	<div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Validation <span class="required">*</span></label>
        <div class="col-md-9 col-sm-6 col-xs-12">
            <div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" id="lm_ElementValidStatus" name="lm_ElementValidStatus" value="yes" required="" data-parsley-required-message="please select this option"> Yes
                </label>
            </div>
			<div class="radio" style="float:left">
                <label>
                    <input type="radio" class="flat" id="lm_ElementValidStatus" name="lm_ElementValidStatus" value="no" required="" data-parsley-required-message="please select this option"> No
                </label>
            </div>
            
        </div>
	
    </div>	

	<div class="form-group">
	<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	<!-- <button type="submit" class="btn btn-primary">Cancel</button>
	<button type="submit" class="btn btn-success">Submit</button>-->
	{{Form::submit('submit', array('class' => 'btn btn-success','id' => 'submit'))}}
	<!-- <button type="button" class="btn btn-secondary"><a href="dataentry_cusdetails">Skip</a></button>-->
	</div>
	</div>

{!! Form::close() !!}

</div> 
  
            
   </div> 
		@endsection	  