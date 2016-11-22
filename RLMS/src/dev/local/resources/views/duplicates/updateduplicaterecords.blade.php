 @extends('layouts.master')
 @section('content')
  
  <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>
  
  <script src="{{ URL::asset('assets/datePicker/jquery-1.12.4.js') }}"></script>
  <script src="{{ URL::asset('assets/datePicker/1.12.0/jquery-ui.js')}}"></script>
  <link rel="stylesheet" href="{{ URL::asset('assets/datePicker/jquery-ui.css') }}" type="text/css" media="screen" />

    <style type="text/css">

      .form-control
       {
          border-radius: 0;
              width: 129%;
       }
       .form-horizontal .control-label
       {
          padding-top: 8px;
          text-align: left;
              width: 100px;

       }

      .x_panel
       {
        position: relative;
        width: 102.4%;
       }
       .dup_value_div
       {
        margin-top: 9px;
       }

       fieldset
       {
        text-align: center;
        border: none;
        margin: 11px;
        padding: 0;
       }
       .dup_result
       {
        text-align: left;
       }
       .buttons
       {
             margin-left: 15px;
       }
       .dup_buttons
       {
            margin-left: 15px;
       }

    </style>
   
    <div class="row">
              <div class="clearfix"></div>
  {!! Form::open(['url' => '/dataentry_cusdetails1', 'method' => 'post', 'role' => 'form', 'class'=>'form-horizontal form-label-left', 'data-parsley-validate']) !!}   
<input type="hidden" id="lld_CallFromId" name="lld_CallFromId" value="@if(isset($lld_CallFromId)){{$lld_CallFromId}}@endIf" >

<input type="hidden" id="lld_AssociateId" name="lld_AssociateId" value="@if(isset($lld_AssociateId)){{$lld_AssociateId}}@endIf" >
<input type="hidden" id="lld_StoreId" name="lld_StoreId" value="@if(isset($lld_StoreId)){{$lld_StoreId}}@endIf" >
<input type="hidden" id="lld_ProsepctId" name="lld_ProsepctId" >
<input type="hidden" id="half_id" name="half_id" value="@if(isset($calldescription)){{$calldescription}}@endIf" >
<input type="hidden" id="territory_code" name="territory_code" >
  
