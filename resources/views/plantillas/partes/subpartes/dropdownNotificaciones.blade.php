<li class="dropdown notifications-menu">
   @if (session('perfilTipo') == 'P')
      <?php 
         $notificaciones = DB::table('notificacion_p')
                           ->select('titulo', 'url', 'color', 'icono')
                           ->orderBy('created_at', 'DESC')
                           ->take(5)
                           ->get();
         $cont = 0;
         foreach($notificaciones as $notificacion){
            $cont++;
         }
       ?>
   @elseif (session('perfilTipo') == 'I')
       <?php 
         $notificaciones = DB::table('notificacion_i')
                           ->select('titulo', 'url', 'color', 'icono')
                           ->orderBy('created_at', 'DESC')
                           ->take(5)
                           ->get();
         $cont = 0;
         foreach($notificaciones as $notificacion){
            $cont++;
         }
       ?>
   @elseif (session('perfilTipo') == 'D')
       <?php 
         $notificaciones = DB::table('notificacion_d')
                           ->select('titulo', 'url', 'color', 'icono')
                           ->orderBy('created_at', 'DESC')
                           ->take(5)
                           ->get();
         $cont = 0;
         foreach($notificaciones as $notificacion){
            $cont++;
         }
       ?>
   @elseif (session('perfilTipo') == 'H')
       <?php 
         $notificaciones = DB::table('notificacion_h')
                           ->select('titulo', 'url', 'color', 'icono')
                           ->orderBy('created_at', 'DESC')
                           ->take(5)
                           ->get();
         $cont = 0;
         foreach($notificaciones as $notificacion){
            $cont++;
         }
       ?>
   @endif
   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
      <span class="label label-success">{{ $cont }}</span>
   </a>

   <ul class="dropdown-menu">
      <li class="header"><strong>Usted tiene {{ $cont }} notificacones sin leer</strong></li>
      <li>
         <!-- INICIO DE LA LISTA DONDE SE CARGARÁN LAS NOTIFICACIONES -->
         <ul class="menu">
            @foreach ($notificaciones as $notificacion)
               <li>
                  <a href="{{ url($notificacion->url) }}"> <i class="{{ $notificacion->icono }} {{ $notificacion->color }}"></i> {{$notificacion->titulo}}</a>
                  </li>
            @endforeach
         </ul>
         <!-- FIN DE LA LISTA DONDE SE CARGARÁN LAS NOTIFICACIONES -->
      </li>
      <li class="footer"><a href="{{ route('notificacion.index') }}">Ver Todas</a></li>
   </ul>
</li>