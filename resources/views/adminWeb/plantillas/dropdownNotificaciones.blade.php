<li class="dropdown notifications-menu">
   <?php 
      $notificaciones_pendientes = DB::table('notificacion_admin')
                                    ->where('admin_id', '=', session('adminId'))
                                    ->where('leida', '=', '0')
                                    ->select('id')
                                    ->get();

      $notificaciones = DB::table('notificacion_admin')
                           ->where('admin_id', '=', session('adminId'))
                           ->select('id', 'titulo', 'url', 'color', 'icono', 'leida')
                           ->orderBy('created_at', 'DESC')
                           ->take(10)
                           ->get();

      $cont = 0;
      foreach($notificaciones_pendientes as $notificacion){
         $cont++;
      }

   ?>
   
   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
      @if ($cont > 0 )
         <span class="label label-success">{{ $cont }}</span>
      @endif
   </a>

   <ul class="dropdown-menu">
      <li class="header"><strong>Usted tiene {{ $cont }} notificacones sin leer</strong></li>
      <li>
         <!-- INICIO DE LA LISTA DONDE SE CARGARÁN LAS NOTIFICACIONES -->
         <ul class="menu">
            @foreach ($notificaciones as $notificacion)
               @if ($notificacion->leida == '1')
                  <li>
                     <a href="{{ url($notificacion->url) }}"> <i class="{{ $notificacion->icono }} {{ $notificacion->color }}"></i> {{$notificacion->titulo}}</a>
                  </li>
               @else
                  <li style="background-color: #D8D8D8;">
                     <a href="{{ route('admin.marcar-leida', $notificacion->id) }}"> <i class="{{ $notificacion->icono }} {{ $notificacion->color }}"></i> {{$notificacion->titulo}}</a>
                  </li>
               @endif
            @endforeach
         </ul>
         <!-- FIN DE LA LISTA DONDE SE CARGARÁN LAS NOTIFICACIONES -->
      </li>
      <li class="footer"><a href="{{ route('admin.notificaciones') }}">Ver Todas</a></li>
   </ul>
</li>