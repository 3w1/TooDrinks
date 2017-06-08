<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/productores/thumbnails/')}}/{{ session('productorLogo') }}" class="img-rounded" >
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
         <li><a href="{{ route('productor.importadores') }}"><i class="fa fa-circle-o"></i> Mis Importadores</a></li>
         <li><a href="{{ route('productor.registrar-importador') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Importadores Disponibles</a></li>
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
         <li><a href="{{ route('productor.distribuidores') }}"><i class="fa fa-circle-o"></i> Mis Distribuidores</a></li>
         <li><a href="{{ route('productor.registrar-distribuidor') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Distribuidores Disponibles</a></li>
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
         <li><a href="{{ route('productor.marcas') }}"><i class="fa fa-circle-o"></i> Mis Marcas</a></li>
         <li><a href="{{ route('productor.registrar-marca') }}"><i class="fa fa-circle-o"></i>Crear Nueva</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Marcas sin Reclamar</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE MARCAS -->

   <!-- SECCIÓN DE  OFERTAS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Ofertas</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('productor.ofertas') }}"><i class="fa fa-circle-o"></i> Mis Ofertas</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Crear Nueva</a></li>
      </ul>
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
         <li><a href="{{ route('productor.solicitar-importador') }}"><i class="fa fa-circle-o"></i>Solicitar Importador</a></li>
         <li><a href="{{ route('productor.solicitar-distribuidor') }}"><i class="fa fa-circle-o"></i>Solicitar Distribuidor</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Ver mis Demandas</a></li>
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