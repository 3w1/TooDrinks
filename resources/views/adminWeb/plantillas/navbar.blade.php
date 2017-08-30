<!-- INICIO BARRA DE NAVEGACION SUPERRIOR -->
<nav class="navbar navbar-static-top">
   <!-- BOTÓN PARA EXPANDIR/CONTRAER LA BARRA LATERAL IZQUIERDA-->
   <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
   </a>
      
   <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
         
         <!-- DROPDOWN DE NOTIFICACIONES -->
         @include('adminWeb.plantillas.dropdownNotificaciones')
         <!-- DROPDOWN DE NOTIFICACIONES -->
         
         <!-- INICIO DEL MENU PARA LA CUENTA DE USUARIO -->
         @include('adminWeb.plantillas.dropdownUsuario')
         <!-- FIN DEL MENU PARA LA CUENTA DE USUARIO -->
      </ul>
   </div>

</nav>