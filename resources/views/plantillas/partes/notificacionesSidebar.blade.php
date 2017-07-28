@if (session('perfilTipo') == 'P')
   <?php 
      $notificaciones_pendientes = DB::table('notificacion_p')
                                    ->where('productor_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id', 'tipo')
                                    ->get();

      $confirmaciones = 0; $demandas = 0;
      $cont_NM = 0; $cont_NP = 0; $cont_AI = 0; $cont_AD = 0;
      $cont_SI = 0; $cont_SD = 0; $cont_DP = 0; $cont_DB = 0;

      foreach($notificaciones_pendientes as $notificacion){
         if ($notificacion->tipo == 'NM'){
            $confirmaciones++;
            $cont_NM++;
         }elseif ($notificacion->tipo == 'NP'){
            $confirmaciones++;
            $cont_NP++;
         }elseif ($notificacion->tipo == 'AI'){
            $confirmaciones++;
            $cont_AI++;
         }elseif ($notificacion->tipo == 'AD'){
            $confirmaciones++;
            $cont_AD++;
         }elseif ($notificacion->tipo == 'SI'){
            $demandas++;
            $cont_SI++;
         }elseif ($notificacion->tipo == 'SD'){
            $demandas++;
            $cont_SD++;
         }elseif ($notificacion->tipo == 'DP'){
            $demandas++;
            $cont_DP++;
         }elseif ($notificacion->tipo == 'DB'){
            $demandas++;
            $cont_DB++;
         }
      }
   ?>
@elseif (session('perfilTipo') == 'I')
   <?php 
      $notificaciones_pendientes = DB::table('notificacion_i')
                                    ->where('importador_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id', 'tipo')
                                    ->get();

      $confirmaciones = 0; $demandas = 0;
      $cont_AD = 0; $cont_NO = 0;
      $cont_SD = 0; $cont_DP = 0; $cont_DB = 0; $cont_DI = 0;

      foreach($notificaciones_pendientes as $notificacion){
         if ($notificacion->tipo == 'AD'){
            $confirmaciones++;
            $cont_AD++;
         }elseif ($notificacion->tipo == 'NO'){
            $cont_NO++;
         }elseif ($notificacion->tipo == 'SD'){
            $demandas++;
            $cont_SD++;
         }elseif ($notificacion->tipo == 'DP'){
            $demandas++;
            $cont_DP++;
         }elseif ($notificacion->tipo == 'DB'){
            $demandas++;
            $cont_DB++;
         }elseif ($notificacion->tipo == 'DI'){
            $demandas++;
            $cont_DI++;
         }
      }
   ?>
@elseif (session('perfilTipo') == 'D')
   <?php 
      $notificaciones_pendientes = DB::table('notificacion_d')
                                    ->where('distribuidor_id', '=', session('perfilId'))
                                    ->where('leida', '=', '0')
                                    ->select('id', 'tipo')
                                    ->get();

      $demandas = 0;
      $cont_NO = 0;
      $cont_DP = 0; $cont_DB = 0; $cont_DD = 0;

      foreach($notificaciones_pendientes as $notificacion){
         if ($notificacion->tipo == 'NO'){
            $cont_NO++;
         }elseif ($notificacion->tipo == 'DP'){
            $demandas++;
            $cont_DP++;
         }elseif ($notificacion->tipo == 'DB'){
            $demandas++;
            $cont_DB++;
         }elseif ($notificacion->tipo == 'DD'){
            $demandas++;
            $cont_DD++;
         }
      }
   ?>
@endif