@extends('layouts.master')

@section('content')
<!--<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>
-->
<script src="{{ URL::asset('vendors/jquery/jquery.js') }}"></script>




 <!-- jQuery Tags Input -->
    <script>
    jQuery(document).ready(function($){ 
	var calendar_name = $.trim($("#calendar_name").val());
	if(calendar_name=='')
	{
		$("#view_all_territory").hide();
	}	
	
	   $("#calen_from").submit(function(){
		var calen_day     = $.trim($("#calen_day").val());
		var calen_hour    = $.trim($("#calen_hour").val());
		var calen_minutes = $.trim($("#calen_minutes").val());
		var calen_ampm    = $.trim($("#calen_ampm").val());
		
		var j=1;
		var k=1;
		var l=1;
		var bool=false;
		
		if($("#calendar_name").val()=='')
		{
			$("#error_msg").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Please Provide a Calender name</strong></div>');
			$("#calendar_name").focus();
			return false;
		}
		
		if(calen_day=='')
		{
			$("#calen_day").focus();
			$("#error_msg").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Please select the day</strong></div>');
			
			return false;
		}
		for(var i=1;i<=$(".calen_hour").length;i++)
		{
			
			var calen_hour_array = $("#calen_hour"+j).val();
			//alert(calen_hour_array);
			if(calen_hour_array=='')
			{
				
				//$("#calen_hour"+j).focus();
				$("#error_msg").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Please select the hours</strong></div>');
				$("#calen_hour"+j).focus();
				return false;
			}
			else
			{
				j++;
			}
			
		}
		
		for(var i=1;i<=$(".calen_minutes").length;i++)
		{
			
			var calen_minutes_array = $("#calen_minutes"+k).val();
			
			if(calen_minutes_array=='')
			{
				//alert('minutes');
				//$("#calen_hour"+j).focus();
				$("#error_msg").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Please select the minutes</strong></div>');
				$("#calen_minutes"+k).focus();
				return false;
			}
			else
			{
				k++;
			}
			
		}
		
		for(var i=1;i<=$(".calen_ampm").length;i++)
		{
			
			var calen_ampm_array = $("#calen_ampm"+l).val();
			if(calen_ampm_array=='')
			{
				//$("#calen_hour"+j).focus();
				$("#error_msg").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Please select the pm or am</strong></div>');
				$("#calen_ampm"+l).focus();
				return false;
			}
			else
			{
				l++;
			}
			
		}
	//Hours	
	  
	 var calen_hour_array  =  new Array;
	 $(".calen_hour").each(function(){
		var value_hrs= $(this).val();
		calen_hour_array.push(value_hrs);
	 });
	 
	 
	 
	 //calen_minutes	
	 
	 var calen_minutes_array  =  new Array;
	 $(".calen_minutes").each(function(){
		var value_min= $(this).val();
		calen_minutes_array.push(value_min);
	 });
	 
	 
	 //calen_ampm	
	 
	 var calen_ampm_array  =  new Array;
	 $(".calen_ampm").each(function(){
		var value_ampm= $(this).val();
		calen_ampm_array.push(value_ampm);
	 });
	 
	 var calendar_name = $.trim($("#calendar_name").val());
	 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	 
	 
	// alert(calendar_name);
	  var path_exist=$("#path_exist").val();
	  var path='.';
		 if(path_exist==undefined)
		 {
			 path='.';
		 }
		 else
		 {
			path='..';
		 }
	 $.ajax({
     type: "GET",
     url: path+"/call_from_ajax",
     data: {"ajax_mode": "insert_brach_calen", "calen_day" : calen_day,"calen_hour_array" : calen_hour_array,'calen_minutes_array':calen_minutes_array,'calen_ampm_array':calen_ampm_array,'calendar_name':calendar_name,_token: CSRF_TOKEN},
     dataType: "json",
     success: function(data){
		 //alert(data.length);
		 var display_slot="";
		  
		  display_slot+='<div class="col-md-6 col-sm-6 col-xs-12"><div class="x_panel"><div class="x_title"><h2>Appointment Slot </h2><div class="clearfix"></div></div><div class="x_content">';
		 for(var i=0;i<data.length;i++)
		 {
	     display_slot+='<table ><tbody><tr><td width="100">'+data[i].date_master_name+'</td><td ><table class="table table-bordered"><tbody><tr>';
			  
		    var object = data[i];
			for (property in object) {
				var value = object[property];
						
				if(typeof value.lt_TimeMaster === 'undefined' || value.lt_TimeMaster === null)
				{
				
				}
				else
				{
				 display_slot+='<td>'+value.lt_TimeMaster+'&nbsp;<a href="#" class="lmst_time fa fa-close" id="'+value.lt_TimeId+'"></a></td>';	
				}
			}
		  display_slot+='</tr></tbody></table></td></tbody></tr></table>';
		 }
		 display_slot+='</div></div></div>';
		 $("#error_msg").html('');
		 $(".display_time_slot").html(display_slot);
	 }
    });
		return false;
		
	});
	
	 var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;
        var j=2;
        $('#addScnt').live('click', function() {
			if(i<6)
	         {
				
                $('<p style="text-indent:0%;"><label for="p_scnts"><select name="calen_hour[]" id="calen_hour'+j+'" class="calen_hour form-control form-control_new" >   <option value="">Hours</option>     <?php for($i=1;$i<=12;$i++){ ?>     <option value="<?php echo $i;?>"><?php echo $i; ?></option>     <?php } ?>    </select>    <select name="calen_minutes[]" id="calen_minutes'+j+'" class="calen_minutes form-control form-control_new" >     <option value="">Minutes</option>     <option value="00">00</option>     <option value="30">30</option>    </select>  <select name="calen_ampm[]" id="calen_ampm'+j+'" class="calen_ampm form-control form-control_new">     <option value="">AM/PM</option>     <option value="AM">AM</option>     <option value="PM">PM</option>    </select><a href="#" id="remScnt" class="btn btn-danger">Remove</a></label></p>').appendTo(scntDiv);
				j++;
                i++;
	       }
		  
                return false;
        });
	 
        $('#remScnt').live('click','a', function() { 
                if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                }
                return false;
        });
		
   $("#update_territory").submit(function(){
	  
	var calendar_name=$(".calendar_name_cl").val();
		//alert('test');
	
	if(calendar_name=='')
	{
	$("#error1").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Please Provide a Calender name</strong></div>');
	return false;	
	}
	var bool=false;
	 $("#territory_code").each(function(){
		var territory_code_sel=$(this).val();
		//alert(territory_code_sel);
		
		if(territory_code_sel!=null)
		{
			bool=true;
		}
		else
		{
			$("#error1").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Please select the territory</strong></div>');
			bool=false;
		}
		
	
	});
	if(bool==true)
	$("#error1").html('');	
	return bool;
	
	
	//return false;	
	});
		
    $("#view_all_territory").on("click",function(){
		var calendar_name = $.trim($("#calendar_name").val());
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		var path_exist=$("#path_exist").val();
	    var path='.';
		 if(path_exist==undefined)
		 {
			 path='.';
		 }
		 else
		 {
			path='..';
		 }
		//alert(calen_name);
	<!--var territory_get_data = '<div class="table-responsive"><table class="table table-striped jambo_table bulk_action"><thead><tr class="headings"><th><input type="checkbox" id="check-all" class="flat"></th><th class="column-title">Territory </th><th class="bulk-actions" colspan="7"><a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a></th></tr></thead><tbody>';-->
	var territory_get_data = '';
		 $.ajax({
     type: "GET",
     url: path+"/call_from_ajax",
     data: {"ajax_mode": "all_territory_calen",'calendar_name':calendar_name,_token: CSRF_TOKEN},
     dataType: "json",
     success: function(data){
		// alert(data.length);
		// alert(data[0].lb_TerritoryName);
		 for(var i=0;i<data.length;i++)
		 {
			
			 territory_get_data = territory_get_data+' <tr class="even pointer"><td class="a-center "><input type="checkbox" class="flat" name="table_records" value="'+data[i].lb_TerritoryId+'" >'+data[i].lb_TerritoryName+'</td></tr>';
			 
		 }
		// alert(territory_get_data);
		//territory_get_data = territory_get_data+'</tbody></table></div>';
		 $(".inner_territory_data").html(territory_get_data);
		 $("#change_name_territory").html('All Territories &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ');
	 }
	 
	// 
	 });
	return false;
	});
	$(".lmst_time").live("click",function()
	{
		var lmst_time_id = $(this).attr('id');
		
		var calendar_name = $.trim($("#calendar_name").val());
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		var path_exist=$("#path_exist").val();
	    var path='.';
		 if(path_exist==undefined)
		 {
			 path='.';
		 }
		 else
		 {
			path='..';
		 }
	
		 $.ajax({
		 type: "GET",
		 url: path+"/call_from_ajax",
		 data: {"ajax_mode": "delete_appointment_slot_time",'lmst_time_id':lmst_time_id,'calendar_name':calendar_name,_token: CSRF_TOKEN},
		 dataType: "json",
		 success: function(data)
		 {
			// alert(data);	
			var display_slot="";
		  
		  display_slot+='<div class="col-md-6 col-sm-6 col-xs-12"><div class="x_panel"><div class="x_title"><h2>Appointment Slot </h2><div class="clearfix"></div></div><div class="x_content">';
		 for(var i=0;i<data.length;i++)
		 {
	     display_slot+='<table ><tbody><tr><td width="100">'+data[i].date_master_name+'</td><td ><table class="table table-bordered"><tbody><tr>';
			  
		    var object = data[i];
			for (property in object) {
				var value = object[property];
						
				if(typeof value.lt_TimeMaster === 'undefined' || value.lt_TimeMaster === null)
				{
				
				}
				else
				{
				 display_slot+='<td>'+value.lt_TimeMaster+'&nbsp;<a href="#" class="lmst_time fa fa-close" id="'+value.lt_TimeId+'"></a></td>';	
				}
			}
		  display_slot+='</tr></tbody></table></td></tbody></tr></table>';
		 }
		 display_slot+='</div></div></div>';
		 $("#error_msg").html('');
		 $(".display_time_slot").html(display_slot);
		 }
		});
		return false;
	});
	
	$("#delete_territory").on("click",function(){
		var CSRF_TOKEN    = $('meta[name="csrf-token"]').attr('content');
		var calendar_name = $.trim($("#calendar_name").val());
		var territory_arr = [];
		$(".flat:checked").each(function()
		{
			
			  var territory = $(this).val();
			  territory_arr.push(territory)
			 
				
		});
		var path_exist=$("#path_exist").val();
	    var path='.';
		 if(path_exist==undefined)
		 {
			 path='.';
		 }
		 else
		 {
			path='..';
		 }
		 var territory_get_data1='';
		 $.ajax({
		 type: "GET",
		 url: path+"/call_from_ajax",
		 data: {"ajax_mode": "delete_territory",'territory_id_arr':territory_arr,'calendar_name':calendar_name,_token: CSRF_TOKEN},
		 dataType: "json",
		 success: function(data)
		 {
		for(var i=0;i<data.length;i++)
		 {
			//alert(data[i].lb_TerritoryId);
			 territory_get_data1 = territory_get_data1+' <tr class="even pointer"><td class="a-center "><input type="checkbox" class="flat" name="table_records" value="'+data[i].lb_TerritoryId+'" >'+data[i].lb_TerritoryName+'</td></tr>';
			 
		 }
		// alert(territory_get_data);
		//territory_get_data = territory_get_data+'</tbody></table></div>';
		
		 $(".inner_territory_data").html(territory_get_data1);
		 //$("#change_name_territory").html('All Territories &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ');
		 }

		  });
		});
	});	
    </script>
    <!-- /jQuery Tags Input -->  
  
