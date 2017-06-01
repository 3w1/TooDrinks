<li class="dropdown user user-menu">

   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <img src="{{ asset('imagenes/usuarios/')}}/{{ Auth::user()->avatar }}" class="user-image" alt="User Image">
      <span class="hidden-xs">{{ Auth::User()->name }}</span>
   </a>

   <ul class="dropdown-menu">
      <!-- User image -->
      <li class="user-header">
         <img src="{{ asset('imagenes/usuarios/')}}/{{ Auth::user()->avatar }}" class="img-circle" alt="{{ Auth::user()->avatar }}">
         <p>
            {{ Auth::User()->nombre }} {{ Auth::User()->apellido }}
            <small>Miembro desde {{ Auth::User()->created_at->format('d-m-Y') }}</small>
         </p>
      </li>

      <!-- INICIO DEL MENU INFERIOR DE LAS OPCIONES DE LA CUENTA DE USUARIO -->
      <li class="user-body">
         <div class="row">
            <div class="col-xs-4 text-center">
               <a href="#">Productos</a>
            </div>
            <div class="col-xs-4 text-center">
               <a href="#">Ofertas</a>
            </div>
            <div class="col-xs-4 text-center">
               <a href="#">Marcas</a>
            </div>
         </div>
      </li>
      <!-- FIN DEL MENU INFERIOR DE CUENTA DE USUARIO -->

      <!-- INICIO DEL MENU DEL FOOTER DE CUENTA DE USUARIO-->
      <li class="user-footer">
         <div class="pull-left">
            <a href="{{ route('usuario.edit', Auth::user()->id) }}" class="btn btn-default btn-flat">Perfil</a>
         </div>
         <div class="pull-right">
            <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Salir</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
         </div>
      </li>
      <!-- FIN DEL MENU DEL FOOTER DE CUENTA DE USUARIO-->
   </ul>
</li>

