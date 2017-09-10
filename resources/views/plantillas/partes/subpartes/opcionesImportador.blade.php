<li class="li"><a href="{{route('marca.index')}}"><i class="fa fa-diamond"></i> Marcas</a></li>

<li class="li"><a href="{{route('producto.index')}}"><i class="fa fa-product-hunt"></i> Productos</a>

<li class="li"><a href="{{route('oferta.index')}}"><i class="fa fa-shopping-cart"></i> Mercado</a></li>

<li class="li"><a href="{{route('solicitud-importacion.index')}}"><i class="fa fa-hand-o-up"></i> Importación</a></li>

<li class="li"><a href="{{route('demanda-distribuidor.index')}}"><i class="fa fa-user-plus"></i> Distribución</a></li>

<li class="li"><a href="{{route('demanda-producto.demandas-productos-disponibles')}}"><i class="fa fa-handshake-o"></i> Solicitudes</a></li>
 
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
      <li><a href="{{ route('demanda-importador.demandas-disponibles') }}"><i class="fa fa-circle-o"></i> Importación
         <span class="pull-right-container">
            @if($cont_DI > 0) <small class="label pull-right bg-orange">{{$cont_DI}}</small>@endif
         </span>
      </a></li>
      <li><a href="{{ route('solicitud-distribucion.solicitudes')}}"><i class="fa fa-circle-o"></i> Distribución
         <span class="pull-right-container">
            @if($cont_AD > 0) <small class="label pull-right bg-red">{{$cont_AD}}</small>@endif
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
      <li><a href="#"><i class="fa fa-circle-o"></i> Distribuidores</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i> Historial de Confirmaciones</a></li>
   </ul>
</li> 

<li class="header">Listados</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>
      