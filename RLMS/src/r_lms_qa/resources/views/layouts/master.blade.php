<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Remap LMS</title>

    <!-- Bootstrap -->
    <link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	 <!-- Parsley 
    <script src="{{ URL::asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>-->
    <!-- bootstrap-wysiwyg -->
    <link href="{{ URL::asset('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
<!-- Used for check list -->
    <link href="{{ URL::asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('build/css/custom.min.css') }}" rel="stylesheet">
	
	<link rel="stylesheet" href="{{ URL::asset('assets/fancybox/source/jquery.fancybox.css')}}" type="text/css" media="screen" />
	
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
   
   <!-- Bootstrap for data table -->
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
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title navbar-fixed-top" style="border: 0;border-bottom: 1px solid #1BC3D4;">
              <a href="{{ URL::asset('/')}}" class="site_title"><i class="fa fa-paw"></i> <span>Remap LMS</span></a>
            </div>

            <div class="clearfix"></div>
            
			<!-- menu profile quick info -->
			@include('layouts.header')
			<!-- /menu profile quick info -->
			
            <!-- sidebar menu -->
            @include('layouts.side_left_panel')
            <!-- /sidebar menu -->
		   
            <!-- /menu footer buttons -->
            @include('layouts.footer_sidebar')
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
       @include('layouts.top_navigation')
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="page-title">
              <!--------- Content page--------------- -->
		
			  <!--------- End Title Content page--------------- -->
            </div>

            <div class="clearfix"></div>

            <div class="row">
			
              <div class="col-md-12">
			     
              <div  class="col-md-6">   <h2 >{{ isset($title) || $title != '' ? $title : 'Welcome to Remap LMS' }}</h2>
												</div>  <div  class="col-md-6 ">
												<ol class = "breadcrumb  pull-right ">
												<li><a href = "#">Home</a></li>
												<li class = "active">{{ isset($title) || $title!='' ? $title : 'Welcome to RemapLMS' }} </li>
												</ol></div>
				<!---------------------- Content to render --------------- -->
                 <!-- <div class="x_title">
                    <h2>{{ isset($title) || $title != '' ? $title : 'Welcome to Remap LMS' }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div> -->
            </div> 
				@yield('content')
				<!---------------------- End Content to render --------------- -->
              
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       @include('layouts.footer')
        <!-- /footer content -->
      </div>
    </div>
 <!-- Default Js scripts Include -->
 
<!-- jQuery -->
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- Bootstrap text editor -->
	<script src="{{URL::asset('assets/texteditor/editor.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ URL::asset('vendors/nprogress/nprogress.js') }}"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="{{ URL::asset('vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script src="{{ URL::asset('vendors/google-code-prettify/src/prettify.js') }}"></script>
    <!-- jQuery Smart Wizard -->
    <script src="{{ URL::asset('vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('assets/fancybox/source/jquery.fancybox.pack.js')}}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ URL::asset('build/js/custom.min.js') }}"></script>

    <!-- jquery.inputmask -->
    <script src="{{ URL::asset('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>

	<!-- Used for check list -->
	 <script src="{{ URL::asset('vendors/iCheck/icheck.min.js') }}"></script>
	
    <!-- bootstrap-wysiwyg -->
    <script>
      $(document).ready(function() {
	 $(".stepContainer").removeAttr('style');	
     //  alert('test');
	  
         $(":input").inputmask();
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editor').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editor').wysiwyg({
          fileUploadError: showErrorAlert
        });

        prettyPrint();
	
  <!-- jQuery Smart Wizard -->	
		 $('#wizard').smartWizard();

        $('.buttonNext').addClass('btn btn-success');
        $('.buttonPrevious').addClass('btn btn-primary');
        $('.buttonFinish').addClass('btn btn-default');
		
	 <!-- /jQuery Smart Wizard -->		
		
      });
	  
	  var themes = {
    "default":"{{ URL::asset('build/css/custom.min.css') }}",		  
    "cerulean": "{{ URL::asset('build/css/custom.min-cerulean.css') }}",
	"flatly": "{{ URL::asset('build/css/custom.min-flatly.css') }}",
	"cyborg": "{{ URL::asset('build/css/custom.min-meru.css') }}",
	"cosmo": "{{ URL::asset('build/css/custom.min-cosmo.css') }}",
	"journal": "{{ URL::asset('build/css/custom.min-pink.css') }}"	
}
$(function(){
   var themesheet = $('<link href="'+themes['default']+'" rel="stylesheet" />');
 //  var themesheet_body = $('<link href="'+themes['default_body']+'" rel="stylesheet" />');
    themesheet.appendTo('head');
	//themesheet_body.appendTo('head');
    $('.theme-link').click(function(){
       var themeurl = themes[$(this).attr('data-theme')]; 
	 //   var themeurl_body = themes[$(this).attr('data-theme_body')]; 
	  // alert(themeurl);
        themesheet.attr('href',themeurl);
	//	themesheet_body.attr('href',themeurl_body);
    });
});
	  
    </script>
	<!-- /bootstrap-wysiwyg -->
  <!-- End Default Js scripts Include -->
  
  
  
  </body>
</html>