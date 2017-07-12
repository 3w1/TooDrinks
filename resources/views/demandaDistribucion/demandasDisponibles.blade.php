@extends('plantillas.main')
@section('title', 'Demandas de Distribuidores')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Demandas de Distribuidores</h3></strong></span>
   
@endsection

@section('content-left')
   @if ( (session('perfilSuscripcion') != 'Premium') )
      @if (session('perfilSaldo') < '30')
         <div class="alert alert-danger">
            No tiene créditos suficientes para ver la información de contacto de los productores. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Advanced o Premium. <a href="">Ver Suscripciones</a> 
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
            
            @foreach($demandasDistribuidores as $demandaDistribuidor)
               <?php 
                  $existe = DB::table('distribuidor_marca')
                              ->where('distribuidor_id', '=', session('perfilId'))
                              ->where('marca_id', '=', $demandaDistribuidor->marca_id)
                              ->count();
               ?>

               @if ($existe == '0')
                  <?php 
                     $marca = DB::table('marca')
                                    ->select('nombre')
                                    ->where('id', '=', $demandaDistribuidor->marca_id)
                                    ->get()
                                    ->first(); 

                     if ($demandaDistribuidor->tipo_creador == 'P'){
                        $creador= DB::table('productor')
                                    ->select('nombre')
                                    ->where('id', '=', $demandaDistribuidor->creador_id)
                                    ->get()
                                    ->first(); 
                     }else{
                        $creador= DB::table('importador')
                                    ->select('nombre')
                                    ->where('id', '=', $demandaDistribuidor->creador_id)
                                    ->get()
                                    ->first(); 
                     }
                    
                  ?>

                  <li>
                     <i class="fa fa-hand-pointer-o bg-blue"></i>

                     <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaDistribuidor->created_at)) }}</span>
                        
                        <h3 class="timeline-header"> @if($demandaDistribuidor->tipo_creador == 'P') 
                        Un productor está buscando distribuidores para su marca. </h3>
                        @else Un importador está buscando distribuidores para su marca.</h3>@endif

                        <div class="timeline-body">
                            @if($demandaDistribuidor->tipo_creador == 'P') El productor @else El importador @endif <strong>{{ $creador->nombre }}</strong> ha indicado que está en la búsqueda de nuevos distribuidores para su marca <strong>{{ $marca->nombre }}</strong> en tu provincia...
                        </div>
               
                        <div class="timeline-footer">
                           @if (session('perfilSuscripcion') == 'P')
                              @if ($demandaDistribuidor->tipo_creador == 'P')
                                 <a class="btn btn-primary btn-xs" href="{{ route('productor.show', $demandaDistribuidor->creador_id) }}">¡Contactar!</a>
                              @else
                                 <a class="btn btn-primary btn-xs" href="{{ route('importador.show', $demandaDistribuidor->creador_id) }}">¡Contactar!</a>
                              @endif
                           @else
                              @if (session('perfilSaldo') >= '30')
                                 @if ($demandaDistribuidor->tipo_creador == 'P')
                                    <a class="btn btn-primary btn-xs" href="{{ route('credito.gastar-creditos-dd', ['30', $demandaDistribuidor->creador_id, 'P']) }}">¡Contactar! 30 <i class="fa fa-certificate"></i></a>
                                 @else
                                    <a class="btn btn-primary btn-xs" href="{{ route('credito.gastar-creditos-dd', ['30', $demandaDistribuidor->creador_id, 'I']) }}">¡Contactar! 30 <i class="fa fa-certificate"></i></a>
                                 @endif
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
        {{ $demandasDistribuidores->render() }}
      </div>
   </div>
@endsection
