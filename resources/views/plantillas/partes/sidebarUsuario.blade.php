<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/usuarios/')}}/{{ Auth::user()->avatar }}" class="img-circle" alt="User Image">
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
         <li><a href=""><i class="fa fa-circle-o"></i> Productores Sin Propietario</a></li>
         <li><a href="{{ route('productor.create') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
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
         <li><a href=""><i class="fa fa-circle-o"></i> Importadores Sin Propietario</a></li>
         <li><a href="{{ route('importador.create') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
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
         <li><a href=""><i class="fa fa-circle-o"></i> Distribuidores Sin Propietario</a></li>
         <li><a href="{{ route('usuario.registrar-distribuidor') }}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
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
         <li><a href=""><i class="fa fa-circle-o"></i>Horecas Sin Propietario</a></li>
         <li><a href="{{ route('usuario.registrar-horeca') }}"><i class="fa fa-circle-o"></i>Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE HORECAS -->
   
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