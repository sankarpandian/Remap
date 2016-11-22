<!DOCTYPE html>

<head>
<link href="{!! asset('assets/bootstrap/dist/css/bootstrap.min.css') !!}" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="{!! asset('assets/fontawesome/css/font-awesome.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('assets/css/animate.min.css') !!}" media="all" rel="stylesheet" type="text/css" />


<!--<script src="{!! asset('assets/js/jquery.min.js') !!}"></script>
<script src="{!! asset('assets/bootstrap/js/jquery.validate.min.js') !!}"></script>
<script src="{!! asset('assets/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('assets/bootstrap/js/ValidationFormScript.js') !!}"></script>
<title>bootstrap login validation demo</title>
</head>
<body>
<div class="container">
<h1 class="text-center">bootstrap login validation demo</h1>
<div class="jquery-script-ads text-center"><script type="text/javascript"><!--
google_ad_client = "ca-pub-2783044520727903";
/* jQuery_demo */
google_ad_slot = "2780937993";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
<form class="form-horizontal" id="form1">
  <fieldset>
    
    <!-- Form Name -->
    <legend>
    <center>
      Validation Form
    </center>
    </legend>
    
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="Email">Email</label>
      <div class="col-md-3">
        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
          <input id="Email" name="Email" type="text" placeholder="Enter Your Email" class="form-control input-md">
        </div>
      </div>
    </div>
    
    <!-- Password input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="Password">Password</label>
      <div class="col-md-3">
        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
          <input id="password" name="password" type="password" placeholder="Enter Your Password" class="form-control input-md">
        </div>
      </div>
    </div>
    
    <!-- Password input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="ConfirmPassword">Confirm Password</label>
      <div class="col-md-3">
        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
          <input id="password_again" name="password_again" type="password" placeholder="Enter Your Password Again" class="form-control input-md">
        </div>
      </div>
    </div>
    
    <!-- Button -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="Submit"></label>
      <div class="col-md-4">
        <button id="Submit" class="btn btn-success" type="Submit">Press To Validate</button>
      </div>
    </div>
  </fieldset>
</form>
</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>