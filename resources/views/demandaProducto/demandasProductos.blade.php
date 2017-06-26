@extends('plantillas.main')
@section('title', 'Demandas de Productos/Bebidas')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Demandas de Productos</h3></strong></span>
@endsection

@section('content-left')
   @if ( (session('perfilSuscripcion') != 'P') && (session('perfilSaldo') < '30') )
      <div class="alert alert-danger">
         No tiene créditos suficientes para ver demandas de productos. Por favor compre créditos. <a href="">Ver Planes de Crédito</a> O consiga una Suscripción Premium. <a href="">Ver Suscripciones</a> 
      </div>
   @endif
   <div class="row">
      <div class="col-md-12">
         <ul class="timeline">
            <li class="time-label">
                  <span class="bg-green">
                    Demandas de Productos Específicos
                  </span>
            </li>
            
            @foreach($demandasProductos as $demandaProducto)
               <li>
                  <i class="fa fa-hand-pointer-o bg-blue"></i>

                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                     <h3 class="timeline-header">@if ($demandaProducto->tipo_creador == 'I') 
                        Un importador @elseif ($demandaProducto->tipo_creador == 'D') Un Distribuidor @else Un Horeca @endif está demandando tu producto.</h3>

                     <div class="timeline-body">
                        @if ($demandaProducto->tipo_creador == 'I') 
                        Un importador @elseif ($demandaProducto->tipo_creador == 'D') Un Distribuidor  @else Un Horeca @endif ha demandado tu producto <strong>{{ $demandaProducto->nombre }}</strong>. <br>
                        <strong>Descripción de la Demanda:</strong> {{ $demandaProducto->titulo }}. ({{ $demandaProducto->descripcion }}).
                     </div>
            
                     <div class="timeline-footer">
                        @if (session('perfilSuscripcion') == 'P')
                           <a class="btn btn-primary btn-xs" href="{{ route('demanda-producto.show', $demandaProducto->id) }}">¡Más Detalles!</a>
                        @else
                           @if (session('perfilSaldo') >= '30')
                              <a class="btn btn-primary btn-xs" href="{{ route('credito.gastar-creditos-dp', ['30', $demandaProducto->id]) }}">¡Más Detalles! 30 <i class="fa fa-certificate"></i></a>
                           @else 
                              <button class="btn btn-primary btn-xs" disabled>¡Más Detalles! 30 <i class="fa fa-certificate"></i></button>
                           @endif
                        @endif
                     </div>
                  </div>
               </li>
            @endforeach
         </ul>
      </div>
   
      <div>
        <center>{{ $demandasProductos->render() }}</center>
      </div>
   </div>
@endsection
