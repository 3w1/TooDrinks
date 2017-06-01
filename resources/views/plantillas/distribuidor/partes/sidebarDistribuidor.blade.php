<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/distribuidores/')}}/{{ $distribuidor->logo }}" class="img-circle" alt="User Image">
   </div>
   <div class="pull-left info">
      <p>{{ $distribuidor->nombre }}</p>
      <a href="{{ route('distribuidor.edit', $distribuidor->id) }}"><i class="fa fa-edit text-info"></i> Editar Perfil</a>
   </div>
</div>
<ul class="sidebar-menu">
   <li class="header">DISTRIBUIDOR</li>
   

   <!-- SECCIÓN DE MARCAS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Marcas</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href=""><i class="fa fa-circle-o"></i> Listado</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Crear Nueva</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE MARCAS -->

   <!-- SECCIÓN DE  OFERTAS -->
   <li class="treeview">
      <a href=""><i class="fa fa-circle-o text-yellow"></i> <span>Crear Oferta</span></a>
   </li>
   <!-- FIN DE SECCIÓN DE OFERTAS -->

   <!-- SECCIÓN DE DEMANDDAS DE PRODUCTO -->
   <li class="treeview">
      <a href=""><i class="fa fa-circle-o text-yellow"></i> <span>Crear Demanda de Producto</span></a>
   </li>
   <!-- FIN DE SECCIÓN DE DEMANDDAS DE PRODUCTO -->
   
   <!-- FIN DE UNA SECCIÓN DEL PANEL -->

   <li class="header">OTRAS OPCIONES</li>
   <!-- INICIO DE UNA SECCIÓN DEL PANEL -->
   <li>
      <a href="">
         <i class="fa fa-circle-o text-red"></i> <span>Banners Publicitarios</span>
         <span class="pull-right-container">
            <small class="label pull-right bg-green">new</small>
         </span>
      </a>
   </li>
   <li><a href=""><i class="fa fa-circle-o text-yellow"></i> <span>Opiniones</span></a></li>
   <li><a href=""><i class="fa fa-circle-o text-yellow"></i> <span>Planes de Crédito</span></a></li>

    <li class="header">OTRAS OPCIONES</li>
    <li><a href="{{ url('usuario') }}"><i class="fa fa-user"></i><span>Regresar al Perfil de Usuario</span></a></li>
</ul>