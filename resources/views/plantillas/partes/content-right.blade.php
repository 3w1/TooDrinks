<?php 
   if (session('perfilTipo') == 'P'){
      $demandasProducto = DB::table('productor_demanda_producto')
                           ->select('id')
                           ->where('productor_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();
      $contDP = 0;
      foreach ($demandasProducto as $dp){
         $contDP++;
      }

      $demandasImportacion = DB::table('productor_solicitud_importacion')
                           ->select('id')
                           ->where('productor_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();

      $contSI = 0;
      foreach ($demandasImportacion as $di){
         $contSI++;
      }

      $demandasDistribucion = DB::table('productor_solicitud_distribucion')
                           ->select('id')
                           ->where('productor_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();

      $contSD = 0;
      foreach ($demandasDistribucion as $dd){
         $contSD++;
      }
   }elseif (session('perfilTipo') == 'I'){
      $demandasProducto = DB::table('importador_demanda_producto')
                           ->select('id')
                           ->where('importador_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();
      $contDP = 0;
      foreach ($demandasProducto as $dp){
         $contDP++;
      }

      $demandasDistribucion = DB::table('importador_solicitud_distribucion')
                           ->select('id')
                           ->where('importador_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();

      $contSD = 0;
      foreach ($demandasDistribucion as $dd){
         $contSD++;
      }

      $demandasImportador = DB::table('importador_demanda_importador')
                           ->select('id')
                           ->where('importador_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();

      $contDI = 0;
      foreach ($demandasImportador as $di){
         $contDI++;
      }
   }elseif (session('perfilTipo') == 'M'){
      $demandasProducto = DB::table('multinacional_demanda_producto')
                           ->select('id')
                           ->where('multinacional_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();
      $contDP = 0;
      foreach ($demandasProducto as $dp){
         $contDP++;
      }
   }elseif (session('perfilTipo') == 'D'){
      $demandasProducto = DB::table('distribuidor_demanda_producto')
                           ->select('id')
                           ->where('distribuidor_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();
      $contDP = 0;
      foreach ($demandasProducto as $dp){
         $contDP++;
      }

      $demandasDistribuidor = DB::table('distribuidor_demanda_distribuidor')
                           ->select('id')
                           ->where('distribuidor_id', '=', session('perfilId'))
                           ->where('marcada', '=', '1')
                           ->get();

      $contDD = 0;
      foreach ($demandasDistribuidor as $dd){
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
         @if (session('perfilTipo') != 'H')
            <li class="item">
               <div class="product-img">
                  <img src="{{ asset('imagenes/dp.jpg') }}" alt="Product Image">
               </div>
               <div class="product-info">
                  <br>
                  <a href="{{ route('demanda-producto.demandas-interes') }}" class="product-title">Demandas de Productos / Bebidas
                     <span class="label label-success pull-right">{{$contDP}}</span>
                  </a>
                  <br>
               </div>
            </li> 
         @endif  
         
         @if (session('perfilTipo') ==  'P')
            <li class="item">
               <div class="product-img">
                  <img src="{{ asset('imagenes/si.jpg') }}" alt="Product Image">
               </div>
               <div class="product-info">
                  <br>
                  <a href="{{ route('solicitud-importacion.demandas-interes') }}" class="product-title">Solicitudes de Importación
                     <span class="label label-warning pull-right">{{$contSI}}</span>
                  </a>
                  <br>
               </div>
            </li>
         @endif
         
         @if ( (session('perfilTipo') == 'P') || (session('perfilTipo') == 'I') )
            <li class="item">
               <div class="product-img">
                  <img src="{{ asset('imagenes/sd.jpg') }}" alt="Product Image">
               </div>
               <div class="product-info">
                  <br>
                  <a href="{{ route('solicitud-distribucion.demandas-interes') }}" class="product-title">Solicitudes de Distribución
                     <span class="label label-info pull-right">{{$contSD}}</span>
                  </a>
                  <br>
               </div>
            </li>
         @endif

         @if (session('perfilTipo') == 'I')
            <li class="item">
               <div class="product-img">
                  <img src="{{ asset('imagenes/di.jpg') }}" alt="Product Image">
               </div>
               <div class="product-info">
                  <br>
                  <a href="{{ route('demanda-importador.demandas-interes') }}" class="product-title">Demandas de Importadores
                     <span class="label label-warning pull-right">{{$contDI}}</span>
                  </a>
                  <br>
               </div>
            </li>
         @endif

          @if (session('perfilTipo') == 'D')
            <li class="item">
               <div class="product-img">
                  <img src="{{ asset('imagenes/dd.jpg') }}" alt="Product Image">
               </div>
               <div class="product-info">
                  <br>
                  <a href="{{ route('demanda-distribuidor.demandas-interes') }}" class="product-title">Demandas de Distribuidores
                     <span class="label label-warning pull-right">{{$contDD}}</span>
                  </a>
                  <br>
               </div>
            </li>
         @endif
                  
      </ul>
   </div>
   <!-- /.box-body -->
</div>
