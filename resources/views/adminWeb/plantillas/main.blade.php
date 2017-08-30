<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>TooDrinks Admin | @yield('title', '') </title>

		{!! Html::style('bootstrap/css/bootstrap.css') !!}
		{!! Html::style('bootstrap/css/bootstrap.min.css') !!}
		{!! Html::style('font-awesome/css/font-awesome.min.css') !!}
		{!! Html::style('font-awesome/css/font-awesome.css') !!}
		{!! Html::script('bootstrap/js/jquery-3.2.1.min.js') !!}
		{!! Html::style('ionicons/css/ionicons.min.css') !!}
	   {!! Html::style('archivosLTE/dist/css/AdminLTE.min.css') !!}
	   {!! Html::style('archivosLTE/dist/css/skins/_all-skins.min.css') !!}
	   {!! Html::style('archivosLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') !!}
      {!! Html::style('css/main.css') !!}

	</head>
  
	<body class="hold-transition skin-blue sidebar-mini">

      <div class="wrapper">

         <header class="main-header">
            <!-- Logo -->
            <a href="{{ route('usuario.index') }}" class="logo">
               <span class="logo-mini"><b>T</b>D</span>
               <span class="logo-lg"><b>Too</b>Drinks</span>
            </a>

            @include('adminWeb.plantillas.navbar')
         </header>
      
         <!-- Left side column. contains the logo and sidebar -->
         <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
               @include('adminWeb.plantillas.sidebar')
            </section>
            <!-- /.sidebar -->
         </aside>

         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">

            <section class="content-header">
               <h1>@yield('title-header')
               <small>@yield('title-complement')</small></h1>
               <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Breadcrumbs</a></li>
                  <li class="active">En construcción</li>
               </ol>
            </section>

            <section class="content">
               <div class="row">
                  @yield('items') 
               </div>

               <div class="row">
                  <div class="col-md-9" id="contenido">
                     <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                           @yield('alertas')
                        </div>
                        <div class="col-md-1"></div>
                     </div>
                     
                     @yield('content-left')

                  </div>
                  <div class="col-md-3">
                     @yield('content-right')
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-9">
                     <center>@yield('pagination')</center>
                  </div>
               </div>
            </section>

         </div>
      </div>
     
	   {!! Html::script('bootstrap/js/jquery-3.2.1.min.js') !!}
      {!! Html::script('bootstrap/js/bootstrap.min.js') !!}
      {!! Html::script('bootstrap/js/jquery-ui.min.js') !!}
	   {!! Html::script('archivosLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') !!}
	   {!! Html::script('archivosLTE/plugins/slimScroll/jquery.slimscroll.min.js') !!}
	   {!! Html::script('archivosLTE/plugins/fastclick/fastclick.js') !!}
	   {!! Html::script('archivosLTE/dist/js/app.min.js') !!}
      {!! Html::script('js/credito/pinterest_grid.js')!!}
      {!! Html::script('js/credito/main.js')!!}

      	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
     	<script>
        	$.widget.bridge('uibutton', $.ui.button);
      </script>
   </body>
</html>