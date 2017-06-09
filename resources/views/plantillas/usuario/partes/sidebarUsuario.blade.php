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
   <li class="header">opciones</li>
   

   <!-- SECCIÓN DE PRODUCTORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Productores</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('usuario.productores')}}"><i class="fa fa-circle-o"></i> Mis Productores</a></li>
         <li><a href="{{ route('usuario.registrar-productor') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Productores Sin Reclamar</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE PRODUCTORES -->

    <!-- SECCIÓN DE IMPORTADORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Importadores</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('usuario.importadores')}}"><i class="fa fa-circle-o"></i> Mis Importadores</a></li>
         <li><a href="{{ route('usuario.registrar-importador') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Importadores Sin Reclamar</a></li>
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
         <li><a href="{{ route('usuario.distribuidores') }}"><i class="fa fa-circle-o"></i> Mis Distribuidores</a></li>
         <li><a href="{{ route('usuario.registrar-distribuidor') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Distribuidores sin Reclamar</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE DISTRIBUIDORES -->

   <!-- SECCIÓN DE HORECAS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Horecas</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('usuario.horecas') }}"><i class="fa fa-circle-o"></i> Mis Horecas</a></li>
         <li><a href="{{ route('usuario.registrar-horeca') }}"><i class="fa fa-circle-o"></i>Crear Nuevo</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Horecas Sin Reclamar</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE HORECAS -->

   <!-- SECCIÓN DE PRODUCTOS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Productos</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('usuario.registrar-producto') }}"><i class="fa fa-circle-o"></i> Crear nuevo</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i>Ver Productos creados</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE PRODUCTOS -->
   
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
</ul>