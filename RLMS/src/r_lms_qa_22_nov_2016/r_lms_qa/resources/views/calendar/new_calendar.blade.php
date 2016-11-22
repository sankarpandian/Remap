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
 
@media screen and (max-width: 456px) {
div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter {
		text-align: left; 
		width:100%;
	}
}
 </style>
    <script>
    jQuery(document).ready(function($){ 

		$("#ex").click(function(){
				
			$("#div_one_exist").css("display","block");
			
		});
		
  $(".timeslot_view").on("click",function(){
	  var calendar_id = $(this).attr('id');
	  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			 
			  $.ajax({
     type: "GET",
     url: "./call_from_ajax",
     data: {"ajax_mode": "list_calen_page",'calendar_id':calendar_id,_token: CSRF_TOKEN},
     dataType: "json",
     success: function(data){
		 //alert(data.length);
		
		 var display_slot="";
		  
		 display_slot+='';
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
				 display_slot+='<td>'+value.lt_TimeMaster+'</td>';	
				}
			}
		  display_slot+='</tr></tbody></table></td></tbody></tr></table>';
		 }
		 display_slot+='';
		 //alert(display_slot);
		 
		 $(".display_time_slot").html(display_slot);
	 }
    });
		//return false;
		  });
		
	$(".timeslot_approval_view").on("click",function(){
	  var calendar_id = $(this).attr('id');
	  var territory_id_get = $(this).attr('name');
	  var calendar_terr_id = $(this).attr('data-calendar_terr_id');
	  $("#territory_id_from_approval").val(territory_id_get);
	  $("#calendar_id_from_approval").val(calendar_id);
	  $("#calendar_terr_id_from_approval").val(calendar_terr_id);
	  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			 
			  $.ajax({
     type: "GET",
     url: "./call_from_ajax",
     data: {"ajax_mode": "list_calen_page",'calendar_id':calendar_id,_token: CSRF_TOKEN},
     dataType: "json",
     success: function(data){
		 //alert(data.length);
		
		 var display_slot="";
		  
		 display_slot+='';
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
				 display_slot+='<td>'+value.lt_TimeMaster+'</td>';	
				}
			}
		  display_slot+='</tr></tbody></table></td></tbody></tr></table>';
		 }
		 display_slot+='';
		 //alert(display_slot);
		 
		 $(".display_time_slot_approval").html(display_slot);
	 }
    });
		//return false;
		  });	
		/*$(".add_branch").on("click",function(){
		var val_cal_id=$(this).attr('id');
		alert(val_cal_id);
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 $.ajax({
     type: "GET",
     url: "./call_from_ajax",
     data: {"ajax_mode": "new_to_add_calen", "calen_id" : val_cal_id,_token: CSRF_TOKEN},
     dataType: "html",
     success: function(data){
		 alert(data);
	 }
	});
	});*/
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
		

	$("#approve_id").on("click",function(){
		var territory_id_app     = $("#territory_id_from_approval").val(); 
		//var calendar_id_app      = $(".timeslot_approval_view").attr('data-subject');
		var calendar_id_app      = $("#calendar_id_from_approval").val();
		var calendar_terr_id     = $("#calendar_terr_id_from_approval").val();
		//var territory_id_app       = $(".timeslot_approval_view").attr('data-level');
		
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			 
		 $.ajax({
		 type: "GET",
		 url: "./call_from_ajax",
		 data: {"ajax_mode": "change_to_approve",'calendar_id_app':calendar_id_app,'territory_id':territory_id_app,'calendar_terr_id':calendar_terr_id,'form_submit':'Approve',_token: CSRF_TOKEN},
		 dataType: "html",
		 success: function(data){
			$('#alert_msg').html('<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>This Calendar is in Approved Status</div>');
		 }
		 });
		  $('#approve_id').attr('disabled','disabled');
	});
	$("#reject_id").on("click",function(){
		var territory_id_from_appr = $("#territory_id_from_approval").val();
		//alert(territory_id_from_appr);
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			 
		 $.ajax({
		 type: "GET",
		 url: "./call_from_ajax",
		 data: {"ajax_mode": "change_to_reject",'territory_id':territory_id_from_appr,_token: CSRF_TOKEN},
		 dataType: "html",
		 success: function(data){
		 $('#alert_msg').html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>This Calendar is in Rejected Status</div>');
		 }
		 });
	});
	$("#pending_id").on("click",function(){
		var territory_id_from_appr = $("#territory_id_from_approval").val();
		//alert(territory_id_from_appr);
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			 
		 $.ajax({
		 type: "GET",
		 url: "./call_from_ajax",
		 data: {"ajax_mode": "change_to_pending",'territory_id':territory_id_from_appr,_token: CSRF_TOKEN},
		 dataType: "html",
		 success: function(data){
			 $('#alert_msg').html('<div class="alert alert-warning alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>This Calendar is in Pending Status</div>');
		 }
		 });
	});
	});
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

 <!-- Small modal -->
                 

                  
                  <!-- /modals -->
       <!-- <div class="right_col" role="main">-->
	   
		  <div align="right">
           <a id="new" href="add_calendar" class="btn btn-info btn-sm">Create New Calender</a>
		   </div>
           <meta name="csrf-token" content="{{ csrf_token() }}" />
            <div class="clearfix"></div>

           
        <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Calendar Name</th>
                          <th>Completed Status</th>
                          <th>List Time Slot</th>
						  <th>Status</th>
                          
                          <th>Territory Name</th>
                          <th>Lock Status</th>
                         
						  <th>Action</th>
                          <th>More</th>
						  <th>More</th>
                        </tr>
                      </thead>
                      <tbody>
					
						@for($i=0;$i<count($existing_calendar_data);$i++)
							 <tr>
                          <td>{{$existing_calendar_data[$i]['lc_CalendarName']}}</td>
                          <td>@if($existing_calendar_data[$i]['lct_ApproveStatus']=='Approve'){{"completed"}}
						      @else
							  {{"Incomplete"}}
						      @endIf
						  </td>
                          <td> 
						  
						  <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg" class="timeslot_view" id="{{$existing_calendar_data[$i]['lc_CalendarId']}}">Timeslot View</a></td>
						  <td>Active</td>
                         
                          <td>{{$existing_calendar_data[$i]['lb_TerritoryName']}}</td>
                          <td>Open</td>
                          <!-- <td> 
						 					  
						  <a href="{{ URL::to('add_calendar/'.$existing_calendar_data[$i]['lmsc_calendar_id']) }}" onclick=" return confirm('Are you sure you want to edit this?')">Add New Branches</a>
						  </td>-->
						  <td>
						  
						  @if($existing_calendar_data[$i]['lct_ApproveStatus']=='Approve')
						  <a href="{{ URL::to('add_calendar/'.$existing_calendar_data[$i]['lc_CalendarId']) }}" onclick=" return confirm('Are you sure you want to edit this?')">Edit</a>
                          @else
					      <a href="#"  data-toggle="modal" data-target=".bs-example-modal-sm" class="timeslot_approval_view" id="{{$existing_calendar_data[$i]['lc_CalendarId']}}" name="{{$existing_calendar_data[$i]['lct_TerritoryId']}}" data-calendar_terr_id="{{$existing_calendar_data[$i]['lct_CalendarTerritoryId']}}" data-level="{{$existing_calendar_data[$i]['lct_TerritoryId']}}" >Approval</a>
						  @endIf
						  
						  </td>
                          <td>We have to add more </td>
						  <td>We have to add more </td>
                        </tr>
						@endFor
                        
						
                      
                       
                       
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
    
	 <!-- Small modal -->
                  

                  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Appointment Calendar</h4>
                        </div>
                        <div class="modal-body">
                        <div id="alert_msg"></div>
						  <div class="display_time_slot_approval"></div> 
						  <input type="hidden" value="" name="territory_id_from_approval" id="territory_id_from_approval">
						  <input type="hidden" value="" name="calendar_id_from_approval" id="calendar_id_from_approval">
						  <input type="hidden" value="" name="calendar_terr_id_from_approval" id="calendar_terr_id_from_approval">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id="approve_id">Approve</button>
						  <button type="button" class="btn btn-primary" id="reject_id">Reject</button>
						  <button type="button" class="btn btn-primary" id="pending_id">Pending</button>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- /modals -->  
@endsection		  
  
