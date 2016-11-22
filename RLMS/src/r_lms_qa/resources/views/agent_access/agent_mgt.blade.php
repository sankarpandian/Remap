@extends('layouts.master')

@section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>



 <style>
 .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12
 {
	 padding-left:3px;
	 padding-right:3px;
 }
 .modal-sm 
 {
	 width:560px;
 }
 </style>
 
    <script>
    $(document).ready(function($){ 
	
$(".buttonFinish").wrap('<input class="btn btn-primary classInsert" name="Save" id="Save" type="submit" value="Save">');
	$(".buttonFinish").removeAttr('class');
	
	
	
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
		

	$("#user-email").on('blur',function() {
		
	    var user_email = $("#user-email").val();
		if(!ValidateEmail(user_email))
		{
		    var display_msg = '<ul class="parsley-errors-list filled" id="parsley-id-5"><li >Invalid Email Address.</li></ul>';
			$("#error_msg_email").html(display_msg).fadeOut(3000, function() { });
		    return false;
		}	
	});
	$('#lms_check').on('change', function(){ // on change of state
   if(this.checked) // if changed state is "CHECKED"
    {
	   $("#agent_choice").show();
    }
	else
	{
	   var admin_exit   =  $('#admin_check:checked').val();
	   if(admin_exit!='admin')
	   {
	   $("#agent_choice").hide();
       $("#tsr_config").hide();	   
	   }
	}
   });
   
   $('#oldr_check').on('change', function(){ // on change of state
   if(this.checked) // if changed state is "CHECKED"
    {
	   $("#for_branch_store").show();
    }
	else
	{
	  var admin_exit1   =  $('#admin_check:checked').val();
       if(admin_exit1!='admin')
	   {
	   $("#for_branch_store").hide();	
	   
	   }
	}
   });
   
    $('#admin_check').on('change', function(){ // on change of state
   if(this.checked) // if changed state is "CHECKED"
    {
	   $("#agent_choice").show();
	   $("#for_branch_store").show();
    }
	else
	{
	   var lms_exit   =  $('#lms_check:checked').val();
	   var oldr_exist =  $('#oldr_check:checked').val();
	   if(lms_exit!='lms')
	   {
	    $("#agent_choice").hide();
	   }
	   if(oldr_exist!='oldr')
	   {
	    $("#for_branch_store").hide();	  
	   }
	   $("#tsr_config").hide();	
	}
   });
 /* $("#myform input[type='radio']:checked").val();
  $("#temp_agent").live("click",function(){
	//var agent = $(this).val();  
	$("#tsr_val").val('566778');
	$("#cofig_val").val('566778');
  });
 */
 $('input:radio[name="lmsa_agent_type"]').change(function(){
  if($(this).val()=='Agent')
  {
	  $("#tsr_config").show();
	  $("#tsr_val").val('');
	  $("#config_val").val('');
  }
  else if($(this).val()=='Temp Agent')
  {
	  $("#tsr_config").show();
	  $("#tsr_val").val('456325');
	  $("#config_val").val('789654');
  }
});
/*$("#agent_appln").submit(function()
{
	alert('hihi');
	return false;
});*/

$(".various_edit").on("click",function()
{
	   //Change the slide2 save to update
	  $("#Save").attr('value', 'Update'); 
	  $("#Save").attr('name', 'Update'); 
	  
	   //Change the slide2 save to update
   	  $("#Insert").attr('value', 'Update'); 
	  $("#Insert").attr('name', 'Update_two');
	   //Change the slide3 Fnish to Edit_Finish
	  $("#Finish").attr('name','Edit_Finish');
	
	var get_id=$(this).attr('alt');
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
    url: './Edit_access_mgt',
    type: 'POST',
    data: {send_id: get_id,_token: CSRF_TOKEN},
    dataType: 'json',
    success: function (data) {
       
		for(var k=0;k<data['relation'].length;k++)
		{
			var section_id    = data['relation'][k].rdr_SectionId;
			var relat_menu_id = data['relation'][k].rdr_MenuId;
			var sub_menu_id   = data['relation'][k].rdr_SubMenuId;
			// Sub Menu
			var sub_menu_for_check = data['relation'][k].rdr_SubMenuId;
			if((data['relation'][k].rdr_SectionId!==null) && (data['relation'][k].rdr_MenuId!==null) && (data['relation'][k].rdr_SubMenuId!==null))
			{
			var sub_menu_value=data['relation'][k].rdr_SectionId+'_'+data['relation'][k].rdr_MenuId+'_'+data['relation'][k].rdr_SubMenuId;
			$(".sub_menu_attr_id_"+sub_menu_value).attr('checked','checked');
			}
			// Menu
			if((data['relation'][k].rdr_SectionId!==null) && (data['relation'][k].rdr_MenuId!==null))
			{
			var menu_value=data['relation'][k].rdr_SectionId+'_'+data['relation'][k].rdr_MenuId;
			$(".menu_attr_id_"+menu_value).attr('checked','checked');
			}
			// Section
			if((data['relation'][k].rdr_SectionId!==null))
			{
			var section_value=data['relation'][k].rdr_SectionId;
			$(".section_attr_id_"+section_value).attr('checked','checked');
			}
			
			
		}
		
		//Edit for agent user list
      	$("#first-name").val(data[0].ru_FirstName);
		$("#last-name").val(data[0].ru_LastName);
		$("#user-email").val(data[0].ru_Email);
		$("#user-role").val(data[0].ru_Role);
		$("#user-name").val(data[0].ru_UserName);
		$("#user_id").val(data[0].ru_UserId);
		
		
		//Edit for Application Access List
		var appl_access= data[0].lam_AgentType;
		
		if(appl_access!='')
		{
			var result=appl_access.split(',');
            
			if(result[0]!='' && result[0]=='lms')
			{
				$("#lms_check").attr('checked','checked');
				$("#agent_choice").show();
				$("#tsr_config").show();
				if(data[0].lam_AgentTsr!='')
				{
					$("#tsr_val").val(data[0].lam_AgentTsr);
				}
				if(data[0].lam_AgentConfig!='')
				{
					$("#config_val").val(data[0].lam_AgentConfig);
				}
		
			}
			if(result[1]!='' && result[1]=='oldr')
			{
				$("#oldr_check").attr('checked','checked');
				$("#for_branch_store").show();
			}
			if(result[2]!='' && result[2]=='admin')
			{
				$("#admin_check").attr('checked','checked');
			}
			
				var lmsa_branch_get = data[0].lam_Branch.split(',');
				for(var i=0;i<lmsa_branch_get.length;i++)
				{
				   $("#lmsa_branch option[value='" + lmsa_branch_get[i] + "']").attr("selected", 1);
				}
				
				var lmsa_store_get = data[0].lam_Store.split(',');
				for(var i=0;i<lmsa_store_get.length;i++)
				{
				   $("#lmsa_store_id option[value='" + lmsa_store_get[i] + "']").attr("selected", 1);
				}
				
							
				var relat_section_id =  data[0].rdr_SectionId;
							
			    if(data[0].lam_AgentType=='Agent')
				{
				$("#agent").attr('checked', true);
				$("#temp_agent").reamoveAttr('checked');
				}
				else
				{
				    $("#temp_agent").attr('checked', true);	
					$("#agent").reamoveAttr('checked');
					
				}
						
		}
	 
   	  
    }
});
});

 $(".user_delete").on("click",function()
{
	//alert('hi');
	var user_id = $(this).attr('id');
	alert(user_id);
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
    url: './Delete_access_mgt',
    type: 'POST',
    data: {send_id: user_id,_token: CSRF_TOKEN},
    dataType: 'json',
    success: function (data) {
		
	}
	});
});
/*$("#Insert").on("click",function(){
	//alert('hihi');
	$("#error_app_type").text('');	
	var display_msg1 = '<ul class="parsley-errors-list filled" id="parsley-id-5"><li >Invalid Email Address.</li></ul>';
	var test = $(".lmsa_app_type").val();
	if ($('input.lmsa_app_type').is(':checked')) {
		
		return true;
	}
	else
	{
	$("#error_app_type").html(display_msg1);	
	}
	return false;
});*/

