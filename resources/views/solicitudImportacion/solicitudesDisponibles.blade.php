@extends('plantillas.main')
@section('title', 'Demandas de Importación')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Demandas de Importación</h3></strong></span>
   
@endsection

@section('content-left')
   @if ( (session('perfilSuscripcion') != 'Premium') )
      @if (session('perfilSaldo') < '30')
         <div class="alert alert-danger">
            No tiene créditos suficientes para ver la información de las demandas de importaciónde productos. Por favor compre créditos. <a href="{{ route('credito.index') }">Ver Planes de Crédito</a> O consiga una Suscripción Advanced o Premium. <a href="">Ver Suscripciones</a> 
         </div>
      @else
         <div class="alert alert-danger">
           Se le descontarán 30 créditos de su saldo. Para ver demandas de importación sin pagar créditos debe obtener una Suscripción Premium. 
         </div>
      @endif
   @endif
   <div class="row">
      
      <div class="col-md-12">
         <ul class="timeline">
            
            @foreach($demandasImportacion as $demandaImportacion)
               <?php 
                  $importador = DB::table('importador')
                                 ->select('nombre')
                                 ->where('id', '=', $demandaImportacion->importador_id)
                                 ->first();
                ?>
               <li>
                  <i class="fa fa-hand-pointer-o bg-blue"></i>

                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaImportacion->created_at)) }}</span>

                     <h3 class="timeline-header">Un importador está demandando la importación de tu producto.</h3>

                     <div class="timeline-body">
                        El importador <strong>{{ $importador->nombre }}</strong> ha indicado que que quiere importar tu producto <strong>{{ $demandaImportacion->nombre }}</strong> en su país...
                     </div>
               
                     <div class="timeline-footer">
                        @if (session('perfilSuscripcion') == 'P')
                           <a class="btn btn-primary btn-xs" href="{{ route('importador.show', $demandaImportacion->importador_id) }}">¡Contactar!</a>
                        @else
                           @if (session('perfilSaldo') >= '30')
                                 <a class="btn btn-primary btn-xs" href="{{ route('credito.gastar-creditos-dip', ['30', $demandaImportacion->importador_id]) }}">¡Contactar! 30 <i class="fa fa-certificate"></i></a>
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
        {{ $demandasImportacion->render() }}
      </div>
   </div>
@endsection