<style>

</style>

	  <!-- page content -->
	   <div class="col-md-6 col-sm-6 col-xs-12 col-md-61">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 class="content_h2">Add Branch For Calendar</h2>
                   
                    <div class="clearfix"></div>
                  </div>
				  <div id="error1" style="color:red"></div>
                  <div class="x_content">

                    <table class="table">
                      <thead>
                        <tr>
                          
                          <th>Calendar Name</th>
                          <th>Territory Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
						
						 {!! Form::open(['method' => 'POST','url' => '/add_calendar','id'=>'update_territory']) !!}
						 <td>
						 @If(isset($calendar_name_from_edit))
						 <input type="hidden" name="company_id" id="company_id" class="calendar_name_cl form-control" value="3">
					     <input type="hidden" id="path_exist" value="{{$calendar_name_from_edit}}">
					     <input type="hidden" name="calendar_name" id="calendar_name" value="{{$calendar_name_from_edit}}">
						<br> <b>{{$calendar_name_from_edit}}</b>
					     @else
						 <input type="text" name="calendar_name" id="calendar_name" class="calendar_name_cl form-control" value="@if(isset($_POST['calendar_name'])) {{$_POST['calendar_name']}} 
						  @elseIf(isset($calendar_name_from_edit))
						  {{$calendar_name_from_edit}}
						  @endIf">
						  @endIf
						  <input type="hidden" name="company_id" id="company_id" class="calendar_name_cl form-control" value="3">
						  </td>
                          <td>
						  
						  <select name="territory_code[]" id="territory_code" class="territory_code form-control" multiple="multiple" style="min-height:100px;">
						  @for($i=0;$i<count($lms_branch_data);$i++)
							  @if(isset($_POST['territory_code']))
							  <option value="{{$lms_branch_data[$i]['lb_TerritoryId']}}" <?php if(in_array($lms_branch_data[$i]['lb_TerritoryId'],$_POST['territory_code'])) echo 'selected';
                              else echo '';
                              
						  ?>> {{$lms_branch_data[$i]['lb_TerritoryName']}}
						     </option>
							  @elseIf(isset($territory_code_from_edit))
							  <option value="{{$lms_branch_data[$i]['lb_TerritoryId']}}" <?php if(in_array($lms_branch_data[$i]['lb_TerritoryId'],$territory_code_from_edit)) echo 'selected';
                              else echo '';
                              
						  ?>> {{$lms_branch_data[$i]['lb_TerritoryName']}}
						     </option>
							 @else
							<option value="{{$lms_branch_data[$i]['lb_TerritoryId']}}" > {{$lms_branch_data[$i]['lb_TerritoryName']}}
						     </option> 
							 @endIf
						  @endfor
						  
						  
						  </select>
						  </td>
                          <td><input type="submit" name="submit"  value="Submit" value="Insert" id="submit_territory" class="btn btn-success btn-xs" ></td>
                        </tr>
						@If(isset($calendar_name_from_edit))
						<tr><td></td><td><b><a href="../add_calendar">Click</a></b> here to create new calendar </td><td></td></tr>
					    @elseIf(isset($_POST['calendar_name']))
						<tr><td></td><td><b><a href="./add_calendar">Click</a></b> here to create new calendar </td><td></td></tr>
					    @endIf
                        {!! Form::close() !!}
                      </tbody>
                    </table>

                  </div>
				  
				  
                </div>
		</div>		
				
				
				
             

             
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-62">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 class="content_h2">Create Appointment Slots</h2>
                   
                    <div class="clearfix"></div>
                  </div>
				  <div id="error_msg" style="color:red"></div>
                  <div class="x_content">

                    <table class="table table-striped">
                      <thead>
                        <tr>
                         
                          <th style="width:100px">Day</th>
                          <th style="text-align:center">Appoinment Slot</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                         
                          <td>
						  
						
       {!! Form::open(['method' => 'POST','url' => '#','id'=>'calen_from']) !!}	
	   <meta name="csrf-token" content="{{ csrf_token() }}" />
       <input type="hidden" name="calendar_name" id="calendar_name" value="<?php if(isset($_REQUEST['calendar_name'])) echo $_REQUEST['calendar_name'];?>">  
	   <input type="hidden" name="company_id" id="company_id" class="calendar_name_cl form-control" value="@if(isset($_REQUEST['company_id'])) {{$_REQUEST['company_id']}} @else {{""}}@endIf ">
         @if(isset($_REQUEST['territory_code']))		 
		 @for($j=0;$j<count($_REQUEST['territory_code']);$j++)
		   <?php echo '<input type="hidden" name="territory_code[]" value="'.$_REQUEST['territory_code'][$j].'">'; ?>
		   @endfor
		  @endIf
		<select name="calen_day" id="calen_day" class="form-control form-control_new">
		<option value="">Day</option>
		@for($j=0;$j<count($lms_date_master_data);$j++)
		<option value="{{$lms_date_master_data[$j]['ldm_DateMasterId']}}">{{ucfirst($lms_date_master_data[$j]['ldm_DateMaster'])}}</option>	
		@endfor	
		</select></td>
                          <td><div id="p_scents" align="center">
		<p align="center">
			<label for="p_scnts"><select name="calen_hour[]" id="calen_hour1" class="calen_hour form-control form-control_new" >
			<option value="">Hours</option>
			<?php for($i=1;$i<=12;$i++){ ?> 
			<option value="<?php echo $i;?>"><?php echo $i; ?></option>  
			<?php } ?>    </select> 
			<select name="calen_minutes[]" id="calen_minutes1" class="calen_minutes form-control form-control_new"> 
			<option value="">Minutes</option> 
			<option value="00">00</option>  
			<option value="30">30</option> 
			</select>  
			<select name="calen_ampm[]" id="calen_ampm1" class="calen_ampm form-control form-control_new"> 
			<option value="">AM/PM</option>  
			<option value="AM">AM</option>  
			<option value="PM">PM</option> 
			</select></label><a href="#" id="addScnt"></a>
		</p>
	  </div></td><h5  align="right"></h5>		
                          <td><a href="#"  id="addScnt" class="btn btn-success btn-xs">Add New</a></td>
                         </tr>
						 <tr><td></td><td align="center"><input type="submit" name="add" value="Submit" id="Add" class="btn btn-success btn-xs" /></td></tr>
        {!! Form::close() !!}                
                      </tbody>
                    </table>




