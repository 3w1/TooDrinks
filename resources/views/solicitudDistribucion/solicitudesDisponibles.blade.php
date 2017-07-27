@extends('plantillas.main')
@section('title', 'Demandas de Distribución')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Demandas de Distribución</h3></strong></span>
   
@endsection

@section('content-left')
   <div class="row">
      
      <div class="col-md-12">
         <ul class="timeline">
            @foreach($demandasDistribucion as $demandaDistribucion)
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
                     </div>
                  </div>
               </li>
            @endforeach
         </ul>
      </div>
   
      <div>
        {{ $demandasDistribucion->render() }}
      </div>
   </div>
@endsection
