<!DOCTYPE html>
<html class=""> 
<head>
    <!-- Page Title -->
    <title>TooDrinks | AdminWeb</title>
    
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Travelo - Travel, Tour Booking HTML5 Template">
    <meta name="author" content="SoapTheme">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    
   <!-- Theme Styles -->
    {!! Html::style('bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('font-awesome/css/font-awesome.min.css') !!}
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,200,300,500' rel='stylesheet' type='text/css'>
    {!! Html::style('templateFrontend/css/animate.min.css') !!}>
    
     <!-- Main Style -->
    {!! Html::style('templateFrontend/css/style.css') !!}
    
    <!-- Updated Styles -->
    {!! Html::style('templateFrontend/css/updates.css') !!}

    <!-- Custom Styles -->
    {!! Html::style('templateFrontend/css/custom.css') !!}
    
    <!-- Responsive Styles -->
    {!! Html::style('templateFrontend/css/responsive.css') !!}
</head>
<body class="soap-login-page style2 body-blank">
    <div id="page-wrapper" class="wrapper-blank">
        <section id="content">
            <div class="container">
                <div id="main">
                    <h1 class="logo block">
                        <a href="#" title="TooDrinks - home">
                            <img src="{{ asset('templateFrontend/images/logo.png')}}" alt="TooDrinks" />
                        </a>
                    </h1>
                    
                    @if (Session::has('msj'))
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 alert alert-error">
                                <strong><h4>{{Session::get('msj')}}</h4></strong>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    @endif

                    <div class="welcome-text block">¡Bienvenido!</div>

                    <div class="col-sm-10 col-md-8 col-lg-6 no-float no-padding center-block block">
                        <form class="login-form" method="POST" action="{{ route('admin.loggear') }}">
                            {{ csrf_field() }}
                            <div class="form-group input-login">
                                <label>Usuario</label>
                                <input type="text" class="input-text input-large full-width" name="username">
                            </div>
                            <div class="form-group input-password">
                                <label>Clave</label>
                                <input type="password" class="input-text input-large full-width" name="password">
                            </div>
                            <button type="submit" class="btn-large full-width yellow">
                                INICIAR SESIÓN
                                <i class="soap-icon-check circle"></i>
                            </button>
                        </form>
                    </div>
                    <div class="copyright">
                        <p>&copy; 2017 TooDrinks</p>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Javascript -->
    {!! Html::script('templateFrontend/js/jquery-1.11.1.min.js') !!}
    {!! Html::script('templateFrontend/js/jquery.noconflict.js') !!}
    {!! Html::script('templateFrontend/js/modernizr.2.7.1.min.js') !!}
    {!! Html::script('templateFrontend/js/jquery-migrate-1.2.1.min.js') !!}
    {!! Html::script('templateFrontend/js/jquery.placeholder.js') !!}
    {!! Html::script('templateFrontend/js/jquery-ui.1.10.4.min.js') !!}
    
    <!-- Twitter Bootstrap -->
    {!! Html::script('bootstrap/js/bootstrap.js') !!}
    
    <!-- parallax -->
    {!! Html::script('templateFrontend/js/jquery.stellar.min.js') !!}
    
    <!-- waypoint -->
    {!! Html::script('templateFrontend/js/waypoints.min.js') !!}

    <!-- load page Javascript -->
    {!! Html::script('templateFrontend/js/theme-scripts.js') !!}
    {!! Html::script('templateFrontend/js/scripts.js') !!}
</body>
</html>

