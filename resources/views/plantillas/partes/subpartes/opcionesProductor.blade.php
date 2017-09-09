<li class="li"><a href="{{ route('productor.inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>

<li class="li"><a href="{{route('marca.index')}}"><i class="fa fa-diamond"></i> Marcas</a>

<li class="li"><a href="{{route('producto.index')}}"><i class="fa fa-product-hunt"></i> Productos</a></li>

<li class="li"><a href="{{route('oferta.index')}}"><i class="fa fa-shopping-cart"></i> Mercado</a></li>

<li class="li"><a href="{{route('demanda-importador.index')}}"><i class="fa fa-user-plus"></i> Exportación</a></li>

<li class="li"><a href="{{route('demanda-distribuidor.index')}}"><i class="fa fa-user-plus"></i> Distribución</a></li>

<li class="li"><a href="{{route('demanda-producto.demandas-productos-disponibles')}}"><i class="fa fa-handshake-o"></i> Solicitudes</a></li>

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