<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/horecas/')}}/{{ session('perfilLogo') }}" class="img-circle" alt="User Image">
   </div>
   <div class="pull-left info">
      <p>{{ session('perfilNombre') }}</p>
      <a href="{{ route('horeca.edit', session('perfilId')) }}"><i class="fa fa-edit text-info"></i> Editar Perfil</a>
   </div>
</div>
<ul class="sidebar-menu">
   <li class="header">HORECA</li>

   <!-- SECCIÓN DE  OFERTAS -->
   <li class="treeview">
      <a href=""><i class="fa fa-circle-o text-yellow"></i> <span>Ver Ofertas</span></a>
   </li>
   <!-- FIN DE SECCIÓN DE OFERTAS -->

   <!-- SECCIÓN DE DEMANDDAS DE PRODUCTO -->
   <li class="treeview">
      <a href=""><i class="fa fa-circle-o text-yellow"></i> <span>Crear Demanda de Producto</span></a>
   </li>
   <!-- FIN DE SECCIÓN DE DEMANDDAS DE PRODUCTO -->

   <!-- SECCIÓN DE  OFERTAS -->
   <li class="treeview">
      <a href=""><i class="fa fa-circle-o text-yellow"></i> <span>Ver Distribuidores</span></a>
   </li>
   <!-- FIN DE SECCIÓN DE OFERTAS -->
   
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