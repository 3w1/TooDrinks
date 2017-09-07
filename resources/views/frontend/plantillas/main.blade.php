<!DOCTYPE html>
<html> 
<head>
    <!-- Page Title -->
    <title>TooDrinks | @yield('title', '')</title>
    
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
    {!! Html::style('templateFrontend/css/animate.min.css') !!}
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    
    <!-- Current Page Styles -->
    {!! Html::style('templateFrontend/components/revolution_slider/css/settings.css') !!}
    {!! Html::style('templateFrontend/components/revolution_slider/css/style.css') !!}
    {!! Html::style('templateFrontend/components/jquery.bxslider/jquery.bxslider.css') !!}
    {!! Html::style('templateFrontend/components/flexslider/flexslider.css') !!}
    
    <!-- Main Style -->
    {!! Html::style('templateFrontend/css/style.css') !!}
    
    <!-- Updated Styles -->
    {!! Html::style('templateFrontend/css/updates.css') !!}

    <!-- Custom Styles -->
    {!! Html::style('templateFrontend/css/custom.css') !!}
    
    <!-- Responsive Styles -->
    {!! Html::style('templateFrontend/css/responsive.css') !!}
</head>
<body>
    
    <div id="page-wrapper">
        <header id="header" class="navbar-static-top">
            @include('frontend.plantillas.partes.navbar')
            
            <div class="main-header">    
                <a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle">
                    Menú Móvil
                </a>

                <div class="container">
                    <h1 class="logo navbar-brand">
                        <a href="#" title="TooDrinks - Home">
                            <img src="{{ asset('templateFrontend/images/logo.png')}}" alt="TooDrinks" />
                        </a>
                    </h1>
                    @include('frontend.plantillas.partes.mainMenu')
                </div>
                
                @include('frontend.plantillas.partes.menuMovil')
            </div>
            
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
                        
        </header>

        @yield('content')
        
        <!-- FOOTER -->
        @include('frontend.plantillas.partes.footer')
        <!-- FIN DE FOOTER -->  
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

    <!-- Google Map Api -->
    <script type='text/javascript' src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
    <script type="text/javascript" src="templateFrontend/js/gmap3.min.js"></script>
    
    <!-- load revolution slider scripts -->
    <script type="text/javascript" src="templateFrontend/components/revolution_slider/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="templateFrontend/components/revolution_slider/js/jquery.themepunch.revolution.min.js"></script>

    <!-- Flex Slider -->
    <script type="text/javascript" src="templateFrontend/components/flexslider/jquery.flexslider-min.js"></script>
    
    <!-- load BXSlider scripts -->
    <script type="text/javascript" src="templateFrontend/components/jquery.bxslider/jquery.bxslider.min.js"></script>
    
    <!-- parallax -->
    <script type="text/javascript" src="templateFrontend/js/jquery.stellar.min.js"></script>
    
    <!-- waypoint -->
    <script type="text/javascript" src="templateFrontend/js/waypoints.min.js"></script>

    <!-- load page Javascript -->
    <script type="text/javascript" src="templateFrontend/js/theme-scripts.js"></script>
    <script type="text/javascript" src="templateFrontend/js/scripts.js"></script>

     <!-- parallax -->
    <script type="text/javascript" src="templateFrontend/js/jquery.stellar.min.js"></script>
    
    <!-- waypoint -->
    <script type="text/javascript" src="templateFrontend/js/waypoints.min.js"></script>

    <!-- load page Javascript -->
    <script type="text/javascript" src="templateFrontend/js/theme-scripts.js"></script>
    <script type="text/javascript" src="templateFrontend/js/contact.js"></script>

    <script type="text/javascript">
        tjq(".travelo-google-map").gmap3({
            map: {
                options: {
                    center: [48.85661, 2.35222],
                    zoom: 12
                }
            },
            marker:{
                values: [
                    {latLng:[48.85661, 2.35222], data:"Paris"}

                ],
                options: {
                    draggable: false
                },
            }
        });
    </script>
    
    <script type="text/javascript">
        tjq(document).ready(function() {
            tjq('.revolution-slider').revolution(
            {
                sliderType:"standard",
                sliderLayout:"auto",
                dottedOverlay:"none",
                delay:9000,
                navigation: {
                    keyboardNavigation:"off",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation:"off",
                    mouseScrollReverse:"default",
                    onHoverStop:"on",
                    touch:{
                        touchenabled:"on",
                        swipe_threshold: 75,
                        swipe_min_touches: 1,
                        swipe_direction: "horizontal",
                        drag_block_vertical: false
                    }
                    ,
                    arrows: {
                        style:"default",
                        enable:true,
                        hide_onmobile:false,
                        hide_onleave:false,
                        tmp:'',
                        left: {
                            h_align:"left",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        },
                        right: {
                            h_align:"right",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        }
                    }
                },
                visibilityLevels:[1240,1024,778,480],
                gridwidth:1170,
                gridheight:646,
                lazyType:"none",
                shadow:0,
                spinner:"spinner4",
                stopLoop:"off",
                stopAfterLoops:-1,
                stopAtSlide:-1,
                shuffle:"off",
                autoHeight:"off",
                hideThumbsOnMobile:"off",
                hideSliderAtLimit:0,
                hideCaptionAtLimit:0,
                hideAllCaptionAtLilmit:0,
                debugMode:false,
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            });
        });
    </script>
</body>
</html>

