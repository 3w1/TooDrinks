<?php 
   if (session('perfilTipo') == 'P'){
      $demandasProducto = DB::table('productor_demanda_producto')
                           ->select('id')
                           ->where('productor_id', '=', session('perfilId'))
                           ->get();
      $contDP = 0;
      foreach ($demandasProducto as $dp){
         $contDP++;
      }

      $demandasImportacion = DB::table('productor_solicitud_importacion')
                           ->select('id')
                           ->where('productor_id', '=', session('perfilId'))
                           ->get();

      $contSI = 0;
      foreach ($demandasImportacion as $di){
         $contSI++;
      }

      $demandasDistribucion = DB::table('productor_solicitud_distribucion')
                           ->select('id')
                           ->where('productor_id', '=', session('perfilId'))
                           ->get();

      $contSD = 0;
      foreach ($demandasDistribucion as $dd){
         $contSD++;
      }
   }elseif (session('perfilTipo') == 'I'){
      $demandasProducto = DB::table('importador_demanda_producto')
                           ->select('id')
                           ->where('importador_id', '=', session('perfilId'))
                           ->get();
      $contDP = 0;
      foreach ($demandasProducto as $dp){
         $contDP++;
      }

      $demandasDistribucion = DB::table('importador_solicitud_distribucion')
                           ->select('id')
                           ->where('importador_id', '=', session('perfilId'))
                           ->get();

      $contSD = 0;
      foreach ($demandasDistribucion as $dd){
         $contSD++;
      }

      $demandasImportador1 = DB::table('deduccion_credito_importador')
                           ->select('id')
                           ->where('tipo_deduccion', '=', 'DI')
                           ->where('importador_id', '=', session('perfilId'))
                           ->get();

      $demandasImportador2 = DB::table('importador_demanda_importador')
                           ->select('id')
                           ->where('importador_id', '=', session('perfilId'))
                           ->get();

      $contDI = 0;
      foreach ($demandasImportador1 as $di1){
         $contDI++;
      }
      foreach ($demandasImportador2 as $di2){
         $contDI++;
      }
   }elseif (session('perfilTipo') == 'D'){
      $demandasProducto1 = DB::table('deduccion_credito_distribuidor')
                           ->select('id')
                           ->where('tipo_deduccion', '=', 'DP')
                           ->orwhere('tipo_deduccion', '=', 'DB')
                           ->where('distribuidor_id', '=', session('perfilId'))
                           ->get();

      $demandasProducto2 = DB::table('distribuidor_demanda_producto')
                           ->select('id')
                           ->where('distribuidor_id', '=', session('perfilId'))
                           ->get();
      $contDP = 0;
      foreach ($demandasProducto1 as $dp1){
         $contDP++;
      }
      foreach ($demandasProducto2 as $dp2){
         $contDP++;
      }

      $demandasDistribuidor1 = DB::table('deduccion_credito_distribuidor')
                           ->select('id')
                           ->where('tipo_deduccion', '=', 'DI')
                           ->where('distribuidor_id', '=', session('perfilId'))
                           ->get();

      $demandasDistribuidor2 = DB::table('distribuidor_demanda_distribuidor')
                           ->select('id')
                           ->where('distribuidor_id', '=', session('perfilId'))
                           ->get();

      $contDD = 0;
      foreach ($demandasDistribuidor1 as $dd1){
         $contDD++;
      }
      foreach ($demandasDistribuidor2 as $dd2){
         $contDD++;
      }
   }
 ?>

<!-- PRODUCT LIST -->
<div class="box box-primary">
   <div class="box-header with-border">
      <h3 class="box-title">Mis Demandas de Interés</h3>
      <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
      <ul class="products-list product-list-in-box">
         <li class="item">
            <div class="product-img">
               <img src="" alt="Product Image">
            </div>
            <div class="product-info">
               <a href="{{ route('demanda-producto.demandas-interes') }}" class="product-title">Demandas de Productos / Bebidas
                  <span class="label label-success pull-right">{{$contDP}}</span>
               </a>
            </div>
         </li>   
         
         @if (session('perfilTipo') ==  'P')
            <li class="item">
               <div class="product-img">
                  <img src="" alt="Product Image">
               </div>
               <div class="product-info">
                  <a href="{{ route('solicitud-importacion.demandas-interes') }}" class="product-title">Solicitudes de Importación
                     <span class="label label-warning pull-right">{{$contSI}}</span>
                  </a>
               </div>
            </li>
         @endif
         
         @if ( (session('perfilTipo') == 'P') || (session('perfilTipo') == 'I') )
            <li class="item">
               <div class="product-img">
                  <img src="" alt="Product Image">
               </div>
               <div class="product-info">
                  <a href="{{ route('solicitud-distribucion.demandas-interes') }}" class="product-title">Solicitudes de Distribución
                     <span class="label label-info pull-right">{{$contSD}}</span>
                  </a>
               </div>
            </li>
         @endif

         @if (session('perfilTipo') == 'I')
            <li class="item">
               <div class="product-img">
                  <img src="" alt="Product Image">
               </div>
               <div class="product-info">
                  <a href="{{ route('demanda-importador.demandas-interes') }}" class="product-title">Demandas de Importadores
                     <span class="label label-warning pull-right">{{$contDI}}</span>
                  </a>
               </div>
            </li>
         @endif

          @if (session('perfilTipo') == 'D')
            <li class="item">
               <div class="product-img">
                  <img src="" alt="Product Image">
               </div>
               <div class="product-info">
                  <a href="{{ route('demanda-distribuidor.demandas-interes') }}" class="product-title">Demandas de Distribuidores
                     <span class="label label-warning pull-right">{{$contDD}}</span>
                  </a>
               </div>
            </li>
         @endif
                  
      </ul>
   </div>
   <!-- /.box-body -->
</div>
