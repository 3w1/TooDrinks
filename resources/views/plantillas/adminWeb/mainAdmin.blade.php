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

            @include('plantillas.adminWeb.navbarAdmin')
         </header>
      
         <!-- Left side column. contains the logo and sidebar -->
         <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
               @include('plantillas.adminWeb.sidebarAdmin')
            </section>
            <!-- /.sidebar -->
         </aside>

         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               @yield('title-header')
            </section>

            <!-- Main content -->
            <section class="content">
               <!-- Small boxes (Stat box) -->
               <div class="row">
                  @yield('items') 
               </div>
    
               <!-- Main row -->
               <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                     @yield('content-left')
                  </section>
                  <!-- /.Left col -->
               </div>
               <!-- /.row (main row) -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
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