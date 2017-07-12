@extends('plantillas.main')
@section('title', 'Demandas de Productos/Bebidas')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Demandas de Bebidas</h3></strong></span>
@endsection

@section('content-left')
   <div class="row">
      <div class="col-md-12">
         <ul class="timeline">
            <li class="time-label">
                  <span class="bg-yellow">
                    Demandas de Tipos de Bebidas
                  </span>
            </li>
            
            @foreach($demandasBebidas as $demandaBebida)
               <?php 
                  $bebida = DB::table('bebida')
                              ->select('nombre')
                              ->where('id', '=', $demandaBebida->bebida_id)
                              ->first();
                ?>
               <li>
                  <i class="fa fa-hand-pointer-o bg-blue"></i>

                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaBebida->created_at)) }}</span>

                     <h3 class="timeline-header">@if ($demandaBebida->tipo_creador == 'I') 
                        Un importador @elseif ($demandaBebida->tipo_creador == 'D') Un Distribuidor @else Un Horeca @endif está demandando un tipo de bebida que tu posees.</h3>

                     <div class="timeline-body">
                        @if ($demandaBebida->tipo_creador == 'I') 
                        Un importador @elseif ($demandaBebida->tipo_creador == 'D') Un Distribuidor  @else Un Horeca @endif está en la búsqueda de <strong>{{ $bebida->nombre }}</strong>. <br>
                        <strong>Descripción de la Demanda:</strong> {{ $demandaBebida->titulo }}. ({{ $demandaBebida->descripcion }}).
                     </div>
            
                     <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('demanda-producto.show', $demandaBebida->id) }}">¡Más Detalles!</a>
                     </div>
                  </div>
               </li>
            @endforeach
         </ul>
      </div>
   
      <div>
        <center>{{ $demandasBebidas->render() }}</center>
      </div>
   </div>
@endsection