$("#myDiv1").on("click",function()
{
	//alert('hihih');
	
	validateSteps(3);
	
	
});	
	});
	 function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
    function validateAllSteps(){
        var isStepValid = true;
        // all step validation logic     
        return isStepValid;
    }  
	function leaveAStepCallback(obj, context){
       // alert("Leaving step " + context.fromStep + " to go to step " + context.toStep);
        return validateSteps(context.fromStep); // return false to stay on step and true to continue navigation 
		
    }

    function onFinishCallback(objs, context){
        if(validateAllSteps()){
           // $('form').submit();
        }
    }

	
    // Your Step validation logic
    function validateSteps(stepnumber){
		
        var isStepValid = true;
        // validate step 1
		
		
		//alert(stepnumber);
	var first_name  = $("#first-name").val();
	var last_name   = $("#last-name").val();
	var user_role   = $("#user-role").val();
	var user_email  = $("#user-email").val();
	var user_name   = $("#user-name").val();
	var company_id  = $("#company-id").val();
	var error_msg   = '';
	var display_msg = '<ul class="parsley-errors-list filled" id="parsley-id-5"><li >This Field is required.</li></ul>';
	
	if(stepnumber == 1){
		//alert('test');
	$(".classInsert").removeAttr('name');	
	$(".classInsert").removeAttr('value');	
	$(".classInsert").attr('name','Insert');
	$(".classInsert").attr('value','Save');
	$(".classInsert").attr('id','Insert');
	var user_id=$("#user_id").val();
	//alert(user_id);
	if(user_id!='')
	{
	$(".classInsert").removeAttr('name');	
	$(".classInsert").removeAttr('value');	
	$(".classInsert").attr('value', 'Update'); 
	$(".classInsert").attr('name', 'Update_two');
	$(".classInsert").attr('id', 'Update_two');
	}
	else
	{
	$(".classInsert").removeAttr('name');	
	$(".classInsert").removeAttr('value');	
	$(".classInsert").attr('name','Insert');
	$(".classInsert").attr('value','Save');
	$(".classInsert").attr('id','Insert');
	}
	
        if(first_name=='')
		{
			    $("#first-name").focus();
				$("#error_msg_fname").html(display_msg).fadeOut(3000, function() { });
			    return false;
		}
		
		if(last_name=='')
		{
			    $("#last-name").focus();
				$("#error_msg_lname").html(display_msg).fadeOut(3000, function() { });
			    return false;
		}
		else if(user_email=='')
		{
			$("#user-email").focus();
			$("#error_msg_email").html(display_msg).fadeOut(3000, function() { });
		    return false;
		}
		
		else if(user_role=='')
		{
			$("#user-role").focus();
			$("#error_msg_urole").html(display_msg).fadeOut(3000, function() { });
		    return false;
		}
		
		else if(user_name=='')
		{
			$("#user-name").focus();
			$("#error_msg_uname").html(display_msg).fadeOut(3000, function() { });
		    return false;
		}
         return true;
        }
		else if(stepnumber == 2)
		{
			var user_id=$("#user_id").val();
			if(user_id!='')
			{
			$(".classInsert").attr('name','Edit_Finish');	
			$(".classInsert").attr('value','Finish');
			$(".classInsert").attr('id','edit_Finish');
			}
			else
			{
			$(".classInsert").removeAttr('name');	
			$(".classInsert").removeAttr('value');	
			$(".classInsert").attr('name','Finish');
			$(".classInsert").attr('value','Finish');
			$(".classInsert").attr('id','Finish');
			}
			
			var lmsa_app_type = $(".lmsa_app_type:checked").val();
			var lmsa_agent_type=$(".lmsa_agent_type:selected").val();
			//alert(lmsa_agent_type);
			if(lmsa_app_type==undefined)
			{
				//$(".lmsa_app_type").focus();
				$("#error_app_type").html(display_msg).fadeOut(3000, function() { });
				return false;
			}
			else
			{
				return true;
			}
	
			//else if()
			
		}
		else if(stepnumber == 3)
		{
			return true;
		}

        // ...      
    }
    </script>
    <!-- /jQuery Tags Input -->  
  


	  <!-- page content -->
	



   <!-- page content -->
   <!--
