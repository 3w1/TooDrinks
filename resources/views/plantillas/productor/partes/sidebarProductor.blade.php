<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/productores/')}}/{{ session('productorLogo') }}" class="img-circle" alt="User Image">
   </div>
   <div class="pull-left info">
      <p>{{ session('productorNombre') }} </p>
      <a href="{{ route('productor.edit', session('productorId')) }}"><i class="fa fa-edit text-info"></i> Editar Perfil</a>
   </div>
</div>
<ul class="sidebar-menu">
   <li class="header">PRODUCTOR</li>
   

   <!-- SECCIÓN DE IMPORTADORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Importadores</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href=""><i class="fa fa-circle-o"></i> Listado</a></li>
         <li><a href="{{ route('productor.registrar-importador') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE IMPORTADORES -->

     <!-- SECCIÓN DE DISTRIBUIDORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Distribuidores</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href=""><i class="fa fa-circle-o"></i> Listado</a></li>
         <li><a href="{{ route('productor.registrar-distribuidor') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE DISTRIBUIDORES -->

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

   <!-- SECCIÓN DE PRODUCTOS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Productos</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href=""><i class="fa fa-circle-o"></i> Listado</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE PRODUCTOS -->

   <!-- SECCIÓN DE  OFERTAS -->
   <li class="treeview">
      <a href=""><i class="fa fa-circle-o text-yellow"></i> <span>Crear Oferta</span></a>
   </li>
   <!-- FIN DE SECCIÓN DE OFERTAS -->

   <!-- SECCIÓN DE DEMANDAS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Demandas</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href=""><i class="fa fa-circle-o"></i>solicitar Importador</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Solicitar Distribuidor</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE DEMANDAS -->
   
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