<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/usuarios/thumbnails/')}}/{{ Auth::user()->avatar }}" class="img-rounded" >
   </div>
   <div class="pull-left info">
      <p>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
      <a><i class="fa fa-circle text-success"></i> Admin WEB</a>
   </div>
</div>

<ul class="sidebar-menu">
   <li class="header">Opciones de Usuario</li>

   <li><a href="{{ route('usuario.inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
   
   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Marcas</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('admin.marcas-sin-aprobar') }}"><i class="fa fa-circle-o"></i> Aprobar Marcas</a></li>
         <li><a href="{{ route('admin.marcas-sin-propietario') }}"><i class="fa fa-circle-o"></i> Asociar Marca / Productor</a></li>
         <li><a href="{{ route('admin.confirmar-importadores') }}"><i class="fa fa-circle-o"></i> Confirmar Importador / Marca</a></li>
         <li><a href="{{ route('admin.confirmar-distribuidores') }}"><i class="fa fa-circle-o"></i> Confirmar Distribuidor / Marca</a></li>
         <li><a href="#"><i class="fa fa-circle-o"></i> Crear Marca</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Productos</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('admin.productos-sin-aprobar') }}"><i class="fa fa-circle-o"></i> Aprobar Productos</a></li>
         <li><a href="#"><i class="fa fa-circle-o"></i> Crear Producto</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Perfiles</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href=""><i class="fa fa-circle-o"></i> Crear Productor</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Crear Importador</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Crear Distribuidor</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Crear Horeca</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Suscripciones</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href=""><i class="fa fa-circle-o"></i> Lista de Suscripciones</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Crear Suscripcion</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Planes de Crédito</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href=""><i class="fa fa-circle-o"></i> Lista de Planes</a></li>
         <li><a href=""><i class="fa fa-circle-o"></i> Crear Plan</a></li>
      </ul>
   </li>

   <li><a href=""><i class="fa fa-circle-o"></i> Banners Publicitarios</a></li>
</ul>

   