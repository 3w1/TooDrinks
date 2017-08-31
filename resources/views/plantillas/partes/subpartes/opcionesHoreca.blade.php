<li class="treeview">
   <a href="#">
      <i class="fa fa-share"></i> <span>Comercialización</span>
      <span class="pull-right-container">
         <i class="fa fa-angle-left pull-right"></i>
      </span>
   </a>
   <ul class="treeview-menu">
      <li><a href="#"><i class="fa fa-circle-o"></i> Buscar Marca</a></li>
      <li><a href="{{ route('demanda-producto.create') }}}"><i class="fa fa-circle-o"></i> Buscar Producto</a></li>
      <li><a href="{{ route('demanda-producto.create') }}}"><i class="fa fa-circle-o"></i> Buscar Bebida</a></li>
      <li><a href="{{ route('demanda-producto.index') }}"><i class="fa fa-circle-o"></i> Mis Búsquedas Activas</a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i> Historial de Búsquedas</a></li>
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
      <li><a href="{{ route('oferta.disponibles') }}"><i class="fa fa-circle-o"></i> Ofertas Disponibles
         <span class="pull-right-container">
            @if($cont_NO > 0) <small class="label pull-right bg-purple">{{$cont_NO}}</small>@endif
         </span>
      </a></li>
      <li><a href="#"><i class="fa fa-circle-o"></i> Historial de Ofertas</a></li>
   </ul>
</li>

<li class="header">SORTEOS</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Inscrito</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Nuevos Sorteos</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Historial</a></li>

<li class="header">LISTADOS</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>

      