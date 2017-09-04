<li class="li"><a href="{{ route('productor.inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>

<li class="li"><a href="{{route('marca.index')}}"><i class="fa fa-diamond"></i> Marcas</a>
<li class="li"><a href="{{route('producto.index')}}"><i class="fa fa-product-hunt"></i> Productos</a></li>

<li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Mercado</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li><a href="{{ route('oferta.index') }}"><i class="fa fa-circle-o"></i> Mis Ofertas Activas</a></li>
               <li><a href="{{ route('oferta.crear-oferta', ['0','0']) }}"><i class="fa fa-circle-o"></i> Nueva Oferta</a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> Historial de Ofertas</a></li>
            </ul>
         </li>

         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Exportación</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li><a href="{{ route('demanda-importador.index') }}"><i class="fa fa-circle-o"></i> Mis Búsqueda de Importadores</a></li>
               <li><a href="{{ route('demanda-importador.create') }}"><i class="fa fa-circle-o"></i> Nueva Búsqueda de Importador</a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> Historial de Búsquedas</a></li>
            </ul>
         </li>

         <li class="treeview">
             <a href="#">
               <i class="fa fa-share"></i> <span>Distribución</span>
               <span class="pull-right-container">
                 <i class="fa fa-angle-left pull-right"></i>
               </span>
             </a>
             <ul class="treeview-menu">
               <li><a href="{{ route('demanda-distribuidor.index') }}"><i class="fa fa-circle-o"></i> Mis Búsqueda de Distribuidores</a></li>
               <li><a href="{{ route('demanda-distribuidor.create') }}"><i class="fa fa-circle-o"></i> Nueva Búsqueda de Distribuidor</a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> Historial de Búsquedas</a></li>
            </ul>
         </li>

         <li class="treeview">
            <a href="#"><i class="fa fa-share"></i> Solicitudes
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  @if($demandas > 0)<small class="label pull-right bg-blue">{{$demandas}}</small>@endif
               </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="{{ route('demanda-producto.demandas-productos-disponibles') }}"><i class="fa fa-circle-o"></i> Productos
                  <span class="pull-right-container">
                     @if($cont_DP > 0) <small class="label pull-right bg-aqua">{{$cont_DP}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('demanda-producto.demandas-bebidas-disponibles') }}"><i class="fa fa-circle-o"></i> Bebidas
                  <span class="pull-right-container">
                     @if($cont_DB > 0) <small class="label pull-right bg-aqua">{{$cont_DB}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('solicitud-importacion.solicitudes')}}"><i class="fa fa-circle-o"></i> Importación
                  <span class="pull-right-container">
                     @if($cont_SI > 0) <small class="label pull-right bg-orange">{{$cont_SI}}</small>@endif
                  </span>
               </a></li>
               <li><a href="{{ route('solicitud-distribucion.solicitudes')}}"><i class="fa fa-circle-o"></i> Distribución
                  <span class="pull-right-container">
                     @if($cont_SD > 0) <small class="label pull-right bg-green">{{$cont_SD}}</small>@endif
                  </span>
               </a></li>
               <li><a href=""><i class="fa fa-circle-o"></i> Historial de Solicitudes</a></li>
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
               <li><a href="{{ route('productor.confirmar-productos') }}"><i class="fa fa-circle-o"></i> Productos
                  <span class="pull-right-container">
                     @if($cont_NP > 0) <small class="label pull-right bg-yellow">{{$cont_NP}}</small>@endif
                  </span>
               </a></li>
               <li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>
            </ul>
         </li>

         <li class="header">Listados</li>
         <li><a href="#"><i class="fa fa-circle-o"></i> Importadores</a></li>
         <li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>
         <!-- FIN DE SECCIÓN DE PRODUCTORES -->