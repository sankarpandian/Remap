 <select class="form-control" name="states" id="state">
                         
                    {{--$selected1=$geostate--}}
                    @foreach ($states as $state) {

               {{-- $get_state=$state->state_name--}}
               {{-- $get_stateId=$state->state_id--}}
                if ($selected1==trim($get_state))
                      {
                       {{--$selected="selected"--}}
                      }else
                      {
                         {{--$selected=""--}}
                      } 

                     
              
             
             <option value="{{  $get_stateId.'_'.trim($get_state)}}"{{$selected}}>
             {{$get_state}}     
             </option>
           @endforeach     
      </select>
   </div> 
   <div id="city-sel">
      <select class="form-control" name="cities" id="city">
         <?php  
                   $selected1=$geocity;
                    foreach ($districts as $city) {
                       $get_city=$city->district_name;

                   if ($selected1==trim($get_city))
                      {
                       $selected="selected";
                      }else
                      {
                         $selected="";
                      } 
             ?>
             <option value="<?php echo trim($get_city)?>"<?php echo $selected;?>>
             <?php echo $get_city;?>
              
             </option>
       <?php
       }     
       ?>   
     </select>