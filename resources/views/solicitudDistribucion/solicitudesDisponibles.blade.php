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
   @if ( (session('perfilSuscripcion') != 'Premium') )
      @if (session('perfilSaldo') < '30')
         <div class="alert alert-danger">
            No tiene créditos suficientes para ver la información de las demandas de distribución de productos. Por favor compre créditos. <a href="{{ route('credito.index') }">Ver Planes de Crédito</a> O consiga una Suscripción Advanced o Premium. <a href="">Ver Suscripciones</a> 
         </div>
      @else
         <div class="alert alert-danger">
           Se le descontarán 30 créditos de su saldo. Para ver demandas de distribución sin pagar créditos debe obtener una Suscripción Premium. 
         </div>
      @endif
   @endif
   <div class="row">
      
      <div class="col-md-12">
         <ul class="timeline">
            
            @foreach($demandasDistribucion as $demandaDistribucion)
               <?php 
                  $distribuidor = DB::table('distribuidor')
                                 ->select('nombre')
                                 ->where('id', '=', $demandaDistribucion->distribuidor_id)
                                 ->first();
                ?>
               <li>
                  <i class="fa fa-hand-pointer-o bg-blue"></i>

                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaDistribucion->created_at)) }}</span>

                     <h3 class="timeline-header">Un distribuidor está demandando la distribución de tu producto.</h3>

                     <div class="timeline-body">
                        El distribuidor <strong>{{ $distribuidor->nombre }}</strong> ha indicado que que quiere distribuir tu producto <strong>{{ $demandaDistribucion->nombre }}</strong> en su provincia...
                     </div>
               
                     <div class="timeline-footer">
                        @if (session('perfilSuscripcion') == 'P')
                           <a class="btn btn-primary btn-xs" href="{{ route('distribuidor.show', $demandaDistribucion->distribuidor_id) }}">¡Contactar!</a>
                        @else
                           @if (session('perfilSaldo') >= '30')
                                 <a class="btn btn-primary btn-xs" href="{{ route('credito.gastar-creditos-ddp', ['30', $demandaDistribucion->distribuidor_id]) }}">¡Contactar! 30 <i class="fa fa-certificate"></i></a>
                           @else 
                              <button class="btn btn-primary btn-xs" disabled>¡Contactar! 30 <i class="fa fa-certificate"></i></button>
                           @endif
                        @endif
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
