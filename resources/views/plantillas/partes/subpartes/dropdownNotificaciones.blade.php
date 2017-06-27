<li class="dropdown notifications-menu">
   @if (session('perfilTipo') == 'P')
      <?php 
         $notificaciones = DB::table('notificacion_p')
                           ->select('titulo', 'url')
                           ->orderBy('created_at', 'DESC')
                           ->take(3)
                           ->get();
         $cont = 0;
         foreach($notificaciones as $notificacion){
            $cont++;
         }
       ?>
   @endif
   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
      <span class="label label-warning">{{ $cont }}</span>
   </a>

   <ul class="dropdown-menu">
      <li class="header">Usted tiene {{ $cont }} notificationes</li>
      <li>
         <!-- INICIO DE LA LISTA DONDE SE CARGARÁN LAS NOTIFICACIONES -->
         <ul class="menu">
            @foreach ($notificaciones as $notificacion)
               <li>
                  <a href="#"><i class="fa fa-users text-aqua"></i> {{$notificacion->titulo}}</a>
               </li>
            @endforeach
         </ul>
         <!-- FIN DE LA LISTA DONDE SE CARGARÁN LAS NOTIFICACIONES -->
      </li>
      <li class="footer"><a href="#">Ver Todas</a></li>
   </ul>
</li>