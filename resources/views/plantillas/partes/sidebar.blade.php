@if (session('perfilTipo') == 'I')
   <?php 
      $notificaciones_pendientes = DB::table('notificacion_i')
                                    ->where('importador_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id', 'tipo')
                                    ->get();

      $confirmaciones = 0; $demandas = 0;
      $cont_AD = 0; $cont_NO = 0;
      $cont_SD = 0; $cont_DP = 0; $cont_DB = 0; $cont_DI = 0;

      foreach($notificaciones_pendientes as $notificacion){
         if ($notificacion->tipo == 'AD'){
            $confirmaciones++;
            $cont_AD++;
         }elseif ($notificacion->tipo == 'NO'){
            $cont_NO++;
         }elseif ($notificacion->tipo == 'SD'){
            $demandas++;
            $cont_SD++;
         }elseif ($notificacion->tipo == 'DP'){
            $demandas++;
            $cont_DP++;
         }elseif ($notificacion->tipo == 'DB'){
            $demandas++;
            $cont_DB++;
         }elseif ($notificacion->tipo == 'DI'){
            $demandas++;
            $cont_DI++;
         }
      }
   ?>
@elseif (session('perfilTipo') == 'D')
   <?php 
      $notificaciones_pendientes = DB::table('notificacion_d')
                                    ->where('distribuidor_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id', 'tipo')
                                    ->get();

      $demandas = 0;
      $cont_NO = 0;
      $cont_DP = 0; $cont_DB = 0; $cont_DD = 0;

      foreach($notificaciones_pendientes as $notificacion){
         if ($notificacion->tipo == 'NO'){
            $cont_NO++;
         }elseif ($notificacion->tipo == 'DP'){
            $demandas++;
            $cont_DP++;
         }elseif ($notificacion->tipo == 'DB'){
            $demandas++;
            $cont_DB++;
         }elseif ($notificacion->tipo == 'DD'){
            $demandas++;
            $cont_DD++;
         }
      }
   ?>
@elseif (session('perfilTipo') == 'H')
   <?php 
      $notificaciones_pendientes = DB::table('notificacion_h')
                                    ->where('horeca_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id', 'tipo')
                                    ->get();

      $cont_NO = 0;

      foreach($notificaciones_pendientes as $notificacion){
         if ($notificacion->tipo == 'NO'){
            $cont_NO++;
         }
      }
   ?>
@endif
<div class="user-panel">
   @if (session('perfilTipo') == 'P')
      <div class="pull-left image">
         <img src="{{ asset('imagenes/productores/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (P)</p>
         <a href="{{ route('productor.edit', session('perfilId')) }}">Editar Perfil <i class="fa fa-edit"></i></a>
      </div>

   @elseif (session('perfilTipo') == 'I')
      <div class="pull-left image">
         <img src="{{ asset('imagenes/importadores/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (I)</p>
         <a href="{{ route('importador.edit', session('perfilId')) }}">Editar Perfil <i class="fa fa-edit"></i></a>
      </div>

   @elseif (session('perfilTipo') == 'M')
      <div class="pull-left image">
         <img src="{{ asset('imagenes/multinacionales/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (I)</p>
         <a href="{{ route('multinacional.edit', session('perfilId')) }}">Editar Perfil <i class="fa fa-edit"></i></a>
      </div>

   @elseif (session('perfilTipo') == 'D')

      <div class="pull-left image">
         <img src="{{ asset('imagenes/distribuidores/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (D)</p>
         <a href="{{ route('distribuidor.edit', session('perfilId')) }}">Editar Perfil <i class="fa fa-edit"></i></a>
      </div>

   @elseif (session('perfilTipo') == 'H')
      <div class="pull-left image">
         <img src="{{ asset('imagenes/horecas/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (H)</p>
         <a href="{{ route('horeca.edit', session('perfilId')) }}">Editar Perfil <i class="fa fa-edit"></i></a>
      </div>
   @else
      <div class="pull-left image">
         <img src="{{ asset('imagenes/usuarios/thumbnails/')}}/{{ Auth::user()->avatar }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
         <a><i class="fa fa-circle text-success"></i> Usuario Propietario</a>
      </div>
   @endif
</div>

<ul class="sidebar-menu">
   <li class="header">PRINCIPAL</li>
   @if(session('perfilTipo') == 'P')
      @include('plantillas.partes.subpartes.opcionesProductor')
   @elseif(session('perfilTipo') == 'I')
      @include('plantillas.partes.subpartes.opcionesImportador')
   @elseif(session('perfilTipo') == 'D')
      @include('plantillas.partes.subpartes.opcionesDistribuidor')
   @elseif(session('perfilTipo') == 'H')
      @include('plantillas.partes.subpartes.opcionesHoreca')
   @endif
   
   @if (session('perfilTipo') != 'H')
      <li class="header">PUBLICIDAD</li>
      <li class="li"><a href="{{route('banner-publicitario.index')}}"><i class="fa fa-flag"></i> Publicidad</a></li>

      <li class="header">Finanzas</li>
      <!--<li><a href="#"><i class="fa fa-circle-o"></i> Suscripciones</a></li>-->
      <li><a href="{{ route('credito.index') }}"><i class="fa fa-circle-o"></i> Créditos</a></li>
      <li><a href="{{ route('credito.historial-gastos') }}"><i class="fa fa-circle-o"></i> Facturación</a></li>
      <li><a href="{{ route('credito.historial-planes') }}"><i class="fa fa-circle-o"></i> Historial</a></li>
   @endif

   @if (Auth::user()->cantidad_entidades > 1)
      <li class="header">CAMBIAR DE PERFIL</li>
      <li><a href="#" data-toggle='modal' data-target="#modalPerfil"><i class="fa fa-user-o"></i> Cambiar de Perfil</a></li>
   @endif
</ul>

   