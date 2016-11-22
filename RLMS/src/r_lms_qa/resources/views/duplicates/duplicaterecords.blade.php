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
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="width:1000px;padding:40px;">
           <div style="float: left">
             @for($i=1;$i<=8;$i++)
                    <div style="width:180px;height:60px;margin-left:18px;margin-top: 12px;font-size: 15px;"><a href="{{ url('Territory') }}">Territory{{$i}}</a><?php echo('[<b>'.rand(10,99).'</b>]'); ?></div>
             @endfor
           </div>
           <div style="float: left">
             @for($i=9;$i<=16;$i++)
                    <div style="width:180px;height:60px;margin-top: 12px;font-size: 15px;"><a href="{{ url('Territory') }}">Territory{{$i}}</a><?php echo('[<b>'.rand(10,99).'</b>]'); ?></div>
             @endfor

           </div>
           <div style="float: left">
             @for($i=17;$i<=24;$i++)
                    <div style="width:180px;height:60px;margin-top: 12px;font-size: 15px;"><a href="{{ url('Territory') }}">Territory{{$i}}</a><?php echo('[<b>'.rand(10,99).'</b>]
                    .





                    '); ?></div>
             @endfor
           </div>
           <div style="float: left">
             @for($i=25;$i<=32;$i++)
                    <div style="width:180px;height:60px;margin-top: 12px;font-size: 15px;"><a href="{{ url('Territory') }}">Territory{{$i}}</a><?php echo('[<b>'.rand(10,99).'</b>]'); ?></div>
             @endfor
           </div>
           <div style="float: left">
             @for($i=33;$i<=40;$i++)
                    <div style="width:180px;height:60px;margin-top: 12px;font-size: 15px;"><a href="{{ url('Territory') }}">Territory{{$i}}</a><?php echo('[<b>'.rand(10,99).'</b>]'); ?></div>
             @endfor
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
                          <h4 class="modal-title" id="myModalLabel2">Terrtiritoies lookup</h4>
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
  
