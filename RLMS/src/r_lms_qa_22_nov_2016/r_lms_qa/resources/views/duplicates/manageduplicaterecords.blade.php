@extends('layouts.master')

@section('content')

    

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
         
           <meta name="csrf-token" content="{{ csrf_token() }}" />
            <div class="clearfix"></div>

           

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Customer Name</th>
                          <th>Product</th>
						              <th>Territory name</th>                        
                          <th>Home Phone</th>
  						            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                       <td>Sankara pandian</td>
                       <td>Cabinet Refacing</td>
                       <td> San Diego </td>
                       <td>(345) 345-3453</td>
                       <td><a href="{{ url('Update_dupes') }}">1 Possible Dupe(s)/0 Duplicate(s)</a></tr>
                      </tr>
                      <tr>
                       <td>Chistu Dasan</td>
                       <td>Garage Organization System</td>
                       <td> Atlanta Central </td>
                       <td>(121) 021-3645</td>
                       <td> 2 Possible Dupe(s)/0 Duplicate(s)</tr>
                      </tr>
                      <tr>
                       <td>Vivek Raj</td>
                       <td>Cabinet Refacing</td>
                       <td> Philadelphia  </td>
                       <td>(080) 165-5487</td>
                       <td>12 Possible Dupe(s)/3 Duplicate(s) </tr>
                      </tr>
                      <tr>
                       <td>Babu Kumar</td>
                       <td>Garage Organization System</td>
                       <td> San Francisco West </td>
                       <td>(889) 111-4596</td>
                       <td>5 Possible Dupe(s)/1 Duplicate(s) </tr>
                      </tr>
                      <tr>
                       <td>Praveen Kumar</td>
                       <td>Bathroom Refacing</td>
                       <td> San Diego </td>
                       <td>(234) 234-2342</td>
                       <td>30 Possible Dupe(s)/2 Duplicate(s) </tr>
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
  
