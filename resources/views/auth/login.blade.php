<!DOCTYPE html>
<html class=""> <!--<![endif]-->
<head>
    <!-- Page Title -->
    <title>TooDrinks | Iniciar Sesión</title>
    
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

<body class="soap-login-page style3 body-blank">
    <div id="page-wrapper" class="wrapper-blank">
        <header id="header" class="navbar-static-top">
            <a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle blue-bg">Mobile Menu Toggle</a>
            <div class="container">
                <h1 class="logo">
                    
                </h1>
            </div>
            @include('frontend.plantillas.partes.menuMovil')
        </header>

        <section id="content">
            <div class="container">
                <div id="main">
                    <h1 class="logo block">
                        <a href="#" title="TooDrinks - home">
                            <img src="{{ asset('templateFrontend/images/logo.png')}}" alt="TooDrinks" />
                        </a>
                    </h1>
                    <div class="welcome-text box" style="">¡Bienvenido de Vuelta!</div>
                    <p class="white-color block" style="font-size: 1.5em;">Por favor, inicia sesión con tu cuenta.</p>
                    <div class="col-sm-8 col-md-6 col-lg-5 no-float no-padding center-block">
                        <form class="login-form" method="POST" action="{{ route('login') }}">
                        	{{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" class="input-text input-large full-width" name="email" id="email" value="{{ old('email')}}" placeholder="ingresa tu correo electrónico" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" class="input-text input-large full-width" name="password" id="password" placeholder="ingresa tu contraseña" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Recordarme
                                </label>
                            </div>
                            <button type="submit" class="btn-large full-width yellow">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <footer id="footer">
            <div class="footer-wrapper">
                <div class="container">
                    <nav id="main-menu" role="navigation" class="inline-block hidden-mobile">
                        <ul class="menu">
					        <li class="menu-item-has-children">
					            <a href="{{route('frontend.index')}}">Inicio</a>
					        </li>
					        <li class="menu-item-has-children">
					            <a href="{{route('frontend.noticias')}}">Noticias</a>
					        </li>
					        <li class="menu-item-has-children">
					            <a href="{{route('frontend.marcas')}}">Marcas</a>
					        </li>
					        <li class="menu-item-has-children">
					            <a href="{{route('frontend.productos')}}">Productos</a>
					        </li>
					        <li class="menu-item-has-children">
					            <a href="{{route('frontend.quienes-somos')}}">¿Quiénes Somos?</a>
					        </li>
					        <li class="menu-item-has-children">
					            <a href="{{route('frontend.contacto')}}">Contacto</a>
					        </li>
					    </ul>
                    </nav>
                    <div class="copyright">
                        <p>&copy; 2017 TooDrinks</p>
                    </div>
                </div>
            </div>
        </footer>
        <div class="container">
            <img src="http://placehold.it/213x82" class="plane animated" alt="" data-animation-type="fadeInRight" data-animation-delay="1">
        </div>
        <img src="http://placehold.it/666x617" class="places animated" alt="" data-animation-type="fadeInRight">
    </div>


    <!-- Javascript -->
    <script type="text/javascript" src="templateFrontend/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="templateFrontend/js/jquery.noconflict.js"></script>
    <script type="text/javascript" src="templateFrontend/js/modernizr.2.7.1.min.js"></script>
    <script type="text/javascript" src="templateFrontend/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="templateFrontend/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="templateFrontend/js/jquery-ui.1.10.4.min.js"></script>
    
     <!-- Twitter Bootstrap -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
    
    <!-- parallax -->
    <script type="text/javascript" src="templateFrontend/js/jquery.stellar.min.js"></script>
    
    <!-- waypoint -->
    <script type="text/javascript" src="templateFrontend/js/waypoints.min.js"></script>

    <!-- load page Javascript -->
    <script type="text/javascript" src="templateFrontend/js/theme-scripts.js"></script>
    <script type="text/javascript" src="templateFrontend/js/scripts.js"></script>

    <script type="text/javascript">
        enableChaser = 0; //disable chaser
    </script>
</body>
</html>
