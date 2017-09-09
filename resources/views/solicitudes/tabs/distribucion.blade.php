@extends('plantillas.main')
@section('title', 'Solicitudes')

@section('title-header')
   Solicitudes
@endsection

@section('title-complement')
   (Distribución)
@endsection

@section('content-left')
   <?php 
      if (session('perfilTipo') == 'P'){
         $not_dp = DB::table('notificacion_p')->select('id')
                  ->where('productor_id', '=', session('perfilId'))
                  ->where('tipo', '=', 'DP')->where('leida', '=', '0')->get();
         $dp=0;
         foreach($not_dp as $ndp){
            $dp++;
         }

         $not_db = DB::table('notificacion_p')->select('id')
                  ->where('productor_id', '=', session('perfilId'))
                  ->where('tipo', '=', 'DB')->where('leida', '=', '0')->get();
         $db=0;
         foreach($not_db as $ndb){
            $db++;
         }

         $not_si = DB::table('notificacion_p')->select('id')
                  ->where('productor_id', '=', session('perfilId'))
                  ->where('tipo', '=', 'SI')->where('leida', '=', '0')->get();
         $si=0;
         foreach($not_si as $nsi){
            $si++;
         }

         $not_sd = DB::table('notificacion_p')->select('id')
                  ->where('productor_id', '=', session('perfilId'))
                  ->where('tipo', '=', 'SD')->where('leida', '=', '0')->get();
         $sd=0;
         foreach($not_sd as $nsd){
            $sd++;
            DB::table('notificacion_p')->where('id', '=', $nsd->id)->update(['leida' => '1']);
         }
      }elseif (session('perfilTipo') == 'I'){
         
      }elseif (session('perfilTipo') == 'D'){
         
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
      <li class="btn btn-default">
         <a href="{{ route('solicitud-importacion.solicitudes') }}"><strong>IMPORTACIÓN | <small class="label bg-red">{{ $si }}</small></strong></a>
      </li>
      <li class="active btn btn-default">
         <a href="{{ route('solicitud-distribucion.solicitudes') }}"><strong>DISTRIBUCIÓN | <small class="label bg-orange">{{ $sd }}</small></strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <ul class="timeline">
                  @if ($cont > 0)
                     @foreach($demandasDistribucion as $demandaDistribucion)
                        <?php 
                           if (session('perfilTipo') == 'P'){
                              $relacion = DB::table('productor_solicitud_distribucion')
                                       ->select('solicitud_distribucion_id')
                                       ->where('solicitud_distribucion_id', '=', $demandaDistribucion->id)
                                       ->where('productor_id', '=', session('perfilId'))
                                       ->first();
                           }elseif (session('perfilTipo') == 'I'){
                              $relacion = DB::table('importador_solicitud_distribucion')
                                       ->select('solicitud_distribucion_id')
                                       ->where('solicitud_distribucion_id', '=', $demandaDistribucion->id)
                                       ->where('importador_id', '=', session('perfilId'))
                                       ->first();
                           }

                           $demanda = App\Models\Solicitud_Distribucion::find($demandaDistribucion->id);
                        ?>
                        @if ($relacion == null)
                           <li>
                              @if ($demanda->marca_id != null)
                                 <i class="fa fa-hand-pointer-o bg-blue"></i>
                              @else 
                                 <i class="fa fa-hand-pointer-o bg-green"></i>
                              @endif

                              <div class="timeline-item">
                                 <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demanda->created_at)) }}</span>
                                    
                                 @if ($demanda->marca_id != null)
                                    <h3 class="timeline-header">Un distribuidor está demandando la distribución de tu marca.</h3>

                                    <div class="timeline-body">
                                       El distribuidor <strong>{{ $demanda->distribuidor->nombre }}</strong> ha indicado que quiere distribuir tu marca <strong>{{ $demanda->marca->nombre }}</strong> en su provincia...
                                    </div>
                                 @else 
                                    <h3 class="timeline-header">Un distribuidor está demandando la distribución de un tipo de bebida que tu posees.</h3>

                                    <div class="timeline-body">
                                       El distribuidor <strong>{{ $demanda->distribuidor->nombre }}</strong> ha indicado que quiere distribuir la  bebida <strong>{{ $demanda->bebida->nombre }}</strong> en su provincia...
                                    </div>
                                 @endif
                                    
                                 <div class="timeline-footer">
                                    <a class="btn btn-primary btn-xs" href="{{ route('solicitud-distribucion.show', $demanda->id) }}">¡Más Detalles!</a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('solicitud-distribucion.marcar', [$demanda->id, '0']) }}">¡No Me Interesa!</a>
                                 </div>
                              </div>
                           </li>
                        @endif
                     @endforeach
                  @else
                     <strong>No existen solicitudes de distribución disponibles.</strong>
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
                  @include('solicitudes.tabs.filtroDistribucion')
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$demandasDistribucion->appends(Request::only(['tipo']))->render()}}
@endsection

