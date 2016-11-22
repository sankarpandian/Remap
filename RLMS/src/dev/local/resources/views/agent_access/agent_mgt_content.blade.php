 <!-- jQuery -->
   <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
   
   <!-- Parsley -->
  <!--  <script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>-->
<!-- 	<script src="vendors/validator/validator.min.js"></script>
	 Add jQuery basic library -->
	 <!-- Add required fancyBox files -->
<link rel="stylesheet" href="{{ URL::asset('assets/fancybox/source/jquery.fancybox.css')}}" type="text/css" media="screen" />
<style>
 .stepContainer
{
	//height:0px !important;
}
</style>


 <script type="text/javascript">
$(document).ready(function(){
	
	
	$(".fancybox").fancybox({
		openEffect  : 'none',
		closeEffect : 'none',
		iframe : {
			preload: false
		}
	});
	$("#myDiv1").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '50%',
		height		: '80%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	
	
	
	$('.fancybox-media').fancybox({
		openEffect  : 'none',
		closeEffect : 'none',
		helpers : {
			media : {}
		}
	});
	
   $('#wizard').smartWizard({
        onLeaveStep:leaveAStepCallback,
        onFinish:onFinishCallback
    });

    function leaveAStepCallback(obj, context){
		
      //  alert("Leaving step " + context.fromStep + " to go to step " + context.toStep);
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
			var lmsa_app_type = $(".lmsa_app_type:checked").val();
			var lmsa_agent_type=$(".lmsa_agent_type:selected").val();
			//alert(lmsa_agent_type);
			if(lmsa_app_type==undefined)
			{
				//$(".lmsa_app_type").focus();
				$("#error_app_type").html(display_msg).fadeOut(3000, function() { });
				return false;
			}
			//else if()
			return true;
		}
		else if(stepnumber == 3)
		{
			return true;
		}

        // ...      
    }
	$("#user-email").on('blur',function() {
		
	    var user_email = $("#user-email").val();
		if(!ValidateEmail(user_email))
		{
		    var display_msg = '<ul class="parsley-errors-list filled" id="parsley-id-5"><li >Invalid Email Address.</li></ul>';
			$("#error_msg_email").html(display_msg).fadeOut(3000, function() { });
		    return false;
		}	
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
	//alert('hihi');
	var get_id=$(this).attr('alt');
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	//alert(get_id);
	$.ajax({
    url: 'http://localhost:8088/remap_lms_may_31/public/Edit_access_mgt',
    type: 'POST',
    data: {send_id: get_id,_token: CSRF_TOKEN},
    dataType: 'json',
    success: function (data) {
        //console.log(data);
		//alert(data);
    }
});
});

});
</script>   
<style>
.col-md-6232
{
	width:100%;
}
.accordion .panel-heading ,.panel-body
{
	padding:3px;
}
</style> 
	  <!-- page content -->
          

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Agent management <small>Sessions</small></h2><br><br><br>
				
					<meta name="csrf-token" content="{{ csrf_token() }}" />		
			
                    <ul class="nav navbar-right panel_toolbox">
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
                    </ul>
                    <div class="clearfix"></div>
					
                  </div>
				   <div class="x_content">
                   <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                           <!-- <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>-->
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
                         
                           <!-- <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>-->
							<?php 
							for($ab=0;$ab<count($UserData_display);$ab++)
							{
							?>
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
							
                          
								
								
								/ Delete</td>
							<td class=" "></td>
                             </tr>
                           <?php 
               
							
							}

							?>
                         
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
            <div class="x_content">


                    <!-- Smart Wizard -->
              <p>
				<div style="display:none">
					<div id="myDiv" >
				  {!! Form::open(['url' => '/agent_mgt', 'method' => 'post','class'=>'form-horizontal form-label-left','id'=>'demo-form2' , 'role' => 'form']) !!}
					<div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="" style="list-style:none" >
                        <li>
                          <a href="#step-1">
                           </a>
                        </li>
                        <li>
                          <a href="#step-2">
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                          </a>
                        </li>
                        
                      </ul>
                      <div id="step-1">
					  <h2 class="StepTitle">Agent Information</h2>
					  
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="usrs_firstname">
							  <div id="error_msg_fname" style=""></div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="last-name" name="usrs_lastname" required="required" class="form-control col-md-7 col-xs-12">
							  <div id="error_msg_lname" style=""></div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="user-email" class="form-control col-md-7 col-xs-12" type="text" name="usrs_email" required="required">
							  <div id="error_msg_email" style=""></div>
                            </div>
                          </div>
						  <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">User Role </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="user-email" class="form-control col-md-7 col-xs-12" type="text" name="usrs_role">
							 
                            </div>
                          </div>
						  
						  <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">User Name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="user-name" name="usrs_username" required="required" class="form-control col-md-7 col-xs-12">
							  <div id="error_msg_uname" style=""></div>
                            </div>
							
                          </div>
						  
						{{Form::submit('Save', array('class' => 'btn btn-primary','name' => 'Save','id' => 'Save'))}}
                       <!-- {!! Form::close() !!}  
						<button type="submit" id="save_user_det" class="btn btn-success">Save</button>
						  <input type="submit" name="Submit" id="Submit" class="btn btn-success" >-->
						 
                       
            
						

                        

                      </div>
                      <div id="step-2">
                        <h2 class="StepTitle">Application Access Details</h2>
                        <p>
                          
                        <!-- {!! Form::open(['url' => '/agent_mgt', 'method' => 'post', 'role' => 'form','class'=>'form-horizontal form-label-left','id'=>'agent_appln']) !!}-->
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Application Access
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12" >
                              <input type="checkbox" name="lmsa_app_type[]" class="lmsa_app_type" id="lms_check"  value="lms" >LMS
							   <input type="checkbox" name="lmsa_app_type[]" class="lmsa_app_type" id="oldr_check"  value="oldr">OLDR
							     <input type="checkbox" name="lmsa_app_type[]" class="lmsa_app_type" id="admin_check"  value="admin">Admin
								 <div id="error_app_type"></div>
                            </div>
                          </div>
						  
						  <div class="form-group" id="agent_choice" style="display:none">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Agent</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div id="gender" class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                  <input type="radio" name="lmsa_agent_type" id="agent" class="lmsa_agent_type" value="Agent"> &nbsp; Agent &nbsp;
                                </label>
                                <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                  <input type="radio" name="lmsa_agent_type" id="temp_agent" class="lmsa_agent_type" value="Temp Agent"> Temp Agent
                                </label>
                              </div>
                            </div>
                          </div>
						  <div id="tsr_config" style="display:none">
						  <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">TSR <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="tsr_val" name="lmsa_agent_tsr"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
						  
						  <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Config <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="config_val" name="lmsa_agent_config"  class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
						  </div>
						<div id="for_branch_store" style='display:none'>  
						   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="select2_multiple form-control" name="lmsa_branch[]" multiple="multiple">
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
                          <select class="select2_multiple form-control" name="lmsa_store[]" multiple="multiple">
                            <option value="">Choose option</option>
							<option value="1">3001 </option>
                            <option value="2">3002</option>
                            <option value="3">3003</option>
                            <option value="4">3004</option>
                            
                          </select>
                        </div>
                      </div>
				    </div>		  
						 	
						{{Form::submit('Update', array('class' => 'btn btn-primary','name'=>'Update'))}}
                        <!--{!! Form::close() !!}  -->
                        </p>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
                      </div>
                      <div id="step-3">
                         <!-- start accordion -->
			 <h2>Agent Access</h2> 
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
						  <input type="checkbox" value="'.$get_unique_sect_id.'" name="section[]"';
						  if(in_array($get_unique_sect_id,$relat_unique_sect_id_arr))
						  {
							  echo 'checked';
						  }
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
						  <input type="checkbox" value="'.$get_unique_sect_id.'_'.$get_unique_menu_id.'" name="menu[]"';
						  if(in_array($get_unique_menu_id,$relat_unique_menu_id_arr))
						  {
							  echo 'checked';
						  }
						  echo '>
                            '.$get_unique_menu_name.'
                          </div>
                        </div>';
					}
				   if($get_unique_sub_menu_id!=$sub_menu_id && $sub_menu_id!='')
					{
					$get_unique_sub_menu_name=$sub_menu_name;
					$get_unique_sub_menu_id=$sub_menu_id;
					echo '<div style="margin-left:150px"><input type="checkbox" value="'.$get_unique_sect_id.'_'.$get_unique_menu_id.'_'.$get_unique_sub_menu_id.'" name="sub_menu[]" ';
						  if(in_array($get_unique_sub_menu_id,$relat_unique_sub_menu_id_arr))
						  {
							  echo 'checked';
						  }
						  echo '>'.$get_unique_sub_menu_name.'</div>';
						
					}
				echo '</div>';	
			     }
				
				echo '</div>';
				
						
				?>
				{{Form::submit('Finish', array('class' => 'btn btn-primary','name'=>'Finish'))}}
                {!! Form::close() !!}  
				
                    <!-- end of accordion -->
                          
                      </div>
                      </div>
                      
                    </div>
								
								</div>
							</div>

							
						</p> 
                    
                   
                    <!-- End SmartWizard Content -->
	  
			  