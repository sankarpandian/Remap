
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="vendors/remap_images/NathanGroupPvtLtd_logo.png" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{!! asset('assets/bootstrap/dist/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/animate.min.css') !!}">

    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="{!! asset('build/css/main.min.css') !!}">
  </head>
  <body class="login">
    <div class="form-signin">
      <div class="text-center">
        <img src="{!! asset('vendors/remap_images/NathanGroupPvtLtd_logo.png') !!}" alt="Remap Logo">
      </div>
      <hr>
      <div class="tab-content">
        <div id="login" class="tab-pane active">
           {!! Form::open(['url' => '/home', 'method' => 'post', 'role' => 'form']) !!}
            <p class="text-muted text-center">
              {{ !isset($page) || $page != 'login' ? 'Enter username and Password' : $description }}
            </p>
			 <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="username" placeholder="Username" class="form-control top">
            <input type="password" name="password" placeholder="Password" class="form-control bottom">
            <div class="checkbox">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
            
           {{Form::submit('Login', array('class' => 'btn btn-lg btn-primary btn-block'))}}
            {!! Form::close() !!}
        </div>
        <div id="forgot" class="tab-pane">
          <form action="index.html">
            <p class="text-muted text-center">Enter your valid e-mail</p>
            <input type="email" placeholder="mail@domain.com" class="form-control">
            <br>
            <button class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
          </form>
        </div>
      </div>
      <hr>
      <div class="text-center">
        <ul class="list-inline">
          <li> <a class="text-muted" href="#login" data-toggle="tab">Login</a>  </li>
          <li> <a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a>  </li>
        </ul>
      </div>
    </div>

    <!--jQuery -->
    <script src="{!! asset('assets/js/jquery.min.js') !!}"></script>

    <!--Bootstrap -->
    <script src="{!! asset('bootstrap-3.3.6-dist/js/bootstrap.min.js') !!}"></script>
    <script type="text/javascript">
      (function($) {
        $(document).ready(function() {
          $('.list-inline li > a').click(function() {
            var activeForm = $(this).attr('href') + ' > form';
            //console.log(activeForm);
            $(activeForm).addClass('animated fadeIn');
            //set timer to 1 seconds, after that, unload the animate animation
            setTimeout(function() {
              $(activeForm).removeClass('animated fadeIn');
            }, 1000);
          });
        });
      })(jQuery);
    </script>
  </body>
</html>