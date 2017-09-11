<?php 
    $paises = DB::table('pais')
            ->orderBy('pais', 'ASC')
            ->pluck('pais', 'id');
?>

<!DOCTYPE html>
<html> 
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
    <link rel="stylesheet" href="{{ asset('templateFrontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('templateFrontend/css/font-awesome.min.css')}}">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('templateFrontend/css/animate.min.css')}}">
    
    <!-- Main Style -->
    <link id="main-style" rel="stylesheet" href="{{ asset('templateFrontend/css/style.css')}}">
    
    <!-- Updated Styles -->
    <link rel="stylesheet" href="{{ asset('templateFrontend/css/updates.css')}}">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('templateFrontend/css/custom.css')}}">
    
    <!-- Responsive Styles -->
    <link rel="stylesheet" href="{{ asset('templateFrontend/css/responsive.css')}}">

    <script type="text/javascript" src="{{ asset('js/usuarios/registrarse.js') }}"></script>
</head>
<body>
    <div id="page-wrapper">
        <header id="header" class="navbar-static-top">
            @include('frontend.plantillas.partes.navbar')

            <div class="main-header">
                <a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle"> Menú Móvil</a>

                <div class="container">
                    <h1 class="logo navbar-brand">
                        <a href="#" title="TooDrinks - Home">
                            <img src="{{ asset('templateFrontend/images/logo.png')}}" alt="TooDrinks" />
                        </a>
                    </h1>
                    
                    @include('frontend.plantillas.partes.mainMenu')
                </div>
                
                @include('frontend.plantillas.partes.menuMovil')

                @if (Session::has('msj'))
                    <div class="alert alert-success alert-dismissable">
                       <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
                    </div>
                @endif
                
                @if (Auth::check())
                    @if (Auth::user()->activado == '0')
                        <div class="alert alert-success">
                            <strong>¡Enhorabuena!</strong> Te has registrado con éxito en TooDrinks. Hemos enviado un email a tu dirección de correo para verificar tu cuenta. Para finalizar tu registro, por favor revisa tu correo.
                        </div>
                    @endif
                @endif
            </div>
        </header>

        <div class="page-title-container">
            <div class="container">
                <div class="page-title pull-left">
                    <h2 class="entry-title">REGISTRO</h2>
                </div>
                <ul class="breadcrumbs pull-right">
                    <li><a href="#">INICIO</a></li>
                    <li class="active">REGISTRO</li>
                </ul>
            </div>
        </div>
        
        <br />

        <section>
            <div class="container">
                <div id="main">
                    <div class="col-md-9 no-float no-padding center-block">
                        <div class="intro text-center block">
                            <h2>Crear Cuenta TooDrinks</h2>
                        </div>
                        <form action="{{ route('register') }}" method="POST">
                            <div class="alert alert-error" style="display: none;" id="error"></div>

                            {{ csrf_field() }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            {!! Form::hidden('entidad_id', $id) !!}
                            {!! Form::hidden('entidad_tipo', $tipo) !!}
                            
                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <label><strong>Nombre</strong></label>
                                    <input type="text" class="input-text full-width" name="nombre" required>
                                </div>
                                <div class="col-xs-6">
                                    <label><strong>Apellido</strong></label>
                                    <input type="text" class="input-text full-width" name="apellido" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <label><strong>Correo Electrónico</strong></label>
                                    <input type="email" class="input-text full-width" name="email" id="email" onblur="verificarCorreo();" required>
                                </div>
                                <div class="col-xs-6">
                                    <label><strong>Nombre de Usuario</strong></label>
                                    <input type="text" class="input-text full-width" name="name" required>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <label><strong>Contraseña</strong></label>
                                    <input type="password" class="input-text full-width" id="clave1" name="password" required onblur="validarClave();">
                                </div>
                                <div class="col-xs-6">
                                    <label><strong>Confirme su Contraseña</strong></label>
                                    <input type="password" class="input-text full-width" id="clave2" required onblur="verificarClaves();">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-6">
                                    <label><strong>País</strong></label>
                                    {!! Form::select('pais_id', $paises, null, ['class' => 'input-select full-width', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();', 'required']) !!}
                                </div>
                                <div class="col-xs-6">
                                    <label><strong>Provincia / Estado</strong></label>
                                    <select name="provincia_region_id" class="input-select full-width" id="provincias" required>
                                        <option value="">Seleccione una provincia..</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <center><p>Al registrarme, acepto las <a href="#terminos" class="soap-popupbox">Condiciones de servicio y Políticas de privacidad</a> de TooDrinks.com</p></center>
                            </div>
                            <button type="submit" class="btn-large full-width" id="boton">REGISTRARME</button> 
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        @include('frontend.plantillas.partes.footer')
        <!-- FIN DE FOOTER -->  
    </div>

    <!-- Javascript -->
    <script type="text/javascript" src="{{ asset('templateFrontend/js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('templateFrontend/js/jquery.noconflict.js')}}"></script>
    <script type="text/javascript" src="{{ asset('templateFrontend/js/modernizr.2.7.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('templateFrontend/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('templateFrontend/js/jquery.placeholder.js')}}"></script>
    <script type="text/javascript" src="{{ asset('templateFrontend/js/jquery-ui.1.10.4.min.js')}}"></script>
    
    <!-- Twitter Bootstrap -->
    <script type="text/javascript" src="{{ asset('templateFrontend/js/bootstrap.js')}}"></script>
    
    <!-- parallax -->
    <script type="text/javascript" src="{{ asset('templateFrontend/js/jquery.stellar.min.js')}}"></script>
    
    <!-- waypoint -->
    <script type="text/javascript" src="{{ asset('templateFrontend/js/waypoints.min.js')}}"></script>

    <!-- load page Javascript -->
    <script type="text/javascript" src="{{ asset('templateFrontend/js/theme-scripts.js')}}"></script>
    <script type="text/javascript" src="{{ asset('templateFrontend/js/contact.js')}}"></script>
</body>
</html>

