@extends('layouts.master')

@section('content')

  <script src="{{ URL::asset('assets/datePicker/jquery-1.12.4.js') }}"></script>
  <script src="{{ URL::asset('assets/datePicker/1.12.0/jquery-ui.js')}}"></script>
  <link rel="stylesheet" href="{{ URL::asset('assets/datePicker/jquery-ui.css') }}" type="text/css" media="screen" />
  <script>
  jQuery(document).ready(function($){ 
    
     $('a').click(function(e){
     
      alert(id);
      e.preventDefault();
      alert("click");
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
     type: "GET",
     url: "/ajax_skip_lead",
    
     data:{"id":id,_token:CSRF_TOKEN},
     dataType: "json",
     success: function(data){ 
      alert(data);
      
      $(ProsepctId).html("");
      $(Name).html("");
      $(HomePhone).html("");
      $(WorkPhone).html("");
      $(Territory).html("");
      $(ProductName).html("");
      $(PreviousStatus).html("");
      $(Messages).html("");
      $(Comments).html("");

     // alert(data.lcd_FirstName);
      $("#ProsepctId").text(data.lcd_FirstName+" "+data.lld_ProsepctId);
      $("#Name").text(data.lcd_FirstName+" "+data.lcd_LastName);
      $("#HomePhone").text(data.lcd_HomePhone);
      $("#WorkPhone").text(data.lcd_WorkPhone);
      $("#Territory").text(data.lb_TerritoryName);
      $("#ProductName").text(data.lp_ProductName);
      $("#PreviousStatus").text(data.lcd_FirstName);
      $("#Messages").text(data.lcd_FirstName);
      $("#Comments").text(data.lcd_Comments);
      }
   
  // 
   });
      //}
      });
$("#add_comment").on('click', function() {
alert("click");

var comment = document.getElementById('comment').value;
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
     type: "GET",
     url: "/ajax_comment",
    
     data:{"comment":comment,"id":id,_token:CSRF_TOKEN},
     dataType: "json",
     success: function(data){ 
      alert(data.lcd_Comments);
      $(Comments).html("");
      $("#Comments").text(data.lcd_Comments);
      }
   
  // 
   });
  });
    });
  </script>
      
<style>
table {
    border-collapse: collapse;
   
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
.col-md-4
{
	width:50% !important;
}
tr, td.border_bottom td {
    border-bottom:1pt solid black !important;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
{
	border:1px solid #ddd;
}
.centered {

  top: 100%;
  left: 50%;
  transform: translate(-50%, -0%);
}

#colmd6 {
margin:0px;
border:1px solid #ddd;
padding:10px;	
height:50px;	
}


</style>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
				  <div class="panel-group">
		 @if(count($customer_details)>0)		  
				  
      <div class="panel panel-default col-lg-7 col-offset-6 centered" style="padding: 0px;">
      <div class="panel-heading">Lead Source {{$customer_details['lld_Source']}}</div>
      <div class="panel-body">
	  
	  <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">Customer Name
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6">                         
		{{$customer_details['lcd_FirstName']}}&nbsp; {{$customer_details['lcd_LastName']}}
		</div>
	 </div>	 
	 	 <div style="clear:both;"></div>
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">Home Phone
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6">                         
		{{$customer_details['lcd_HomePhone']}}
		</div>
	 </div>
	 	 <div style="clear:both;"></div>
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">Work Phone
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6">                         
		{{$customer_details['lcd_WorkPhone']}}
		</div>
	 </div>
	 	 <div style="clear:both;"></div>
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">Territory
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6">                         
		{{$customer_details['lb_TerritoryName']}}
		</div>
	 </div>
	 	 <div style="clear:both;"></div>
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">Product
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6">                         
		{{$customer_details['lp_ProductName']}}
		</div>
	 </div>
	 	 <div style="clear:both;"></div>
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">Previous Status
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6">                         
		{{$customer_details['lld_Source']}}
		</div>
	 </div>
	 <div style="clear:both;"></div>
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6"  for="first-name">Messages
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6" >                         
		{{$customer_details['lld_Source']}}
		</div>
	 </div>
	 	 <div style="clear:both;"></div>
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">Comments
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6">                         
		test
		</div>
	 </div>
	 	 <div style="clear:both;"></div>
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">Add Comments
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6" style="padding-top:0px; padding-bottom:0px;">                         
		<textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
		</div>
	 </div>
	 	 <div style="clear:both;"></div>
	 <div class="form-group">
	 <label class="control-label col-sm-3 col-xs-12"  for="first-name">
		</label>
	    <div class="col-md-12 col-sm-5 col-xs-12" style="text-align:center; padding:10px;">  
        <form action="Rescheduleoutboundscriptflow" method="POST" >	
		  <input type="hidden" name="CustomerId" value="{{$customer_details['lcd_CustomerId']}}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">		
		  <input type="submit" name="submit" value="Live Customer" >
		</form>
		</div>
	 </div>
	  
	  
	 <div class="form-group">
		<label class="control-label col-md-6 col-sm-3 col-xs-12" id="colmd6" for="first-name">No Answer
		</label>
		<div class="col-md-6 col-sm-5 col-xs-12" id="colmd6">                         
		<select name="lcd_CPTitle" id="	" class="form-control col-md-10" style="float: left;">
			<option value="">Select One</option>
			
		</select>
		</div>
	 </div>
	  
	  
	  </div>
    </div>
    @else
	<div class="form-group">
		
		<label class="control-label col-md-12 col-sm-3 col-xs-12" id="colmd6" for="first-name">                      
		    No leads Available
		</label>
	 </div>	
    @endIf
    </div>
  </div>
</div>
                 
                </div>	
             
@endsection	