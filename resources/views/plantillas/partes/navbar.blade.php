{!! Html::script('js/credito/refrescarCreditos.js') !!}
<!-- INICIO BARRA DE NAVEGACION SUPERRIOR -->
<nav class="navbar navbar-static-top">
   <!-- BOTÓN PARA EXPANDIR/CONTRAER LA BARRA LATERAL IZQUIERDA-->
   <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
   </a>
      
   <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
         <li><a href="#" onclick="refrescarCreditos();"><i class="fa fa-refresh"></i></a></li>
         <li class="active">
            <a href="#">
               Créditos: <span id="creditos"><strong>{{session('perfilSaldo')}}</span> <i class="fa fa-asterisk"></i></strong>
            </a>
         </li>

         <!-- DROPDOWN DE NOTIFICACIONES -->
         @include('plantillas.partes.subpartes/dropdownNotificaciones')
         <!-- DROPDOWN DE NOTIFICACIONES -->

         <!-- INICIO DEL MENU PARA LA CUENTA DE USUARIO -->
         @include('plantillas.partes/subpartes/dropdownUsuario')
         <!-- FIN DEL MENU PARA LA CUENTA DE USUARIO -->
      </ul>
   </div>

</nav>