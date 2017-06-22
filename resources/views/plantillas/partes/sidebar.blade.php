<div class="user-panel">
   @if (session('perfilTipo') == 'P')
      <div class="pull-left image">
         <img src="{{ asset('imagenes/productores/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (P)</p>
         <a><i class="fa fa-circle text-success"></i> Créditos: {{ session('perfilSaldo') }}</a>
      </div>

   @elseif (session('perfilTipo') == 'I')

      <div class="pull-left image">
         <img src="{{ asset('imagenes/importadores/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (I)</p>
         <a><i class="fa fa-circle text-success"></i> Créditos: {{ session('perfilSaldo') }}</a>
      </div>

   @elseif (session('perfilTipo') == 'D')

      <div class="pull-left image">
         <img src="{{ asset('imagenes/distribuidores/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (D)</p>
         <a><i class="fa fa-circle text-success"></i> Créditos: {{ session('perfilSaldo') }}</a>
      </div>

   @elseif (session('perfilTipo') == 'H')
      <div class="pull-left image">
         <img src="{{ asset('imagenes/horecas/thumbnails/')}}/{{ session('perfilLogo') }}" class="img-rounded" >
      </div>
      <div class="pull-left info">
         <p>{{ session('perfilNombre') }} (H)</p>
         <a><i class="fa fa-circle text-success"></i> Créditos: {{ session('perfilSaldo') }}</a>
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
      <li><a href=""><i class="fa fa-circle-o"></i> Opiniones</a></li>
      <li><a href=""><i class="fa fa-circle-o"></i> Banners Publicitarios</a></li>
      <li><a href=""><i class="fa fa-circle-o"></i> Planes de Crédito</a></li>

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
               <li><a href="{{ route('marca.create') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
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
                     <li><a href="{{ route('demanda-importador.create') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                     <li><a href="{{ route('demanda-importador.index') }}"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Distribución
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('demanda-distribuidor.create') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                     <li><a href="{{ route('demanda-distribuidor.index') }}"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Confirmaciones
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('productor.confirmar-importadores') }}"><i class="fa fa-circle-o"></i> Importadores</a></li>
               <li><a href="{{ route('productor.confirmar-distribuidores') }}"><i class="fa fa-circle-o"></i> Distribuidores</a></li>
               <li><a href=""><i class="fa fa-circle-o"></i> Marcas</a></li>
               <li><a href="{{ route('productor.confirmar-productos') }}"><i class="fa fa-circle-o"></i> Productos</a></li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Demandas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="#"><i class="fa fa-circle-o"></i> Productos</a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> Importación</a></li>
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
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Ofertas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('oferta.index') }}"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
               <li><a href="{{ route('importador.ofertas-disponibles') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles</a></li>
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
                     <li><a href="{{ route('demanda-distribuidor.create') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                     <li><a href="{{ route('demanda-distribuidor.index') }}"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Producto
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('demanda-producto.create') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                     <li><a href="{{ route('demanda-producto.index') }}"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Importar Marca
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('importador.solicitar-importacion') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                     <li><a href="#"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Demandas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('demanda-importador.demandas-disponibles') }}"><i class="fa fa-circle-o"></i> Importadores</a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> Productos</a></li>
            </ul>
         </li>
         <li><a href="{{ route('importador.listado-distribuidores') }}"><i class="fa fa-circle-o"></i> Listado de Distribuidores</a></li>
         <!-- FIN DE SECCIÓN DE IMPORTADOR -->
      @endif

      @if(session('perfilTipo') == 'D')
         <!-- SECCIÓN DE IMPORTADORES -->
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
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Ofertas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('oferta.index') }}"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
               <li><a href="{{ route('distribuidor.ofertas-disponibles') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles</a></li>
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
                     <li><a href="{{ route('demanda-producto.create') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                     <li><a href="{{ route('demanda-producto.index') }}"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-share"></i> Distribuir Marca
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="#"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                     <li><a href="#"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Demandas
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('demanda-distribuidor.demandas-disponibles') }}"><i class="fa fa-circle-o"></i> Distribuidores</a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> Productos</a></li>
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
               <li><a href="{{ route('horeca.ofertas-disponibles') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles</a></li>
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
                     <li><a href="#"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                     <li><a href="#"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
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

   