@if ( (Auth::user()->rol != 'AD') && (Auth::user()->rol != 'US') )
  @if (Auth::user()->productor == '1')
     <?php 
        $productores = DB::table('productor')
                          ->select('id', 'nombre')
                          ->where('user_id', '=', Auth::user()->id)
                          ->get();

        foreach ($productores as $productor)
           $id_entidad[] = $productor->id; 
           $nombre_entidad[] = $productor->nombre;
           $tipo_entidad[] = 'P';  
     ?>
  @endif
  @if (Auth::user()->importador == '1')
     <?php 
        $importadores = DB::table('importador')
                          ->select('id', 'nombre')
                          ->where('user_id', '=', Auth::user()->id)
                          ->get();

        foreach ($importadores as $importador)
           $id_entidad[] = $importador->id; 
           $nombre_entidad[] = $importador->nombre;
           $tipo_entidad[] = 'I';   
        ?>
  @endif
  @if (Auth::user()->distribuidor == '1')
     <?php 
        $distribuidores = DB::table('distribuidor')
                             ->select('id', 'nombre')
                             ->where('user_id', '=', Auth::user()->id)
                             ->get();

        foreach ($distribuidores as $distribuidor)
              $id_entidad[] = $distribuidor->id; 
              $nombre_entidad[] = $distribuidor->nombre;
              $tipo_entidad[] = 'D';  
        ?>
  @endif
  @if (Auth::user()->horeca == '1')
     <?php 
        $horecas = DB::table('horeca')
                       ->select('id', 'nombre')
                       ->where('user_id', '=', Auth::user()->id)
                       ->get();

        foreach ($horecas as $horeca)
           $id_entidad[] = $horeca->id; 
           $nombre_entidad[] = $horeca->nombre;
           $tipo_entidad[] = 'H';   
        ?>
  @endif
@endif

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
      {!! Html::style('css/main.css') !!}

	</head>
  
	<body class="hold-transition skin-blue sidebar-mini">

      <div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Cambiar de Perfil</h4>
               </div>
               <div class="modal-body">
                  {!! Form::open(['route' => 'usuario.cambiar-perfil', 'method' => 'POST']) !!}
                     <div class="form-group">
                        <select class="form-control" name="entidad">
                           @if ( (Auth::user()->rol != 'AD') && (Auth::user()->rol != 'US') )
                              <?php 
                                 $longitud = count($id_entidad);
                                 for ($i=0; $i<$longitud; $i++ ){
                                    echo "<option value='".$tipo_entidad[$i].".".$id_entidad[$i]."'>".$tipo_entidad[$i]." - ".$nombre_entidad[$i]."</option>";
                                 }
                              ?>
                           @endif
                        </select>
                     </div>  
               </div>
               <div class="modal-footer">
                  {!! Form::submit('Cambiar Perfil', ['class' => 'btn btn-primary']) !!}
               </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>

      <div class="wrapper">

        <header class="main-header">
          <!-- Logo -->
          <a href="{{ route('usuario.index') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><b>T</b>D</span>
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
                <section class="col-lg-8 connectedSortable">
                  @yield('content-left')
                </section>
                <!-- /.Left col -->
                
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-4 connectedSortable">
                  @yield('content-right')
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