<div id="div_one_exist" style="display:none;">
<div style="margin:42px auto;" align="center">
<a id="ex" href="#"  class="btn btn-info btn-sm">Existing Calender</a>
<a id="new" href="add_calendar" class="btn btn-info btn-sm">Create New Calender</a>
 
</div>
<div id="import_log">


             
</div>

</div>
-->
 <style>
 .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12
 {
	 padding-left:3px;
	 padding-right:3px;
 }
 .modal-sm 
 {
	 width:560px;
 }
 
@media screen and (max-width: 456px) {
div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter {
		text-align: left; 
		width:100%;
	}
}
 </style>
 <!-- Small modal -->
                 

                  
                  <!-- /modals -->
       <!-- <div class="right_col" role="main">-->
        
           <meta name="csrf-token" content="{{ csrf_token() }}" />
            <div class="clearfix"></div>

           
        <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th class="column-title">First name </th>
                            <th class="column-title">Last Name </th>
                            <th class="column-title">Email </th>
							<th class="column-title">Username </th>
							<th class="column-title">User Role </th>
							<th class="column-title">Action </th>
                            <th class="column-title"><a href="#myDiv" id="myDiv1" class="various"><button type="button" class="btn btn-info btn-xs">Add New</button></a> </th>
                            <!--<th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>-->
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                        </tr>
                      </thead>
                      <tbody>
					
					@for($ab=0;$ab<count($UserData_display);$ab++)
							
							
							<tr class="even pointer">
                            <td class=" ">{{$UserData_display[$ab]['ru_FirstName']}}</td>
                            <td class=" ">{{$UserData_display[$ab]['ru_LastName']}} </td>
                            <td class=" ">{{$UserData_display[$ab]['ru_Email']}}</td>
							<td class=" ">{{$UserData_display[$ab]['ru_UserName']}}</td>
							<td class=" ">{{$UserData_display[$ab]['ru_Role']}}</td>
							<td class=" ">
							
							<a href="#myDiv" id="myDiv1" alt="{{$UserData_display[$ab]['ru_UserId']}}" class="various_edit">
							Edit
								</a> 
							
                          
								
								
								/<a href="#"  id="{{$UserData_display[$ab]['ru_UserId']}}" class="user_delete"> Delete</a></td>
							<td class=" "></td>
                             </tr>
                           
               
							
							@endfor
                        
						
                      
                       
                       
                       </tbody>
                     </table>
					
             
            </div>
		   </div>	
		</div>		
 <!-- jQuery -->
   
    <!-- Bootstrap -->
    <script src="{{ URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    
    <!-- Datatables -->
    <script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
   
   
    <script src="{{ URL::asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>	
    
    
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Appointment Slot</h4>
                        </div>
                        <div class="modal-body">
                         
                         
						  
						  <div class="display_time_slot" style="margin-left: 90px;" ></div>
						  
						  
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         <!-- <button type="button" class="btn btn-primary">Save changes</button>-->
                        </div>

                      </div>
                    </div>
                  </div>
    

    <!-- Datatables -->
 
                    <!-- Smart Wizard -->
             
				<div style="display:none">
					<div id="myDiv" >
				  {!! Form::open(['url' => '/agent_mgt', 'method' => 'post','class'=>'form-horizontal form-label-left','id'=>'demo-form2' , 'role' => 'form','data-parsley-validate']) !!}
				  {{Form::hidden('user_id',null,array('id'=>'user_id'))}}
					<div id="wizard" class="form_wizard wizard_horizontal">
                     <ul class="wizard_steps">
                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                                             
                                              <small>Agent Information</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                                                   <small>Application Access Details</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                                              <small>Agent Access</small>
                                          </span>
                          </a>
                        </li>
                       
                      </ul>
                      <div id="step-1">
					 					  
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="usrs_firstname" required="required" class="form-control col-md-7 col-xs-12">
						  <div id="error_msg_fname"></div>
                        </div>
                      </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="last-name" name="usrs_lastname" required="required" class="form-control col-md-7 col-xs-12">
							  <div id="error_msg_lname"></div>
							  <div id="error_msg_lname" style=""></div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="user-email" class="form-control col-md-7 col-xs-12" type="text" name="usrs_email" required="required">
							  
							   <div id="error_msg_email"></div>
							  <div id="error_msg_email" style=""></div>
                            </div>
                          </div>
						  <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">User Role </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="user-role" class="form-control col-md-7 col-xs-12" type="text" name="usrs_role">
							   <div id="error_msg_urole"></div>
							 
                            </div>
                          </div>
						  
						  <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">User Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="user-name" name="usrs_username" required="required" class="form-control col-md-7 col-xs-12">
							  <div id="error_msg_uname"></div>
							  <div id="error_msg_uname" style=""></div>
                            </div>
							
                          </div>
						  
						<!--{{Form::submit('Save', array('class' => 'btn btn-primary','name' => 'Save','id' => 'Save'))}}-->
                       <!-- {!! Form::close() !!}  
						<button type="submit" id="save_user_det" class="btn btn-success">Save</button>
						  <input type="submit" name="Submit" id="Submit" class="btn btn-success" >-->
						 
                       
            
						

                        

                      </div>
                      <div id="step-2">
                                              
                        <!-- {!! Form::open(['url' => '/agent_mgt', 'method' => 'post', 'role' => 'form','class'=>'form-horizontal form-label-left','id'=>'agent_appln']) !!}-->
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Application Access
                            </label>
							
                            <div class="col-md-6 col-sm-6 col-xs-12" >
							<p style="padding: 5px;">
							<input type="checkbox" required name="lmsa_app_type[]"   data-parsley-multiple="lmsa_app_type" class="lmsa_app_type flat" id="lms_check"   value="lms" >LMS
							 <input type="checkbox" name="lmsa_app_type[]" data-parsley-multiple="lmsa_app_type" class="lmsa_app_type flat" id="oldr_check" required  value="oldr">OLDR
							 <input type="checkbox" name="lmsa_app_type[]"  data-parsley-multiple="lmsa_app_type" class="lmsa_app_type flat" required id="admin_check"  value="admin">Admin
									<!-- <div id="error_app_type"></div>-->
							 </p>
                              
                            </div>
                          </div>
						  
						  <div class="form-group" id="agent_choice" style="display:none">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Agent</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div id="gender" class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                  <input type="radio" name="lmsa_agent_type" id="agent" class="lmsa_agent_type" value="Agent" required > &nbsp; Agent &nbsp;
                                </label>
                                <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                  <input type="radio" name="lmsa_agent_type" id="temp_agent" class="lmsa_agent_type" value="Temp Agent"> Temp Agent
                                </label>
                              </div>
                            </div>
                          </div>
						  <div id="tsr_config" style="display:none">
						  <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">TSR <span class="required" required="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="tsr_val" name="lmsa_agent_tsr"  class="form-control col-md-7 col-xs-12" required="required">
                            </div>
                          </div>
						  
						  <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Config <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="config_val" name="lmsa_agent_config"  class="form-control col-md-7 col-xs-12" required="required">
                            </div>
                          </div>
						  </div>
						<div id="for_branch_store" style='display:none'>  
						   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="select2_multiple form-control lms_branch" name="lmsa_branch[]" id="lmsa_branch" multiple="multiple" >
                            <option>Choose option</option>
                            <option value="1">Atlanta</option>
                            <option value="2">Birmingham</option>
                            <option value="3">Boston</option>
                            <option value="4">Chicago North</option>
                            <option value="5">Chicago South</option>
                            <option value="6">Cleveland</option>
                          </select>
                        </div>
                      </div>
					  
				<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Store</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="select2_multiple form-control" id="lmsa_store_id" name="lmsa_store[]" multiple="multiple" required="required">
                            <option value="">Choose option</option>
							<option value="1">3001 </option>
                            <option value="2">3002</option>
                            <option value="3">3003</option>
                            <option value="4">3004</option>
                            
                          </select>
                        </div>
                </div>
				</div>		  
						 	
						<!--{{Form::submit('Save', array('class' => 'btn btn-primary','name'=>'Insert','id'=>'Insert'))}}
                        <!--{!! Form::close() !!}  -->
                       
					
                      </div>
                      <div id="step-3">
                         <!-- start accordion -->
			  <?php 
			  //print_r($agentDetailsGetAccess);
			  $relat_unique_sect_id     = '';
			  $relat_unique_menu_id     = '';
			  $relat_unique_sub_menu_id = '';
			  
			  $relat_unique_sect_id_arr     = array();
			  $relat_unique_menu_id_arr    = array();
			  $relat_unique_sub_menu_id_arr =array();
			  
			 for($i=0;$i<count($agentDetailsGetAccess);$i++)
				{
				  $section_name = $agentDetailsGetAccess[$i]->rs_SectionName;
				  $menu_name    = $agentDetailsGetAccess[$i]->rm_MenuName;
				  $sub_menu_name= $agentDetailsGetAccess[$i]->rsm_SubMenuName;
				  
				  $relat_section_id = $agentDetailsGetAccess[$i]->rdr_SectionId;
				  $relat_menu_id    = $agentDetailsGetAccess[$i]->rdr_MenuId;
				  $relat_sub_menu_id= $agentDetailsGetAccess[$i]->rdr_SubMenuId;
				  
				  if($relat_unique_sect_id!=$relat_section_id)
				   {
					$relat_unique_sect_id_arr[] =$relat_section_id;
					
				   }
				   if($relat_unique_menu_id!=$relat_menu_id)
					{
					 $relat_unique_menu_id_arr[]=$relat_menu_id;
					
					}
				   if($relat_unique_sub_menu_id!=$relat_sub_menu_id)
					{
					$relat_unique_sub_menu_id_arr[]=$relat_sub_menu_id;
					
					}
				
			     }
			  
			 
				$get_unique_sect_name = "";
				$get_unique_menu_name = "";
			    $get_unique_sub_menu_name = "";
				
				$get_unique_sect_id = "";
				$get_unique_menu_id = "";
			    $get_unique_sub_menu_id = "";
				
				
				$k=0;
				$section_id  = "";
				$menu_id     = "";
				$sub_menu_id = "";
				?>
				<div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
				<!--{!! Form::open(['url' => '/agent_mgt', 'method' => 'post', 'role' => 'form','class'=>'form-horizontal form-label-left','id'=>'agent_appln']) !!}-->
				<?php 
				//print_r($get_agent_access_list);
				for($i=0;$i<count($get_agent_access_list);$i++)
				{
				  $section_name = $get_agent_access_list[$i]->rs_SectionName;
				  $menu_name    = $get_agent_access_list[$i]->rm_MenuName;
				  $sub_menu_name= $get_agent_access_list[$i]->rsm_SubMenuName;
				  
				  $section_id = $get_agent_access_list[$i]->rdr_SectionId;
				  $menu_id    = $get_agent_access_list[$i]->rdr_MenuId;
				  $sub_menu_id= $get_agent_access_list[$i]->rdr_SubMenuId;
				  
				 
				 echo '<div class="panel">';
				  if($get_unique_sect_id!=$section_id)
				   {
					$get_unique_sect_name =$section_name;
					$get_unique_sect_id =$section_id;
					echo '<a class="panel-heading" id="headingOne1" aria-expanded="true" aria-controls="collapseOne">
                          <h6 class="panel-title">
						  <input type="checkbox" class="section_attr_id_'.$get_unique_sect_id.'" value="'.$get_unique_sect_id.'" id="section_attr_id" name="section[]"';
						/*  if(in_array($get_unique_sect_id,$relat_unique_sect_id_arr))
						  {
							  echo 'checked';
						  }*/
						  echo '>
						  '.$get_unique_sect_name.'</h6>
                        </a>';
				   }
				   if($get_unique_menu_id!=$menu_id)
					{
					 $get_unique_menu_id   = $menu_id;
					 $get_unique_menu_name = $menu_name;
					//echo '<br>';
					echo '<div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body" style="margin-left:80px">
						  <input type="checkbox" id="menu_attr_id" class="menu_attr_id_'.$get_unique_sect_id.'_'.$get_unique_menu_id.'" value="'.$get_unique_sect_id.'_'.$get_unique_menu_id.'" name="menu[]"';
						 /* if(in_array($get_unique_menu_id,$relat_unique_menu_id_arr))
						  {
							  echo 'checked';
						  }*/
						  echo '>
                            '.$get_unique_menu_name.'
                          </div>
                        </div>';
					}
				   if($get_unique_sub_menu_id!=$sub_menu_id && $sub_menu_id!='')
					{
					$get_unique_sub_menu_name=$sub_menu_name;
					$get_unique_sub_menu_id=$sub_menu_id;
					echo '<div style="margin-left:150px"><input type="checkbox" class="sub_menu_attr_id_'.$get_unique_sect_id.'_'.$get_unique_menu_id.'_'.$get_unique_sub_menu_id.'" id="sub_menu_attr_id" value="'.$get_unique_sect_id.'_'.$get_unique_menu_id.'_'.$get_unique_sub_menu_id.'" name="sub_menu[]" ';
						 /* if(in_array($get_unique_sub_menu_id,$relat_unique_sub_menu_id_arr))
						  {
							  echo 'checked';
						  }*/
						  echo '>'.$get_unique_sub_menu_name.'</div>';
						
					}
				echo '</div>';	
			     }
				
				echo '</div>';
				
						
				?>
				<!--{{Form::submit('Finish', array('class' => 'btn btn-primary','name'=>'Finish','id'=>'Finish'))}}-->
                {!! Form::close() !!}  
				
                    <!-- end of accordion -->
                          
                      </div>
                      </div>
                      
                    </div>
								
								</div>
						

							
						
                    
                   
                    <!-- End SmartWizard Content -->
@endsection		  
  
