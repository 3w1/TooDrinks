<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/admins/thumbnails/')}}/{{ session('adminAvatar') }}" class="img-rounded" >
   </div>
   <div class="pull-left info">
      <p>{{ session('adminNombre') }}</p>
      @if (session('adminRol') == 'AD')
         <a><i class="fa fa-circle text-success"></i> Admin WEB</a>
      @else 
         <a><i class="fa fa-circle text-success"></i> SuperAdmin</a>
      @endif
   </div>
</div>

<ul class="sidebar-menu">
   <li class="header">Principal</li>

   <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
   
   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Productor</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('admin.crear-productor') }}"><i class="fa fa-circle-o"></i> Crear Productor</a></li>
         <li><a href="{{ route('admin.listado-productores') }}"><i class="fa fa-circle-o"></i> Listado de Productores</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Importador</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('admin.crear-importador') }}"><i class="fa fa-circle-o"></i> Crear Importador</a></li>
         <li><a href="{{ route('admin.listado-importadores') }}"><i class="fa fa-circle-o"></i> Listado de Importadores</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Distribuidor</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('admin.crear-distribuidor') }}"><i class="fa fa-circle-o"></i> Crear Distribuidor</a></li>
         <li><a href="{{ route('admin.listado-distribuidores') }}"><i class="fa fa-circle-o"></i> Listado de Distribuidores</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Horeca</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('admin.crear-horeca') }}"><i class="fa fa-circle-o"></i> Crear Horeca</a></li>
         <li><a href="{{ route('admin.listado-horecas') }}"><i class="fa fa-circle-o"></i> Listado de Horecas</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Marcas</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('admin.crear-marca') }}"><i class="fa fa-circle-o"></i> Crear Marca</a></li>
         <li><a href="{{ route('admin.marcas-sin-propietario') }}"><i class="fa fa-circle-o"></i> Asociar Marca</a></li>
         <li><a href="{{ route('admin.listado-marcas')}}"><i class="fa fa-circle-o"></i> Listado de Marcas</a></li>
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
         <li><a href="{{ route('admin.crear-producto')}}"><i class="fa fa-circle-o"></i> Crear Producto</a></li>
         <li><a href="{{ route('admin.productos-sin-marca') }}"><i class="fa fa-circle-o"></i> Asociar Producto</a></li>
         <li><a href="{{ route('admin.listado-productos')}}"><i class="fa fa-circle-o"></i> Listado de Productos</a></li>
      </ul>
   </li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Confirmaciones</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <!--<li><a href="#"><i class="fa fa-circle-o"></i> Productor</a></li>
         <li><a href="#"><i class="fa fa-circle-o"></i> Importador</a></li>
         <li><a href="#"><i class="fa fa-circle-o"></i> Distribuidor</a></li>
         <li><a href="#"><i class="fa fa-circle-o"></i> Horeca</a></li>-->
         <li><a href="{{ route('admin.marcas-sin-aprobar') }}"><i class="fa fa-circle-o"></i> Marca</a></li>
         <li><a href="{{ route('admin.productos-sin-aprobar') }}"><i class="fa fa-circle-o"></i> Producto</a></li>
      </ul>
   </li>

   <li class="header">Publicidad</li>

   <li class="treeview">
      <a href="#">
         <i class="fa fa-share"></i> <span>Publicidad</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{{ route('admin.nuevo-banner') }}"><i class="fa fa-circle-o"></i> Crear Banner</a></li>
         <li><a href="{{ route('admin.editar-banner') }}"><i class="fa fa-circle-o"></i> Editar Banner </a></li>
         <li><a href="{{ route('admin.publicar-banner') }}"><i class="fa fa-circle-o"></i> Publicar Banner</a></li>
         <!--@if (session('adminRol') == 'SA')
            <li><a href="#"><i class="fa fa-circle-o"></i> Editar Publicación</a></li>
         @endif-->
         <li><a href="{{ route('admin.publicaciones-en-curso') }}"><i class="fa fa-circle-o"></i> Publicaciones en Curso</a></li>
         <li><a href="{{ route('admin.historial-de-publicaciones') }}"><i class="fa fa-circle-o"></i> Historial de Publicaciones</a></li>
      </ul>
   </li>
   
   <!--@if (session('adminRol') == 'SA')
      <li class="header">Finanzas</li>
      
      <li class="treeview">
         <a href="#">
            <i class="fa fa-share"></i> <span>Suscripciones</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
            </span>
         </a>
         <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Añadir Suscripción</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Editar Suscripción</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Listado de Suscripciones</a></li>
         </ul>
      </li>

      <li class="treeview">
         <a href="#">
            <i class="fa fa-share"></i> <span>Créditos</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
            </span>
         </a>
         <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Añadir/Quitar Créditos</a></li>
         </ul>
      </li>

      <li class="treeview">
         <a href="#">
            <i class="fa fa-share"></i> <span>Facturación</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
            </span>
         </a>
         <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Listado de Facturación</a></li>
         </ul>
      </li>
      
      <li class="treeview">
         <a href="#">
            <i class="fa fa-share"></i> <span>Historial</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
            </span>
         </a>
         <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Listado de Movimientos</a></li>
         </ul>
      </li>
   @endif-->
</ul>

   