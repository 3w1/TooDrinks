@if ( (Auth::user()->rol != 'AD') && (Auth::user()->rol != 'US') )
  @if (Auth::user()->productor == '1')
     <?php 
         $productores = DB::table('productor')
                          ->select('id', 'nombre')
                          ->where('user_id', '=', Auth::user()->id)
                          ->get();

         foreach ($productores as $productor){
            $id_entidad[] = $productor->id; 
            $nombre_entidad[] = $productor->nombre;
            $tipo_entidad[] = 'P'; 
         }      
     ?>
  @endif
  @if (Auth::user()->importador == '1')
     <?php 
         $importadores = DB::table('importador')
                          ->select('id', 'nombre')
                          ->where('user_id', '=', Auth::user()->id)
                          ->get();

         foreach ($importadores as $importador){
            $id_entidad[] = $importador->id; 
            $nombre_entidad[] = $importador->nombre;
            $tipo_entidad[] = 'I';
         }  
      ?>
  @endif
  @if (Auth::user()->distribuidor == '1')
     <?php 
        $distribuidores = DB::table('distribuidor')
                             ->select('id', 'nombre')
                             ->where('user_id', '=', Auth::user()->id)
                             ->get();

        foreach ($distribuidores as $distribuidor){
            $id_entidad[] = $distribuidor->id; 
            $nombre_entidad[] = $distribuidor->nombre;
            $tipo_entidad[] = 'D';
        }
                
        ?>
   @endif
   @if (Auth::user()->multinacional == '1')
     <?php 
         $multinacionales = DB::table('multinacional')
                             ->select('id', 'nombre')
                             ->where('user_id', '=', Auth::user()->id)
                             ->get();

         foreach ($multinacionales as $multinacional){
            $id_entidad[] = $multinacional->id; 
            $nombre_entidad[] = $multinacional->nombre;
            $tipo_entidad[] = 'M';  
         }      
      ?>
  @endif
  @if (Auth::user()->horeca == '1')
     <?php 
         $horecas = DB::table('horeca')
                       ->select('id', 'nombre')
                       ->where('user_id', '=', Auth::user()->id)
                       ->get();

         foreach ($horecas as $horeca){
            $id_entidad[] = $horeca->id; 
            $nombre_entidad[] = $horeca->nombre;
            $tipo_entidad[] = 'H';
         }  
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
            <a href="{{ route('usuario.index') }}" class="logo">
               <span class="logo-mini"><b>T</b>D</span>
               <span class="logo-lg"><b>Too</b>Drinks</span>
            </a>
            @include('plantillas.partes.navbar')
         </header>
      
         <aside class="main-sidebar">
            <section class="sidebar">
               @include('plantillas.partes.sidebar')
            </section>
         </aside>

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
    
               <!-- Main row -->
               <div class="row">
                  <section class="col-lg-9 connectedSortable">
                     <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                           @if (Auth::user()->activado == 1)
                              @yield('alertas')
                           @else 
                              <div class="alert alert-warning ">
                                 <strong>¡Ya Casi!</strong> Tu cuenta TooDrinks se ha creado exitosamente pero aún no la has confirmado. Hemos enviado un email a tu dirección de correo. Por favor, dirígete a tu correo electrónico para confirmar tu cuenta y empezar a disfrutar de todas las opciones de TooDrinks.
                              </div>
                           @endif
                        </div>
                        <div class="col-md-1"></div>
                     </div>
                     @if (Auth::user()->activado == 1)
                        @yield('content-left')
                     @endif
                  </section>
                  
                  <section class="col-lg-3 connectedSortable">
                     @yield('content-right')
                     @include('plantillas.partes.content-right')
                  </section>
               </div>

               <!-- Paginación -->
               <div class="row">
                  <div class="col-md-9">
                     @if (Auth::user()->activado == 1)
                        <center>@yield('paginacion')</center>
                     @endif
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