<!--<form class="form-horizontal form-label-left input_mask" method="POST" action="dataentry_cusdetails1">-->
            <div class="row">
              <div class="col-md-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <br />
                    
                    
                    
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">First Name</label>
              <div class="col-md-6 col-sm-9 col-xs-12">
                  <input type="text" value="Sankar" class="form-control" id="lcd_FirstName" name="lcd_FirstName"  required  data-parsley-required-message="Please insert your name">
              </div>
          </div>
          
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name</label>
              <div class="col-md-6 col-sm-9 col-xs-12">
                  <input type="text" value="Pandian" class="form-control" id="lcd_LastName" name="lcd_LastName"  required data-parsley-pattern="^[A-Za-z]+((\s)?((\')?([A-Za-z])+))*$" data-parsley-pattern-message="Please fill a Valid Name" data-parsley-required-message="Please fill your Last Name" >
              </div>
          </div>

          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product</label>
                <div class="col-md-6 col-sm-9 col-xs-12">
                   <input type="text" value="Cabinet Refacing" class="form-control" id="lcd_FirstName" name="lcd_FirstName"  required  data-parsley-required-message="Please insert your name">
                </div>
          </div>

          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                <div class="col-md-6 col-sm-9 col-xs-12">
                  <input type="email" value ="852 W Main Lane" class="form-control" id="lcd_EmailAddress" name="lcd_EmailAddress"  data-parsley-type-message="Please fill a Valid Email">
                </div>
          </div>

          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                <div class="col-md-6 col-sm-9 col-xs-12">
                  <input type="email" value="Alaska" class="form-control" id="lcd_EmailAddress" name="lcd_EmailAddress"  data-parsley-type-message="Please fill a Valid Email">
                </div>
          </div>

          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                <div class="col-md-6 col-sm-9 col-xs-12">
                  <select name="lld_ProductCode" id="lld_ProductCode" class="form-control" required data-parsley-required-message="Please select Product" >
                    <option value="ATKA">ATKA</option>     
                  </select>
                </div>
          </div>

          
            
                    
                  </div>
                </div>

              </div>



              <div class="col-md-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <br />
                    
                    
                    
          <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode</label>
                 <div class="col-md-6 col-sm-6 col-xs-12">
                   <input type="text"  value="30123" class="form-control" id="lcd_Zipcode" name="lcd_Zipcode" required data-parsley-type="digits" data-parsley-length="[5, 5]" data-parsley-length-message ="Please fill 5 digit Zipcode" data-parsley-required-message="Please fill Zipcode">
                 </div>
          </div>

          <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12">Territory</label>
                   <div class="col-md-6 col-sm-9 col-xs-12">
                     <select name="lld_ProductCode"  id="lld_ProductCode" class="form-control" required data-parsley-required-message="Please select Product" >
                        <option value="AT">AT</option>
                     </select>
                   </div>
          </div>
          <div class="form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12">Media Code</label>
                     <div class="col-md-6 col-sm-9 col-xs-12">
                       <input type="text" value="DQ" name="lcd_Community" id="lcd_Community" class="form-control col-md-10" style="float: left;" />
                     </div>
          </div>

           <div class="form-group">
                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                       <div class="col-md-6 col-sm-9 col-xs-12">
                         <input type="text" value="sankar@nathanresearch.com"  name="lcd_HousecColor" id="lcd_HousecColor" class="form-control col-md-10" style="float: left;" />
                       </div>
          </div>
                      
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Home #</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <input type="text" value="(770) 698-8854" name="lcd_WorkPhone" id="lcd_WorkPhone" class="form-control col-md-10" style="float: left;"/>
                        </div>
          </div>

          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Work #</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">   
                        <input type="text"  value="(660) 590-5910" name="lcd_WorkPhone" id="lcd_WorkPhone" class="form-control col-md-10" style="float: left;"/>
                        </div>
          </div>
            
          
          

          </div>
                </div>

              </div>




              <div class="col-md-4 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left">

                      
                      
         
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Store #</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <input type="text" value="8938" class="form-control" id="lcd_FirstName" name="lcd_FirstName"  required  data-parsley-required-message="Please insert your name">
                        </div>
          </div>
          
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">HD Assoc ID</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <input type="text" value="12051" class="form-control" id="lcd_LastName" name="lcd_LastName"  required data-parsley-pattern="^[A-Za-z]+((\s)?((\')?([A-Za-z])+))*$" data-parsley-pattern-message="Please fill a Valid Name" data-parsley-required-message="Please fill your Last Name" >
                        </div>
          </div>

          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Comments</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                           <textarea class="resizable_textarea form-control" value="" name="lcd_Comments" id="lcd_Comments">REFACE ALREADY INSTALLED</textarea>
                        </div>
           </div>

           <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Record Created Date</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                           <div class="dup_result" style="margin-top: 10px;">2016-03-25 14:51:03</div>
                        </div>
            </div>          
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lead Status</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                           <div class="dup_result" style="margin-top: 10px;">Scheduled</div>
                        </div>
            </div>

            <div class="buttons">
            {{Form::submit('Save and Discard Duplicates', array('class' => 'btn btn-primary'))}}
            {{Form::submit('Cancel', array('class' => 'btn btn-primary'))}}   
            </div>    
            {!! Form::close() !!}




                  <!--  </form>-->
                  </div>
                </div>



              </div>










   
                  </div>


              <div class="row">
              <fieldset><legend><strong>Possible Dupe(s)</strong></legend>

              {!! Form::open(['url' => '/dataentry_cusdetails1', 'method' => 'post', 'role' => 'form', 'class'=>'form-horizontal form-label-left', 'data-parsley-validate']) !!}   
<input type="hidden" id="lld_CallFromId" name="lld_CallFromId" value="@if(isset($lld_CallFromId)){{$lld_CallFromId}}@endIf" >

<input type="hidden" id="lld_AssociateId" name="lld_AssociateId" value="@if(isset($lld_AssociateId)){{$lld_AssociateId}}@endIf" >
<input type="hidden" id="lld_StoreId" name="lld_StoreId" value="@if(isset($lld_StoreId)){{$lld_StoreId}}@endIf" >
<input type="hidden" id="lld_ProsepctId" name="lld_ProsepctId" >
<input type="hidden" id="half_id" name="half_id" value="@if(isset($calldescription)){{$calldescription}}@endIf" >
<input type="hidden" id="territory_code" name="territory_code" >
  
<!--<form class="form-horizontal form-label-left input_mask" method="POST" action="dataentry_cusdetails1">-->
            
              <div class="col-md-4 col-xs-12"> 
                <div class="x_panel">

                  <div class="x_content">
                    <br />
                    
                    
                    
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">First Name</label>
              <div class="dup_value_div">
                  <div class="dup_result">Sankar</div>
              </div>
          </div>
          
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name</label>
              <div class="dup_value_div">
                  <div class="dup_result">Pandian</div>
              </div>
          </div>

          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Product</label>
                <div class="dup_value_div">
                   <div class="dup_result">Cabinet Refacing</div>
                </div>
          </div>

          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                <div class="dup_value_div">
                    <div class="dup_result">852 W Main Lane</div>
                </div>
          </div>

          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                <div class="dup_value_div">
                    <div class="dup_result">Alaska</div>
                </div>
          </div>

          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                
                  <div class="dup_value_div">
                    <div class="dup_result">ATKA</div>
                 </div>
               
          </div>

          
            
                    
                  </div>
                </div>

              </div>

                  <div class="col-md-4 col-xs-12"> 
                <div class="x_panel">

                  <div class="x_content">
                    <br />
                    
                    
                    
         
          <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode</label>
                 <div class="dup_value_div">
                    <div class="dup_result">30123</div>
                 </div>
          </div>

          <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Territory</label>
                  <div class="dup_value_div">
                     <div class="dup_result">AT</div>
                  </div>
          </div>
          <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Media Code</label>
                  <div class="dup_value_div">
                      <div class="dup_result">DQ</div>
                  </div>
          </div>

          <div class="form-group">
                       <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                       <div class="dup_value_div">
                         <div class="dup_result">sankar@nathanresearch.com</div>
                       </div>
          </div>
                      
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Home #</label>
                        <div class="dup_value_div">
                          <div class="dup_result">(770) 698-8854</div>
                        </div>
          </div>
            
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Work #</label>
                        <div class="dup_value_div">   
                          <div class="dup_result">(660) 590-5910</div>
                        </div>
          </div>


                  </div>
                </div>

              </div>







              <div class="col-md-4 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left">

                      
                      
          

          
            
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Store #</label>
                        <div class="dup_value_div">
                          <div class="dup_result">8938</div>
                        </div>
          </div>
          
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">HD Assoc ID</label>
                        <div class="dup_value_div">
                           <div class="dup_result">12051</div>
                        </div>
          </div>

          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Comments</label>
                        <div class="dup_value_div">
                           <div class="dup_result">REFACE ALREADY INSTALLED</div> 
                        </div>
           </div>

           <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Record Created Date</label>
                        <div class="dup_value_div">
                           <div class="dup_result">2016-03-25 14:51:03</div>
                        </div>
            </div>          
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lead Status</label>
                        <div class="dup_value_div">
                           <div class="dup_result">Possible Dupe</div>
                        </div>
            </div>



            <div class="dup_buttons">
            {{Form::submit('Mark as Duplicate', array('class' => 'btn btn-primary'))}}
            {{Form::submit('Not a Duplicate', array('class' => 'btn btn-primary'))}}       
            </div>
            {!! Form::close() !!}
                  <!--  </form>-->


                  </div>
                </div>



              </div>






                </div>

              </div>
             
            </div>

         
          </div>
          </fieldset>
        </div>
        <!-- /page content -->

       </form>
      </div>
    </div>
    
  
    @endsection   
