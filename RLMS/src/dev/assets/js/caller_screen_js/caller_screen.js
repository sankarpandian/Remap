$("document").ready(function()
{
	
	
	
	 $("#call_from").on("change",function()
	{
		//$("div#isp_info_container").hide();
		//$("div#customer_present_container").hide();

		var call_from_id 	= $.trim( $("#call_from").val() ); 
		
		
		if( $("#call_from").is("select") )
		{
			//case - element is 'select' 
			var call_from 		= $.trim( $("#call_from option:selected").attr("code") ); //$("#list option:selected").text();
		}
		else
		{
			//case - element is 'input' 
			var call_from 		= $.trim( $("#call_from").attr("code") ); //$("#list option:selected").text();
		}

		//alert_msg(call_from);
		if( call_from == "Media" )
		{
			//Case - call from internet or other
			$("div#caller_type_container").hide();
			$("div#associate_info_container").hide();
			$("div#customer_info_container").hide();
		}
		else
		{
			//Case for HD/SC
			if(call_from == "SC")
			{
				// enable auto coomplete
				//$('#associate_id').autocomplete( "enable" );							
				
				//Call from SC
				$("div#caller_type_container").hide();
				$("div#associate_info_container").show();
				$("div#customer_info_container").hide();
				$("div#customer_present_container").show();
			}
			else if(call_from == "HD-Associate" || call_from == "Store")
			{
				// disable auto coomplete
				//$('#associate_id').autocomplete( "disable" );
				
				//Call from HD
				$("div#caller_type_container").show();
				$("div#associate_info_container").hide();
				$("div#customer_info_container").hide();
			}
			else
			{
				//Case - call from internet or other
				$("div#caller_type_container").hide();
				$("div#associate_info_container").hide();
				$("div#customer_info_container").hide();
			}
		}
	
		//Ajax to get the description of the Call from HD/SC/Internet/Other
		if(call_from != "")
		{
			//alert(call_from);
			//$("#call_from").attr("disabled", true);
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$.ajax({
			   type: "GET",
			   url: "./call_from_ajax",
			   data: {"ajax_mode": "get_call_desc_list", "call_from" : call_from, "ivr_service" : "fail",_token: CSRF_TOKEN},
			   dataType: "json",
			   beforeSend: function(){
					$("select#call_desc_container").html("Loading, the description...").show();			   
			   },
			   success: function(data){
			   var getresult='';
			  // alert(data.length);
			  //  getresult += '<select class="form-control" name="dnis_info" id="dnis_info" >';
                for(var i=0;i<data.length;i++)			
				{
					getresult += '<option id="" value="D'+data[i].mrd_ProspectId+'" desc="'+data[i].mrd_Description+'" dnis="'+data[i].mrd_Dnis+'" companycode="'+data[i].mrd_CompanyCode+'" prospectid="'+data[i].mrd_ProspectId+'">'+data[i].mrd_Description+'</option>';	
				}
				//getresult += '</select>';
				//alert(getresult)
				   $("select.call_desc_container").html(getresult).show();
				   $("#call_from").attr("disabled", false);
				  // $("#dnis_info").attr('class','form-control');
				   //auto seleect description for SMart circle
				   if($("#call_from").val() == '2')
				   {
				   	$("#dnis_info").val('DSA');
				   }
			   }
			});
		}
		else
		{
			$("select.call_desc_container").html('').hide();
		}
		
	});
	
	$('#associate_id').focus(function() 
	{
		$(this).select();
	});
		//Script to change HD customer / associate
	$("#hd_type_id").change(function(){
		$("div#customer_present_container").hide();
		if( parseInt( $("#call_from").val() ) == 2 )
		{
			//Case to display Please put the customer in line //case - SC
			$("div#customer_present_container").show();
		}
		
		var hd_type_id = $.trim( $(this).val() );
		if( hd_type_id != "" )
		{
			if(hd_type_id == 1)
			{
				//Case - customer
				$("div#associate_info_container").hide();
				$("div#customer_info_container").hide();
				
			}
			else if(hd_type_id == 2)
			{
				//Case - associate
				$("div#associate_info_container").show();
				$("div#customer_info_container").show();
				$("input:radio[name='customer_present']").trigger("change");
			}
		}
		else
		{
			//nothing selected in hd type
//				$("div#associate_info_container").hide();
//				$("div#customer_info_container").hide();
		}
		
	
		
		
		
		
		
	});
	$("#hd_type_id").trigger("change");
  /* if( $("input#prospectId").val().search("DRG") != -1 )
	{
		//alert_msg("onload display the isp scripts");
		//Case - if prospect id starts with DRG
		//Case to display the isp scripts
		$("div#isp_info_container").show();
		$("div#customer_info_container").show();
		$("div#caller_type_container").remove();
		$("div#associate_info_container").remove();

	}
	else
	{
		//alert_msg("test");
		//To trigger out the call frm change func
		//$("#call_from").trigger("change");
	}
*/
function store_number_valid(store_no)
	{
		store_result = '0';
		if(store_no != '')
		{
			$.ajax({
			   type: "POST",
			   url: "ajax_process.php",
			   data: {"ajax_mode": "validate_storeno", "store_no" : store_no},
			   dataType: "html",
			   async:false,
			   success: function(data)
			   {
				    if(data == 'failure')
					{
						store_result = '1';
					}
			   }
			});
			return store_result;
		}
	}
	
	
/*----------------------------------Product Slide JS-----------------------*/
//Script to show out the content
	$("select#product").on("change", function(){
		//alert("check");
		var product_value = $.trim( $("select#product").val() ); 
		var product_name  = $.trim( $("select#product option:selected").text() );
		$("div.product_content").hide();
		//hide nonproduct status at first time 
		$("table#non_product_container").hide();			
		$("tr.non_product").show();
		$("input:radio[name='non_product_status']").prop({ 'checked' : false });
	
		if(product_value == "")
		{
			product_name = "Not Available";
		}
		else
		{
			$("input:checkbox[name='product_mode']").prop("checked", false);
			switch(product_value)
			{
				case "K":
					 $("div#kitchen").show();
				break;
				case "B":
					 $("div#bath").show();
				break;
				case "G":
					 $("div#garage").show();				
				break;
				case "O":
					 $("div#closet").show();				
				break;
				case "R":
					 $("div#bathremodeling").show();				
				break;
			}
			
		}
		$("span.product_update").html("<strong>"+product_name+"</strong>");

	});
	
	
	// For Product slide
	
   $("input:checkbox[name='product_mode']").change(function(){
	  	var root 			= this;
		var current_mode 	= $(root).prop("checked");
		var group 			= "input:checkbox[name='"+$(root).attr("name")+"']";
		$(group).prop("checked",false);
		$(root).prop("checked", current_mode);
		if(current_mode)
		{
			//If checked change product to null
			$("select#product").val('');
			$("select#product").trigger('change');
		}
		
		//Cases to hide/show nonproduct display
		if( $("input:checkbox#nonproduct").is(":checked") )
		{
			//nonproduct is selected
			//$("table#non_product_container").show();	
			//$("tr.non_product").hide();
			$("#non_product_container").show();
		}
		else
		{
			//nonproduct is not selected
			//$("table#non_product_container").hide();			
			//$("tr.non_product").show();
			$("#non_product_container").hide();	
			$("input:radio[name='non_product_status']").prop({ 'checked' : false });
		}

		//Case - to display an alert for oot
//		if( $("input:checkbox#oot").is(":checked") )
//		{
//			if( $("select#product").length == 0 )
//			{
//				alert_msg("Please re-enter another zipcode to check availability");
//				$('#zipcode12').focus();
//				$("input:checkbox#oot").prop("checked", false );
//			}
//		}
	});


$("select#dnis_info").on("change", function(){
	//alert('hihi');
		var root 		= this;
		var desc_val 	= $.trim( $(root).val() );
		//alert(desc_val);
		var call_from	= $.trim( $("select#call_from").val() );
		if( parseInt(call_from) == 1  ||  parseInt(call_from) == 4) //Call from "HD"
		{
			if(desc_val == "DRG")
			{
				//alert_msg("display the isp scripts");
				//Case to display the isp scripts
				$("div#isp_info_container").show();
				$("div#customer_info_container").show();
				$("div#caller_type_container").hide();
				$("div#associate_info_container").hide();
	
			}
			else
			{
				
				//alert_msg("not to display");
				//Case to hide the isp scripts
				//$("div#isp_info_container").hide();
				$("div#isp_info_container").hide();
				$("div#caller_type_container").show();
				$("div#customer_info_container").hide();
				$("#hd_type_id").trigger("change");
//				$("div#associate_info_container").hide();
			}
		}
		else
		{
			$("div#isp_info_container").hide();
		}
	});	
	
	
});
function specialchar(v,s)
{
	
	var iChars = "\\\~`!@#$%^*()=+[]{}|;:'\"<>?";
	for (var i = 0; i < v.length; i++) 
	{
		if (iChars.indexOf(v.charAt(i)) != -1) 
		{
			alert_msg(s+" contains special characters.<br/><br/>The following special characters are not allowed.<br/>~ ` ! @ # $ % ^ * ( ) = + [ ] { } | ; : ' \" < > ? \\ <br/>Please remove them and try again");
			return false;
		}
	}
}  