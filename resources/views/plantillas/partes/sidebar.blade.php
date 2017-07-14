@if (session('perfilTipo') == 'P')
   <?php 
      $notificaciones_pendientes = DB::table('notificacion_p')
                                    ->where('productor_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id', 'tipo')
                                    ->get();

      $confirmaciones = 0; $demandas = 0;
      $cont_NM = 0; $cont_NP = 0; $cont_AI = 0; $cont_AD = 0;
      $cont_SI = 0; $cont_SD = 0; $cont_DP = 0; $cont_DB = 0;

      foreach($notificaciones_pendientes as $notificacion){
         if ($notificacion->tipo == 'NM'){
            $confirmaciones++;
            $cont_NM++;
         }elseif ($notificacion->tipo == 'NP'){
            $confirmaciones++;
            $cont_NP++;
         }elseif ($notificacion->tipo == 'AI'){
            $confirmaciones++;
            $cont_AI++;
         }elseif ($notificacion->tipo == 'AD'){
            $confirmaciones++;
            $cont_AD++;
         }elseif ($notificacion->tipo == 'SI'){
            $demandas++;
            $cont_SI++;
         }elseif ($notificacion->tipo == 'SD'){
            $demandas++;
            $cont_SD++;
         }elseif ($notificacion->tipo == 'DP'){
            $demandas++;
            $cont_DP++;
         }elseif ($notificacion->tipo == 'DB'){
            $demandas++;
            $cont_DB++;
         }
      }
   ?>
