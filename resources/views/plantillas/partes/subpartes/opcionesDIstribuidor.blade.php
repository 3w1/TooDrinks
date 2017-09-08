<li class="li"><a href="{{route('marca.index')}}"><i class="fa fa-diamond"></i> Marcas</a></li>

<li class="li"><a href="{{route('producto.index')}}"><i class="fa fa-product-hunt"></i> Productos</a>

<li class="li"><a href="{{route('oferta.index')}}"><i class="fa fa-shopping-cart"></i> Mercado</a></li>
      
<li class="treeview">
   <a href="#">
      <i class="fa fa-share"></i> <span>Distribución</span>
      <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
      </span>
   </a>
   <ul class="treeview-menu">
      <li><a href="{{ route('solicitud-distribucion.create') }}"><i class="fa fa-circle-o"></i> Buscar Marca para Distribuir</a></li>
      <li><a href="{{ route('demanda-producto.create') }}"><i class="fa fa-circle-o"></i> Buscar Bebida para Distribuir</a></li>
      <li><a href="{{ route('solicitud-distribucion.index') }}"><i class="fa fa-circle-o"></i> Mis Búsquedas Activas</a></li>
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
      <li><a href="#"><i class="fa fa-circle-o"></i> Marca</a></li>
      <li><a href="{{ route('demanda-producto.demandas-productos-disponibles') }}"><i class="fa fa-circle-o"></i> Producto
         <span class="pull-right-container">
            @if($cont_DP > 0) <small class="label pull-right bg-aqua">{{$cont_DP}}</small>@endif
         </span>
      </a></li>
      <li><a href="{{ route('demanda-producto.demandas-bebidas-disponibles') }}"><i class="fa fa-circle-o"></i> Bebida
         <span class="pull-right-container">
            @if($cont_DB > 0) <small class="label pull-right bg-aqua">{{$cont_DB}}</small>@endif
         </span>
      </a></li>
      <li><a href="{{ route('demanda-distribuidor.demandas-disponibles') }}"><i class="fa fa-circle-o"></i> 
         <span class="pull-right-container">
            @if($cont_DD > 0) <small class="label pull-right bg-green">{{$cont_DD}}</small>@endif
         </span>
      Distribuidor</a></li>
      <li><a href=""><i class="fa fa-circle-o"></i> Historial de Solicitudes</a></li>
   </ul>
</li>

<li class="header">LISTADOS</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Mis Productores</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Mis Importadores</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Mis Horecas</a></li>
      