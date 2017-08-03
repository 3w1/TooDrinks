 <div class="topnav hidden-xs">
    <div class="container">
         <ul class="quick-menu pull-left">
            @if (Auth::check())
               @if (Auth::user()->rol == 'MB')
                  <li><a href="{{route('inicio')}}">Mi Panel TooDrinks</a></li>
               @endif
            @endif
         </ul>
        <ul class="quick-menu pull-right">
        	@if (Auth::guest())
	         <li><a href="#travelo-login" class="soap-popupbox">Iniciar Sesión</a></li>
	         <li><a href="#travelo-signup" class="soap-popupbox">Registrarse</a></li>
	      @else
	        	<li class="ribbon">
               <a href="#">{{Auth::user()->name}}</a>
               <ul class="menu mini">
                  @if (Auth::check())
                     @if (Auth::user()->rol == 'MB')
                        <li><a href="{{route('inicio')}}">Mi Panel TooDrinks</a></li>
                     @endif
                  @endif
                  <li><a href="#" title="Deutsch">Mi Perfil</a></li>
                  <li>
                     <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Salir
                     </a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                     </form>
                  </li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</div>