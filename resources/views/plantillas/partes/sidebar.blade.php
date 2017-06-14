<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/usuarios/thumbnails/')}}/{{ Auth::user()->avatar }}" class="img-rounded" >
   </div>
   <div class="pull-left info">
      <p>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
      <a href="#"><i class="fa fa-circle text-success"></i> Usuario Propietario</a>
   </div>
</div>

<ul class="sidebar-menu">
   @if (Auth::user()->activado == 1)
      <li class="header">Opciones de Usuario</li>

      <li><a href=""><i class="fa fa-circle-o"></i> Opiniones</a></li>
      <li><a href=""><i class="fa fa-circle-o"></i> Banners Publicitarios</a></li>
      <li><a href=""><i class="fa fa-circle-o"></i> Planes de Crédito</a></li>

      @if(Auth::user()->productor == '1')
         <!-- SECCIÓN DE PRODUCTORES -->
         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Productor</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Marcas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('productor.marcas') }}"><i class="fa fa-circle-o"></i> Mis Marcas</a></li>
                     <li><a href="{{ route('productor.marcas-disponibles') }}"><i class="fa fa-circle-o"></i> Marcas Disponibles</a></li>
                     <li><a href="{{ route('productor.registrar-marca') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Ofertas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('productor.ofertas') }}"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
                     <li><a href="{{ route('productor.registrar-oferta', ['0','0']) }}"><i class="fa fa-circle-o"></i> Nueva Oferta</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Solicitudes
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
                          <li><a href="{{ route('productor.solicitar-importador') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                          <li><a href="{{ route('productor.demandas-importadores') }}"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                        </ul>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Distribución
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{ route('productor.solicitar-distribuidor') }}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                          <li><a href="{{ route('productor.demandas-distribuidores') }}"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                        </ul>
                     </li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Confirmaciones
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href=""><i class="fa fa-circle-o"></i> Importadores</a></li>
                     <li><a href=""><i class="fa fa-circle-o"></i> Distribuidores</a></li>
                     <li><a href=""><i class="fa fa-circle-o"></i> Marcas</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Demandas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="#"><i class="fa fa-circle-o"></i> Productos</a></li>
                     <li><a href="#"><i class="fa fa-circle-o"></i> Importación</a></li>
                  </ul>
               </li>
               <li><a href=""><i class="fa fa-circle-o"></i> Listado de Importadores</a></li>
            </ul>
         </li>
         <!-- FIN DE SECCIÓN DE PRODUCTORES -->
      @endif
      
      @if(Auth::user()->importador == '1')
         <!-- SECCIÓN DE IMPORTADOR -->
         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Importador</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Marcas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('importador.marcas') }}"><i class="fa fa-circle-o"></i> Mis Marcas</a></li>
                     <li><a href="{{ route('importador.marcas-disponibles') }}"><i class="fa fa-circle-o"></i> Marcas Disponibles</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Ofertas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('importador.ofertas') }}"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
                     <li><a href="{{ route('importador.ofertas-disponibles') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles</a></li>
                     <li><a href="{{ route('importador.registrar-oferta', ['0','0']) }}"><i class="fa fa-circle-o"></i> Nueva Oferta</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Solicitudes
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
                          <li><a href="#"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
                          <li><a href="#"><i class="fa fa-circle-o"></i> Ver Mis Solicitudes</a></li>
                        </ul>
                     </li>
                     <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Producto
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
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Demandas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="#"><i class="fa fa-circle-o"></i> Importadores</a></li>
                     <li><a href="#"><i class="fa fa-circle-o"></i> Productos</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <!-- FIN DE SECCIÓN DE IMPORTADOR -->
      @endif

      @if(Auth::user()->distribuidor == '1')
         <!-- SECCIÓN DE IMPORTADORES -->
         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Distribuidor</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Marcas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('distribuidor.marcas') }}"><i class="fa fa-circle-o"></i> Mis Marcas</a></li>
                     <li><a href="{{ route('distribuidor.marcas-disponibles') }}"><i class="fa fa-circle-o"></i> Marcas Disponibles</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Ofertas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="#"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
                     <li><a href="{{ route('distribuidor.ofertas-disponibles') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles</a></li>
                     <li><a href="{{ route('distribuidor.registrar-oferta', ['0','0']) }}"><i class="fa fa-circle-o"></i> Nueva Oferta</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Solicitudes
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Producto
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
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Demandas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="#"><i class="fa fa-circle-o"></i> Productos</a></li>
                     <li><a href="#"><i class="fa fa-circle-o"></i> Distribuidores</a></li>
                  </ul>
               </li>
            </ul>
         </li>
         <!-- FIN DE SECCIÓN DE DISTRIBUIDORES -->
      @endif

      @if(Auth::user()->horeca == '1')
        <!-- SECCIÓN DE HORECAS -->
         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Horeca</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Ofertas
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="{{ route('horeca.ofertas-disponibles') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles</a></li>
                  </ul>
               </li>
               <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Solicitudes
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Producto
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
            </ul>
         </li>
         <!-- FIN DE SECCIÓN DE HORECAS -->
      @endif
   @endif
</ul>