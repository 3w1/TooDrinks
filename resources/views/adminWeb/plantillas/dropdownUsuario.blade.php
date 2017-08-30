<li class="dropdown user user-menu">

   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <img src="{{ asset('imagenes/admins/thumbnails/')}}/{{ session('adminAvatar') }}" class="user-image" alt="User Image">
      <span class="hidden-xs">{{ session('adminName')}}</span>
   </a>

   <ul class="dropdown-menu">
      <!-- User image -->
      <li class="user-header">
         <img src="{{ asset('imagenes/admins/thumbnails')}}/{{ session('adminAvatar') }}" class="img-circle">
         <p>
            {{ session('adminNombre') }}
            @if (session('adminRol') == 'AD')
               <small>AdminWeb</small>
            @elseif (session('adminRol') == 'SA')
               <small>SuperAdmin</small>
            @endif
         </p>
      </li>

      <!-- INICIO DEL MENU DEL FOOTER DE CUENTA DE USUARIO-->
      <li class="user-footer">
         <div class="pull-left">
            <a href="#" class="btn btn-default btn-flat">Perfil</a>
         </div>
         <div class="pull-right">
            <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Salir</a>
         </div>
      </li>
      <!-- FIN DEL MENU DEL FOOTER DE CUENTA DE USUARIO-->
   </ul>
</li>