@elseif (session('perfilTipo') == 'I')
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
   @if (Auth::user()->activado == 1)
      <li class="header">Opciones de Usuario</li>

      <li><a href="{{ route('usuario.inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Productos</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li><a href="{{ route('producto.index') }}"><i class="fa fa-circle-o"></i> Status de mis Productos</a></li>
               <li><a href="{{ route('producto.create') }}"><i class="fa fa-circle-o"></i> Nuevo Producto</a></li>
            </ul>
         </li>
      <li><a href=""><i class="fa fa-circle-o"></i> Opiniones</a></li>
      <li><a href=""><i class="fa fa-circle-o"></i> Banners Publicitarios</a></li>
      <li><a href="{{ route('credito.index') }}"><i class="fa fa-circle-o"></i> Planes de Crédito</a></li>

      @if(session('perfilTipo') == 'P')
         <li class="header">Opciones de Productor</li>
         <!-- SECCIÓN DE PRODUCTORES -->
         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Marcas</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li><a href="{{ route('marca.index') }}"><i class="fa fa-circle-o"></i> Mis Marcas</a></li>
               <li><a href="{{ route('productor.marcas-disponibles') }}"><i class="fa fa-circle-o"></i> Marcas Disponibles</a></li>
               <li><a href="{{ route('marca.create') }}"><i class="fa fa-circle-o"></i> Nueva Marca</a></li>
            </ul>
         </li>
         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Ofertas</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li><a href="{{ route('oferta.index') }}"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
               <li><a href="{{ route('oferta.crear-oferta', ['0','0']) }}"><i class="fa fa-circle-o"></i> Nueva Oferta</a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#">
               <i class="fa fa-share"></i> <span>Solicitudes</span>
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Importación
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('demanda-importador.create') }}"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                     <li><a href="{{ route('demanda-importador.index') }}"><i class="fa fa-circle-o"></i> Mis Solicitudes</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Distribución
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('demanda-distribuidor.create') }}"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                     <li><a href="{{ route('demanda-distribuidor.index') }}"><i class="fa fa-circle-o"></i> Mis Solicitudes</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Confirmaciones
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  @if($confirmaciones > 0)<small class="label pull-right bg-orange">{{$confirmaciones}}</small>@endif
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('productor.confirmar-importadores') }}"><i class="fa fa-circle-o"></i> Importadores
                  <span class="pull-right-container">
                     @if($cont_AI > 0) <small class="label pull-right bg-blue">{{$cont_AI}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('productor.confirmar-distribuidores') }}"><i class="fa fa-circle-o"></i> Distribuidores
                  <span class="pull-right-container">
                     @if($cont_AD > 0) <small class="label pull-right bg-red">{{$cont_AD}}</small>@endif
                  </span>
               </a></li>
               <li><a href=""><i class="fa fa-circle-o"></i> Marcas
                  <span class="pull-right-container">
                     @if($cont_NM > 0) <small class="label pull-right bg-purple">{{$cont_NM}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('productor.confirmar-productos') }}"><i class="fa fa-circle-o"></i> Productos
                  <span class="pull-right-container">
                     @if($cont_NP > 0) <small class="label pull-right bg-yellow">{{$cont_NP}}</small>@endif
                  </span>
               </a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Demandas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  @if($demandas > 0)<small class="label pull-right bg-blue">{{$demandas}}</small>@endif
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('demanda-producto.demandas-productos-productores') }}"><i class="fa fa-circle-o"></i> Productos
                  <span class="pull-right-container">
                     @if($cont_DP > 0) <small class="label pull-right bg-aqua">{{$cont_DP}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('demanda-producto.demandas-bebidas-productores') }}"><i class="fa fa-circle-o"></i> Bebidas
                  <span class="pull-right-container">
                     @if($cont_DB > 0) <small class="label pull-right bg-yellow">{{$cont_DB}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('demandas-importacion')}}"><i class="fa fa-circle-o"></i> Importación
                  <span class="pull-right-container">
                     @if($cont_SI > 0) <small class="label pull-right bg-orange">{{$cont_SI}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('demandas-distribucion')}}"><i class="fa fa-circle-o"></i> Distribución
                  <span class="pull-right-container">
                     @if($cont_SD > 0) <small class="label pull-right bg-green">{{$cont_SD}}</small>@endif
                  </span>
               </a></li>
            </ul>
         </li>
         <li><a href="{{ route('productor.listado-importadores') }}"><i class="fa fa-circle-o"></i> Listado de Importadores</a></li>
         <!-- FIN DE SECCIÓN DE PRODUCTORES -->
      @endif
      
      @if(session('perfilTipo') == 'I')
         <!-- SECCIÓN DE IMPORTADOR -->
         <li class="header">Opciones de Importador</li>
         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Marcas</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('marca.index') }}"><i class="fa fa-circle-o"></i> Mis Marcas</a></li>
               <li><a href="{{ route('importador.marcas-disponibles') }}"><i class="fa fa-circle-o"></i> Marcas Disponibles</a></li>
               <li><a href="{{ route('marca.create') }}"><i class="fa fa-circle-o"></i> Nueva Marca</a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Ofertas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  @if($cont_NO > 0)<small class="label pull-right bg-purple">{{$cont_NO}}</small>@endif
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('oferta.index') }}"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
               <li><a href="{{ route('oferta.importadores') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles
                  <span class="pull-right-container">
                     @if($cont_NO > 0) <small class="label pull-right bg-purple">{{$cont_NO}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('oferta.crear-oferta', ['0','0']) }}"><i class="fa fa-circle-o"></i> Nueva Oferta</a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Solicitudes
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Distribución
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('demanda-distribuidor.create') }}"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                     <li><a href="{{ route('demanda-distribuidor.index') }}"><i class="fa fa-circle-o"></i> Mis Solicitudes</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Producto
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('demanda-producto.create') }}"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                     <li><a href="{{ route('demanda-producto.index') }}"><i class="fa fa-circle-o"></i> Mis Solicitudes</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Importar Producto
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
		            <li><a href="{{ route('solicitar-importacion.create') }}"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                    <li><a href="{{ route('solicitar-importacion.index') }}"><i class="fa fa-circle-o"></i> Mis Solicitudes</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Demandas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  @if($demandas > 0)<small class="label pull-right bg-blue">{{$demandas}}</small>@endif
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('demanda-importador.demandas-disponibles') }}"><i class="fa fa-circle-o"></i> Importadores
                  <span class="pull-right-container">
                     @if($cont_DI > 0) <small class="label pull-right bg-orange">{{$cont_DI}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('demanda-producto.demandas-productos-importadores') }}"><i class="fa fa-circle-o"></i> Productos
                  <span class="pull-right-container">
                     @if($cont_DP > 0) <small class="label pull-right bg-aqua">{{$cont_DP}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('demanda-producto.demandas-bebidas-importadores') }}"><i class="fa fa-circle-o"></i> Bebidas
                  <span class="pull-right-container">
                     @if($cont_DB > 0) <small class="label pull-right bg-yellow">{{$cont_DB}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('demandas-distribucion')}}"><i class="fa fa-circle-o"></i> Distribución
                  <span class="pull-right-container">
                     @if($cont_AD > 0) <small class="label pull-right bg-red">{{$cont_AD}}</small>@endif
                  </span>
               </a></li>
            </ul>
         </li>
         <li><a href="{{ route('importador.listado-distribuidores') }}"><i class="fa fa-circle-o"></i> Listado de Distribuidores</a></li>
         <!-- FIN DE SECCIÓN DE IMPORTADOR -->
      @endif

      @if(session('perfilTipo') == 'D')
         <!-- SECCIÓN DE IMPORTADORES -->
         <li class="header">Opciones de Distribuidor</li>
         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Marcas</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('marca.index') }}"><i class="fa fa-circle-o"></i> Mis Marcas</a></li>
               <li><a href="{{ route('distribuidor.marcas-disponibles') }}"><i class="fa fa-circle-o"></i> Marcas Disponibles</a></li>
               <li><a href="{{ route('marca.create') }}"><i class="fa fa-circle-o"></i> Nueva Marca</a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Ofertas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  @if($cont_NO > 0)<small class="label pull-right bg-purple">{{$cont_NO}}</small>@endif
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('oferta.index') }}"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
               <li><a href="{{ route('oferta.distribuidores') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles
                  <span class="pull-right-container">
                     @if($cont_NO > 0) <small class="label pull-right bg-purple">{{$cont_NO}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('oferta.crear-oferta', ['0','0']) }}"><i class="fa fa-circle-o"></i> Nueva Oferta</a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Solicitudes
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a href="#"><i class="fa fa-share"></i> Producto
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('demanda-producto.create') }}"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                     <li><a href="{{ route('demanda-producto.index') }}"><i class="fa fa-circle-o"></i> Mis Solicitudes</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-share"></i> Distribuir Producto
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('solicitar-distribucion.create') }}"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                     <li><a href="{{ route('solicitar-distribucion.index') }}"><i class="fa fa-circle-o"></i> Mis Solicitudes</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Demandas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  @if($demandas > 0)<small class="label pull-right bg-red">{{$demandas}}</small>@endif
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('demanda-distribuidor.demandas-disponibles') }}"><i class="fa fa-circle-o"></i> 
                  <span class="pull-right-container">
                     @if($cont_DD > 0) <small class="label pull-right bg-green">{{$cont_DD}}</small>@endif
                  </span>
               Distribuidores</a></li>
               <li><a href="{{ route('demanda-producto.demandas-productos-distribuidores') }}"><i class="fa fa-circle-o"></i> Productos
                  <span class="pull-right-container">
                     @if($cont_DP > 0) <small class="label pull-right bg-aqua">{{$cont_DP}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('demanda-producto.demandas-bebidas-distribuidores') }}"><i class="fa fa-circle-o"></i> Bebidas
                  <span class="pull-right-container">
                     @if($cont_DB > 0) <small class="label pull-right bg-yellow">{{$cont_DB}}</small>@endif
                  </span>
               </a></li>
            </ul>
         </li>
         <!-- FIN DE SECCIÓN DE DISTRIBUIDORES -->
      @endif

      @if(session('perfilTipo') == 'H')
        <!-- SECCIÓN DE HORECAS -->
         <li class="treeview">
            <a href="#">
               <i class="fa fa-share"></i> <span>Ofertas</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('oferta.horecas') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles</a></li>
            </ul>
         </li>
         <li>
            <a href="#"><i class="fa fa-share"></i> Solicitudes
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a href="#"><i class="fa fa-share"></i> Producto
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('demanda-producto.create') }}"><i class="fa fa-circle-o"></i> Nueva Solicitud</a></li>
                     <li><a href="{{ route('demanda-producto.index') }}"><i class="fa fa-circle-o"></i> Mis Solicitudes</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <li><a href=""><i class="fa fa-circle-o"></i> Listado de Distribuidores</a></li>
         <!-- FIN DE SECCIÓN DE HORECAS -->
      @endif
   @endif

   @if (Auth::user()->cantidad_entidades > 1)
      <li class="header">Opciones de Perfil</li>
         <li><a href="#" data-toggle='modal' data-target="#modalPerfil"><i class="fa fa-user-o"></i> Cambiar de Perfil</a></li>
   @endif
</ul>

   