</div>
                  </div>
                </div>
              
			  
			<div style="clear:both"></div>  
			  <div class="col-md-6 col-sm-6 col-xs-12 col-sm-63">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 class="content_h2"> @if(isset($lms_cal_terr_check))
							<span id="change_name_territory">The Existing Territories </span><a href="#" id="view_all_territory" class="btn btn-success btn-xs" >View All</a><a href="#" id="delete_territory" class="btn btn-info btn-xs">Delete</a>
						 @else
							 Terrritories
						 <a href="#" id="view_all_territory" class="btn btn-success btn-xs" >View All</a><a href="#" id="delete_territory" class="btn btn-info btn-xs">Delete</a>
						@endIf	
						</h2>
                    
                    <div class="clearfix"></div>
                  </div>
				  
				  <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat" value="0">
                            </th>
                            <th class="column-title">Territory </th>
                            
                            
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="inner_territory_data">
                       
						   @if(isset($lms_cal_terr_check))
							
							@for($i=0;$i<count($lms_cal_terr_check);$i++)
							<tr class="even pointer">	
							<td class="a-center "><input type="checkbox" class="flat" name="table_records" value="{{$lms_cal_terr_check[$i]['lb_TerritoryId']}}" ></td>
						    <td class=" ">{{$lms_cal_terr_check[$i]['lb_TerritoryName']}}</td>
							</tr>
							@endfor
							@endIf
                           
                           
                          
                          
                          
                        </tbody>
                      </table>
                    </div>
					
				 <!--  <div id="list_all_territory">
                  <div class="x_content"><a href="#" id="delete_territory">Delete</a>
                    <table class="table table-hover">
                      <thead>
					
                          @if(isset($lms_cal_terr_check))
							
							@for($i=0;$i<count($lms_cal_terr_check);$i++)
							<tr><td><input type="checkbox" class="flat" value="{{$lms_cal_terr_check[$i]['lb_TerritoryId']}}" >{{$lms_cal_terr_check[$i]['lb_TerritoryName']}}</td></tr>
							@endfor
							@endIf
                          
                      
                      </thead>
                      
                    </table>

                  </div>
				  </div> 
				  -->
                </div>
              </div>
	<div class="display_time_slot">		  
			  <div class="col-md-6 col-sm-6 col-xs-12 col-md-62">
			  <div class="x_panel">
			  <div class="x_title">
			  <h2 class="content_h2">Appointment Slot </h2>
			  <div class="clearfix"></div>
			  </div>
           <div class="x_content">
		<?php 


	?> 
			   @if(isset($appointment_slot_data))
				<?php    
			   foreach($appointment_slot_data as $object)
			   {
					$arrays[] = $object->toArray();
			   }
			   ?><table><tbody>
				@for($i=0;$i<count($arrays);$i++)
			
			       <tr> <td width="100">{{ucfirst($arrays[$i]['ldm_DateMaster'])}}	</td>
					@for($j=0;$j<count($arrays[$i]);$j++)
					
						@if(!empty($arrays[$i][$j]))
							<td><table class="table table-bordered"><tbody><tr><td> {{$arrays[$i][$j]['lt_TimeMaster']}}&nbsp;&nbsp;<a href="#" class="lmst_time fa fa-close" id="{{$arrays[$i][$j]['lt_TimeId']}}"></a></td></tr></tbody></table></td>
						      
					    @endIf
					
					@endFor
				@endFor
			   
			   </tr></tbody></table>
					
				@endIf
			  
			  <table>
			  <tbody>
			  <tr>
			   
			  <table class="table table-bordered">
			  <tbody>
			  </tbody></table>
			  
			  </div>
				  
          </div>
      </div>
			  
   </div>  
      <!-- End page content -->
  
@endsection		  
  
