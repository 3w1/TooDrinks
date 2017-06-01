<div class="user-panel">
   <div class="pull-left image">
      <img src="{{ asset('imagenes/usuarios/')}}/{{ Auth::user()->avatar }}" class="img-circle" alt="User Image">
   </div>
   <div class="pull-left info">
      <p>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
   </div>
</div>
<ul class="sidebar-menu">
   <li class="header">Título</li>
   
   <!-- SECCIÓN DE USUARIOS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Usuario</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('usuario'); !!}"><i class="fa fa-circle-o"></i> Lista de Usuarios</a></li>
         <li><a href="{!! url('usuario/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE USUARIOS -->

   <!-- SECCIÓN DE PRODUCTORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Productor</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('productor'); !!}"><i class="fa fa-circle-o"></i> Lista de Productores</a></li>
         <li><a href="{!! url('productor/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE PRODUCTORES -->

    <!-- SECCIÓN DE IMPORTADORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Importador</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('importador'); !!}"><i class="fa fa-circle-o"></i> Lista de Importadores</a></li>
         <li><a href="{!! url('importador/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE IMPORTADORES -->

     <!-- SECCIÓN DE DISTRIBUIDORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Distribuidor</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('distribuidor'); !!}"><i class="fa fa-circle-o"></i> Lista de Distribuidores</a></li>
         <li><a href="{!! url('distribuidor/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE DISTRIBUIDORES -->

   <!-- SECCIÓN DE HORECAS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-user"></i> <span>Horeca</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('horeca'); !!}"><i class="fa fa-circle-o"></i> Lista de Horecas</a></li>
         <li><a href="{!! url('horeca/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE HORECAS -->

   <!-- SECCIÓN DE PRODUCTOS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-product-hunt"></i> <span>Producto</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('producto'); !!}"><i class="fa fa-circle-o"></i> Lista de Productos</a></li>
         <li><a href="{!! url('producto/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
         <li><a href="{!! url('bebida/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo Tipo de Bebida</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE PRODUCTOS -->
   
   <!-- SECCIÓN DE MARCAS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-ravelry"></i> <span>Marca</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('marca'); !!}"><i class="fa fa-circle-o"></i> Lista de Marcas</a></li>
         <li><a href="{!! url('marca/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE MARCAS -->

    <!-- SECCIÓN DE MARCAS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-asterisk"></i> <span> Oferta</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('oferta'); !!}"><i class="fa fa-circle-o"></i> Lista de Ofertas</a></li>
         <li><a href="{!! url('oferta/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nueva</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE MARCAS -->

   <!-- SECCIÓN DE DEMANDAS DE PRODUCTOS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-book"></i> <span>Demanda de Producto </span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('demanda-producto'); !!}"><i class="fa fa-circle-o"></i> Lista de Demandas de Productos </a></li>
         <li><a href="{!! url('demanda-producto/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE DEMANDAS DE PRODUCTOS -->

   <!-- SECCIÓN DE DEMANDAS DE IMPORTADORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-book"></i> <span>Demanda de Importador </span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('demanda-importador'); !!}"><i class="fa fa-circle-o"></i> Lista de Demandas de Importadores </a></li>
         <li><a href="{!! url('demanda-importador/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE DEMANDAS DE IMPORTADORES -->
   
    <!-- SECCIÓN DE DEMANDAS DE DISTRIBUIDORES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-book"></i> <span>Demanda de Distribuidor </span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('demanda-distribuidor'); !!}"><i class="fa fa-circle-o"></i> Lista de Demandas de Distribuidores </a></li>
         <li><a href="{!! url('demanda-distribuidor/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE DEMANDAS DE DISTRIBUIDORES -->
   
    <!-- SECCIÓN DE CRÉDITOS -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-certificate"></i> <span>Plan de Crédito</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('credito'); !!}"><i class="fa fa-circle-o"></i> Lista de Planes</a></li>
         <li><a href="{!! url('credito/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
         <li><a href="{!! url('credito/show'); !!}"><i class="fa fa-circle-o"></i> Catalogo de Planes</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE CRÉDITOS -->

    <!-- SECCIÓN DE SUSCRIPCIONES -->
   <li class="treeview">
      <a href="#">
         <i class="fa fa-certificate"></i> <span>Suscripciones</span>
         <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
      <ul class="treeview-menu">
         <li><a href="{!! url('suscripcion'); !!}"><i class="fa fa-circle-o"></i> Lista de suscripciones</a></li>
         <li><a href="{!! url('suscripcion/create'); !!}"><i class="fa fa-circle-o"></i> Crear Nuevo</a></li>
      </ul>
   </li>
   <!-- FIN DE SECCIÓN DE SUSCRIPCIONES -->

   <!-- FIN DE UNA SECCIÓN DEL PANEL -->

   <li class="header">OTRAS OPCIONES</li>
   <!-- INICIO DE UNA SECCIÓN DEL PANEL -->
   <li>
      <a href="">
         <i class="fa fa-circle-o text-red"></i> <span>Estadísticas</span>
         <span class="pull-right-container">
            <small class="label pull-right bg-green">new</small>
         </span>
      </a>
   </li>
   <li><a href="{!! url('opinion') !!}"><i class="fa fa-circle-o text-yellow"></i> <span>Opinion</span></a></li>
</ul>