@extends('plantillas.main')
@section('title', 'Demandas de Distribución')

@section('title-header')
   Demandas de Distribución
@endsection

@section('content-left')

   @section('alertas')
      @if (Session::has('msj'))
           <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
           </div>
      @endif  
   @endsection
      
   <div class="col-md-12">
      <ul class="timeline">
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
            ?>
            
            @if ($relacion == null)
               <li>
                  @if ($demandaDistribucion->producto_id != 0)
                     <i class="fa fa-hand-pointer-o bg-blue"></i>
                  @else 
                     <i class="fa fa-hand-pointer-o bg-green"></i>
                  @endif
                     
                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaDistribucion->created_at)) }}</span>
                        
                     @if ($demandaDistribucion->producto_id != 0)
                        <h3 class="timeline-header">Un distribuidor está demandando la distribución de tu producto.</h3>

                        <div class="timeline-body">
                           El distribuidor <strong>{{ $demandaDistribucion->distribuidor->nombre }}</strong> ha indicado que que quiere distribuir tu producto <strong>{{ $demandaDistribucion->producto->nombre }}</strong> en su provincia...
                        </div>
                     @else
                        <h3 class="timeline-header">Un distribuidor está demandando la distribución de tu marca.</h3>

                        <div class="timeline-body">
                           El distribuidor <strong>{{ $demandaDistribucion->distribuidor->nombre }}</strong> ha indicado que que quiere distribuir tu marca <strong>{{ $demandaDistribucion->marca->nombre }}</strong> en su provincia...
                        </div>
                     @endif
                        
                     <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('solicitud-distribucion.show', $demandaDistribucion->id) }}">¡Más Detalles!</a>
                        <a class="btn btn-danger btn-xs" href="{{ route('solicitud-distribucion.marcar', [$demandaDistribucion->id, '0']) }}">¡No Me Interesa!</a>
                     </div>
                  </div>
               </li>
            @endif
         @endforeach
      </ul>
   </div>
@endsection

@section('paginacion')
   {{$demandasDistribucion->render()}}
@endsection
