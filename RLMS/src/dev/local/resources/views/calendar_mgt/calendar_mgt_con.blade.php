@extends('layouts.master')

@section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap -->
    <link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ URL::asset('vendors/iCheck/skins/flat/green.css') }}" rel="st	ylesheet">
    <!-- Datatables -->
    <link href="{{ URL::asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }}" rel="stylesheet">
 <!-- jQuery Tags Input -->
 
    <script>
    jQuery(document).ready(function($){ 

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
		
$("#lmsa_branch").on("change",function(){
		var week_id     = $("#week_id").val();
		var lmsa_branch = $("#lmsa_branch").val();
		var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
		var data_get    = {'ajax_mode':'weekly_requested_details','week_id':week_id,'lmsa_branch':lmsa_branch,'_token':CSRF_TOKEN}
		$.ajax({
			dataType:'json',
			data:data_get,
			type:'GET',
			url:'./call_from_ajax',
			success:function(data)
			{
			
				/*
				lmss_slot_id
				lmsb_branch_id
				lb_TerritoryId
				lmss_calen_product
				
				lmss_slot_status
				
				lmss_updated_date*/
				
				if(data.length>0)
				{
					for(var i=0;i<data.length;i++)
					{
						var j=i+1;
						$("#get_week_list").html('<tr><td>'+j+'</td><td>'+data[i].week_display+'</td><td>'+data[i].lss_SlotStatus+'</td><td>'+data[i].ls_UpdatedDate+'</td><td><form action="weekly_appoint" method="GET"><input type="hidden" name="slot" value="'+data[i].ls_SlotId+'"><input type="hidden" name="branch" value="'+data[i].lb_BranchId+'"><input type="hidden" name="territory" value="'+data[i].lb_TerritoryId+'"><input type="hidden" name="calen" value="'+data[i].ls_CalenProduct+'"><input type="submit" value="View" class="btn btn-info btn-xs"></form></td></tr>');
					}
				}
				else
				{
					$("#get_week_list").html('<tr><td>Weekly run request is empty</td></tr>');
				}	
				
			}
			
		});
	});
	
		$(document).on("click", ".view_calen",function() {
        var slot_id_get      = $(this).attr('data-slot');
		var branch_id_get    = $(this).attr('data-branch');
		var territory_id_get = $(this).attr('data-territory');
		var calendar_id_get  = $(this).attr('data-calendar_id');
		
		var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
		var data_get    = {'ajax_mode':'caledar_mgt_details','slot_id_get':slot_id_get,'branch_id_get':branch_id_get,'territory_id_get':territory_id_get,'calendar_id_get':calendar_id_get,'_token':CSRF_TOKEN}
		$.ajax({
			dataType:'json',
			data:data_get,
			type:'GET',
			url:'./weekly_appoint',
			success:function(data)
			{
				alert(data);
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
 
 <input type="hidden" id="week_id" name="week_id" value="{{$get_week_id[0]['lw_WeekId']}}" >
                            

                  
                  <!-- /modals -->
       <!-- <div class="right_col" role="main">-->
         
           <meta name="csrf-token" content="{{ csrf_token() }}" />
		   
            <div class="clearfix"></div>

           

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                    
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch Name</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <select class="select2_multiple" id="lmsa_branch" name="lmsa_branch" required="required">
                            <option value="">Choose option</option>
							@for($i=0;$i<count($get_all_branch);$i++)
							 <option value="{{$get_all_branch[$i]['lb_TerritoryId']}}">{{$get_all_branch[$i]['lb_TerritoryName']}}
						     </option>
							@endFor
                            
                          </select>
						 
                        </div>
                   </div>
					<br>
					<br>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Week</th>
                          <th>Dates</th>
                          <th>Status</th>
                          <th>Date</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                     <tbody id="get_week_list">
                        <tr>
                          <td>Week</td>
                          <td>Dates</td>
                          <td>Status</td>
                          <td>Date</td>
						  <td>Action</td>
                        </tr>
                       
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
            
       <!--   </div>-->
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
                          <h4 class="modal-title" id="myModalLabel2">Customer Lookup</h4>
                        </div>
                        <div class="modal-body">
                         
                         
						  
						  <div class="display_time_slot"> </div>
						  
						  
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
                          <h4 class="modal-title" id="myModalLabel2">Customer Information</h4>
                        </div>
                        <div class="modal-body">
                        <div id="alert_msg"></div>
						  <div class="display_time_slot_approval"></div> 
						  <input type="hidden" value="" name="territory_id_from_approval" id="territory_id_from_approval">
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
  
