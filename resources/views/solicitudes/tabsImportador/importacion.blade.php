@extends('plantillas.main')
@section('title', 'Solicitudes')

@section('title-header')
   Solicitudes
@endsection

@section('title-complement')
   (Importador)
@endsection

@section('content-left')
   <?php 
      $not_dp = DB::table('notificacion_i')->select('id')
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DP')->where('leida', '=', '0')->get();
      $dp=0;
      foreach($not_dp as $ndp){
         $dp++;
      }

      $not_db = DB::table('notificacion_i')->select('id')
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DB')->where('leida', '=', '0')->get();
      $db=0;
      foreach($not_db as $ndb){
         $db++;
      }

      $not_di = DB::table('notificacion_i')->select('id')
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DI')->where('leida', '=', '0')->get();
      $di=0;
      foreach($not_di as $ndi){
         $di++;
         DB::table('notificacion_i')->where('id', '=', $ndi->id)->update(['leida' => '1']);
      }

      $not_sd = DB::table('notificacion_i')->select('id')
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'SD')->where('leida', '=', '0')->get();
      $sd=0;
      foreach($not_sd as $nsd){
         $sd++;
      }
   ?>

   @section('alertas')
      @if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
         </div>
      @endif
   @endsection  
   
   <ul class="nav nav-pills">
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.demandas-productos-disponibles') }}"><strong>PRODUCTO | 
         <small class="label bg-red">{{ $dp }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.demandas-bebidas-disponibles') }}"><strong>BEBIDA | <small class="label bg-red">{{ $db }}</small></strong></a>
      </li>
      <li class="active btn btn-default">
         <a href="{{ route('demanda-importador.demandas-disponibles') }}"><strong>IMPORTACIÓN | <small class="label bg-orange">{{ $di }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('solicitud-distribucion.solicitudes') }}"><strong>DISTRIBUCIÓN | <small class="label bg-red">{{ $sd }}</small></strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <ul class="timeline">
                  @if ($cont > 0)
                     @foreach($demandasImportadores as $demandaImportador)
                        <?php 
                           $existe = DB::table('importador_marca')
                                       ->where('importador_id', '=', session('perfilId'))
                                       ->where('marca_id', '=', $demandaImportador->marca_id)
                                       ->first();

                           if ($existe == null){
                              $relacion = DB::table('importador_demanda_importador')
                                       ->select('demanda_importador_id')
                                       ->where('demanda_importador_id', '=', $demandaImportador->id)
                                       ->where('importador_id', '=', session('perfilId'))
                                       ->first();
                           }else{
                              $relacion = '1';
                           }            
                        ?>
                        @if ($relacion == null)
                           <li>
                              <i class="fa fa-hand-pointer-o bg-orange"></i>
                              <div class="timeline-item">
                                 <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaImportador->created_at)) }}</span>

                                 <h3 class="timeline-header">Un productor está buscando importadores para su marca.</h3>

                                 <div class="timeline-body">
                                    El productor <strong>{{ $demandaImportador->productor->nombre }}</strong> ha indicado que está en la búsqueda de nuevos importadores para su marca <strong>{{ $demandaImportador->marca->nombre }}</strong> en tu país...
                                 </div>
                     
                                 <div class="timeline-footer">
                                    <a class="btn btn-primary btn-xs" href="{{ route('demanda-importador.show', $demandaImportador->id) }}">¡Más Detalles!</a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('demanda-importador.marcar', [$demandaImportador->id, '0']) }}">¡No Me Interesa!</a>
                                 </div>
                              </div>
                           </li>
                        @endif
                     @endforeach
                  @else
                     <strong>No existen demandas de importador disponibles.</strong>
                  @endif
               </ul>
            </div>
         </div>
      </div>
   </div>
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                  
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$demandasImportadores->render()}}
@endsection

