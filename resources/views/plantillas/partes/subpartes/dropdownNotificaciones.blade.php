<li class="dropdown notifications-menu">
   @if (session('perfilTipo') == 'US')
      <?php 
         $notificaciones_pendientes = DB::table('notificacion_u')
                                    ->where('user_id', '=', Auth::user()->id)
                                    ->where('leida', '=', '0')
                                    ->select('id')
                                    ->get();

         $notificaciones = DB::table('notificacion_u')
                              ->where('user_id', '=', Auth::user()->id)
                              ->select('id', 'titulo', 'url', 'color', 'icono', 'leida')
                              ->orderBy('created_at', 'DESC')
                              ->take(10)
                              ->get();

         $cont = 0;
         foreach($notificaciones_pendientes as $notificacion){
            $cont++;
         }

      ?>
  @elseif (session('perfilTipo') == 'AD')
      <?php 
         $notificaciones_pendientes = DB::table('notificacion_admin')
                                    ->where('user_id', '=', Auth::user()->id)
                                    ->where('leida', '=', '0')
                                    ->select('id')
                                    ->get();

         $notificaciones = DB::table('notificacion_admin')
                              ->where('user_id', '=', Auth::user()->id)
                              ->select('id', 'titulo', 'url', 'color', 'icono', 'leida')
                              ->orderBy('created_at', 'DESC')
                              ->take(10)
                              ->get();

         $cont = 0;
         foreach($notificaciones_pendientes as $notificacion){
            $cont++;
         }

       ?>
  @elseif (session('perfilTipo') == 'P')
      <?php 
         $notificaciones_pendientes = DB::table('notificacion_p')
                                    ->where('productor_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id')
                                    ->get();

         $notificaciones = DB::table('notificacion_p')
                              ->where('productor_id', '=', session('perfilId'))
                              ->select('id', 'titulo', 'url', 'color', 'icono', 'leida')
                              ->orderBy('created_at', 'DESC')
                              ->take(10)
                              ->get();
         $cont = 0;
         foreach($notificaciones_pendientes as $notificacion){
            $cont++;
         }
       ?>
   @elseif (session('perfilTipo') == 'I')
       <?php 
         $notificaciones_pendientes = DB::table('notificacion_i')
                                    ->where('importador_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id')
                                    ->get();

         $notificaciones = DB::table('notificacion_i')
                              ->where('importador_id', '=', session('perfilId'))
                              ->select('id', 'titulo', 'url', 'color', 'icono', 'leida')
                              ->orderBy('created_at', 'DESC')
                              ->take(10)
                              ->get();
         $cont = 0;
         foreach($notificaciones_pendientes as $notificacion){
            $cont++;
         }
       ?>
   @elseif (session('perfilTipo') == 'D')
       <?php 
         $notificaciones_pendientes = DB::table('notificacion_d')
                                    ->where('distribuidor_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id')
                                    ->get();

         $notificaciones = DB::table('notificacion_d')
                              ->where('distribuidor_id', '=', session('perfilId'))
                              ->select('id', 'titulo', 'url', 'color', 'icono', 'leida')
                              ->orderBy('created_at', 'DESC')
                              ->take(10)
                              ->get();
         $cont = 0;
         foreach($notificaciones_pendientes as $notificacion){
            $cont++;
         }
       ?>
   @elseif (session('perfilTipo') == 'H')
       <?php 
         $notificaciones_pendientes = DB::table('notificacion_h')
                                    ->where('horeca_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id')
                                    ->get();

         $notificaciones = DB::table('notificacion_h')
                              ->where('horeca_id', '=', session('perfilId'))
                              ->select('id', 'titulo', 'url', 'color', 'icono', 'leida')
                              ->orderBy('created_at', 'DESC')
                              ->take(10)
                              ->get();
         $cont = 0;
         foreach($notificaciones_pendientes as $notificacion){
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
               @if ($notificacion->leida == '1')
                  <li>
                     <a href="{{ url($notificacion->url) }}"> <i class="{{ $notificacion->icono }} {{ $notificacion->color }}"></i> {{$notificacion->titulo}}</a>
                  </li>
               @else
                  <li style="background-color: #D8D8D8;">
                     <a href="{{ route('notificacion.leida', $notificacion->id) }}"> <i class="{{ $notificacion->icono }} {{ $notificacion->color }}"></i> {{$notificacion->titulo}}</a>
                  </li>
               @endif
            @endforeach
         </ul>
         <!-- FIN DE LA LISTA DONDE SE CARGARÁN LAS NOTIFICACIONES -->
      </li>
      <li class="footer"><a href="{{ route('notificacion.index') }}">Ver Todas</a></li>
   </ul>
</li>