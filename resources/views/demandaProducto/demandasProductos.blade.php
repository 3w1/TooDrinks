@extends('plantillas.main')
@section('title', 'Demandas de Productos/Bebidas')

@section('title-header')
   Demandas de Producto
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
         <li class="time-label">
            <span class="bg-green">
               Demandas de Productos Específicos
            </span>
         </li>
            
         @foreach($demandasProductos as $demandaProducto)
            <li>
               <i class="fa fa-hand-pointer-o bg-blue"></i>
               <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaProducto->created_at)) }}</span>
                  <h3 class="timeline-header">@if ($demandaProducto->tipo_creador == 'I') 
                     Un importador @elseif ($demandaProducto->tipo_creador == 'D') Un Distribuidor @else Un Horeca @endif está demandando tu producto.</h3>

                  <div class="timeline-body">
                     @if ($demandaProducto->tipo_creador == 'I') 
                     Un importador @elseif ($demandaProducto->tipo_creador == 'D') Un Distribuidor  @else Un Horeca @endif ha demandado tu producto <strong>{{ $demandaProducto->nombre }}</strong>. <br>
                     <strong>Descripción de la Demanda:</strong> {{ $demandaProducto->titulo }}. ({{ $demandaProducto->descripcion }}).
                  </div>
            
                  <div class="timeline-footer">
                     <a class="btn btn-primary btn-xs" href="{{ route('demanda-producto.show', $demandaProducto->id) }}">¡Más Detalles!</a>
                  </div>
               </div>
            </li>
         @endforeach
      </ul>
   </div>
@endsection

@section('paginacion')
   {{$demandasProductos->render()}}
@endsection
