$("document").ready(function()
{
	$('#home_phone').blur(function(){
		var homephone       = $(this).val();
		//alert(homephone);
		var lld_CustomerId ="";
		lld_CustomerId  = $('#lld_CustomerId').val();
		var CSRF_TOKEN      = $('meta[name="csrf-token"]').attr('content');
		//alert(lld_CustomerId);
		if(lld_CustomerId!='')
		var ajax_data = {"ajax_mode":"otherBucketHomephone","homephone":homephone,'lld_CustomerId': lld_CustomerId,_token:CSRF_TOKEN};	
	    else
		{
		var ajax_data = {"ajax_mode":"inboundHomephone","homephone":homephone,_token:CSRF_TOKEN};		
		}
			$.ajax({
			type: "GET",
			url: "./dup_homephone",
			data:ajax_data,
			dataType: "html",
			async:false,
			success: function(data)
			{
				if(data>0)
				{
				 alert('Home phone is aldready exist');
				 $('#home_phone').val(' ');
				// $('#home_phone').focus();
				 
				}
				return false;
			}
			});  
		});
});
