<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>TooDrinks | @yield('title', '') </title>

		{!! Html::style('bootstrap/css/bootstrap.css') !!}
		{!! Html::style('bootstrap/css/bootstrap.min.css') !!}
		{!! Html::style('font-awesome/css/font-awesome.min.css') !!}
		{!! Html::style('font-awesome/css/font-awesome.css') !!}
		{!! Html::script('bootstrap/js/jquery-3.2.1.min.js') !!}
		{!! Html::style('ionicons/css/ionicons.min.css') !!}
	    {!! Html::style('archivosLTE/dist/css/AdminLTE.min.css') !!}
	    {!! Html::style('archivosLTE/dist/css/skins/_all-skins.min.css') !!}
	    {!! Html::style('archivosLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') !!}
      <link rel="stylesheet" href="{{ asset ('css/main.css') }}">

	</head>

	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">

  			<header class="main-header">
			    <!-- Logo -->
			    <a href="index2.html" class="logo">
			    	<!-- mini logo for sidebar mini 50x50 pixels -->
			      	<span class="logo-mini"><b>t</b>d</span>
			      	<!-- logo for regular state and mobile devices -->
			      	<span class="logo-lg"><b>Too</b>Drinks</span>
			    </a>

			    @include('plantillas.partes.navbar')

  			</header>
 			
 			<!-- Left side column. contains the logo and sidebar -->
 			 <aside class="main-sidebar">
    			<!-- sidebar: style can be found in sidebar.less -->
    			<section class="sidebar">
      				@include('plantillas.partes.sidebar')
    			</section>
    			<!-- /.sidebar -->
  			</aside>

  			<!-- Content Wrapper. Contains page content -->
  			<div class="content-wrapper">
    			<!-- Content Header (Page header) -->
    			<section class="content-header">
      				<h1>Dashboard<small>Control panel</small></h1>
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
        				<section class="col-lg-7 connectedSortable">
				         	@yield('content-left')
				        </section>
        				<!-- /.Left col -->
        				
        				<!-- right col (We are only adding the ID to make the widgets sortable)-->
        				<section class="col-lg-5 connectedSortable">
							@include('plantillas.partes.content-right')
        				</section>
        				<!-- right col -->
      				</div>
      				<!-- /.row (main row) -->
    			</section>
    			<!-- /.content -->
  			</div>
  			<!-- /.content-wrapper -->
  		
  			
	    </div>
     
	    {!! Html::script('bootstrap/js/jquery-3.2.1.min.js') !!}
	    {!! Html::script('bootstrap/js/bootstrap.min.js') !!}}
	    {!! Html::script('bootstrap/js/jquery-ui.min.js') !!}
	    {!! Html::script('archivosLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') !!}
	    {!! Html::script('archivosLTE/plugins/slimScroll/jquery.slimscroll.min.js') !!}
	    {!! Html::script('archivosLTE/plugins/fastclick/fastclick.js') !!}
	    {!! Html::script('archivosLTE/dist/js/app.min.js') !!}
      {!! Html::script('js/credito/pinterest_grid.js')!!}


      	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
     	<script>
        	$.widget.bridge('uibutton', $.ui.button);
      	</script>
      <script src="{{ asset('js/credito/pinterest_grid.js') }}"></script>
    </body>

</html>