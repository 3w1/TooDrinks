@extends('plantillas.main')
@section('title', 'Demandas de Importadores')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Demandas de Importadores</h3></strong></span>
   
@endsection

@section('content-left')
   @if ( (session('perfilSuscripcion') != 'P') )
      @if (session('perfilSaldo') < '30')
         <div class="alert alert-danger">
            No tiene créditos suficientes para ver la información de contacto de los productores. Por favor compre créditos. <a href="{{ route('credito.index') }">Ver Planes de Crédito</a> O consiga una Suscripción Advanced o Premium. <a href="">Ver Suscripciones</a> 
         </div>
      @else
         <div class="alert alert-danger">
           Se le descontarán 30 créditos de su saldo. Para ver demandas sin pagar créditos debe obtener una Suscripción Premium. 
         </div>
      @endif
   @endif
   <div class="row">
      
      <div class="col-md-12">
         <ul class="timeline">
            
            @foreach($demandasImportadores as $demandaImportador)
               <?php 
                  $existe = DB::table('importador_marca')
                              ->where('importador_id', '=', session('perfilId'))
                              ->where('marca_id', '=', $demandaImportador->marca_id)
                              ->count();
               ?>

               @if ($existe == '0')
                  <?php 
                     $marca = DB::table('marca')
                                    ->select('nombre')
                                    ->where('id', '=', $demandaImportador->marca_id)
                                    ->get()
                                    ->first(); 

                     $productor= DB::table('productor')
                                    ->select('nombre')
                                    ->where('id', '=', $demandaImportador->productor_id)
                                    ->get()
                                    ->first(); 
                  ?>

                  <li>
                     <i class="fa fa-hand-pointer-o bg-blue"></i>

                     <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaImportador->created_at)) }}</span>

                        <h3 class="timeline-header">Un productor está buscando importadores para su marca.</h3>

                        <div class="timeline-body">
                           El productor <strong>{{ $productor->nombre }}</strong> ha indicado que está en la búsqueda de nuevos importadores para su marca <strong>{{ $marca->nombre }}</strong> en tu país...
                        </div>
               
                        <div class="timeline-footer">
                           @if (session('perfilSuscripcion') == 'P')
                              <a class="btn btn-primary btn-xs" href="{{ route('productor.show', $demandaImportador->productor_id) }}">¡Contactar!</a>
                           @else
                              @if (session('perfilSaldo') >= '30')
                                 <a class="btn btn-primary btn-xs" href="{{ route('credito.gastar-creditos-di', ['30', $demandaImportador->productor_id]) }}">¡Contactar! 30 <i class="fa fa-certificate"></i></a>
                              @else 
                                 <button class="btn btn-primary btn-xs" disabled>¡Contactar! 30 <i class="fa fa-certificate"></i></button>
                              @endif
                           @endif
                        </div>
                     </div>
                  </li>
               @endif
            @endforeach
         </ul>
      </div>
   
      <div>
        {{ $demandasImportadores->render() }}
      </div>
   </div>
@endsection
