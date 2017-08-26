@extends('plantillas.main')
@section('title', 'Solicitudes de Distribuidores')

@section('title-header')
   Verificación de Distribuidores
@endsection

@section('title-complement')
   (Por Confirmar)
@endsection

@section('content-left')
    {!! Html::script('js/distribuidores/datos.js') !!}

   @section('alertas')
      @if (Session::has('msj'))
           <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
           </div>
       @endif
   @endsection

   @include('distribuidor.modales.datos')

   <div class="col-md-12">
      <ul class="timeline">
         @foreach($solicitudes as $solicitud)
            <?php 
               $distribuidor = DB::table('distribuidor')
                              ->select('id', 'nombre', 'pais_id', 'provincia_region_id')
                              ->where('id', '=', $solicitud->distribuidor_id)
                              ->first();

               $pais = DB::table('pais')
                        ->select('pais')
                        ->where('id', '=', $distribuidor->pais_id)
                        ->first();

               $provincia = DB::table('provincia_region')
                              ->select('provincia')
                              ->where('id', '=', $distribuidor->provincia_region_id)
                              ->first();

               $marca = DB::table('marca')
                           ->where('id', '=', $solicitud->marca_id)
                           ->first();             
            ?>
            <li>
               <i class="fa fa-hand-pointer-o bg-blue"></i>
               <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                  <h3 class="timeline-header"><a href="#" onclick="mostrarDatos({{$distribuidor->id}});">{{ $distribuidor->nombre }}</a> ha indicado que distribuye tu marca.</h3>

                  <div class="timeline-body">
                     El distribuidor <strong>{{ $distribuidor->nombre }}</strong> ha indicado que distribuye tu marca <strong>{{ $marca->nombre }}</strong> en la provincia de <strong>{{ $provincia->provincia }}, {{ $pais->pais }}</strong>...
                  </div>
            
                  <div class="timeline-footer">
                     <a class="btn btn-primary btn-xs" href="{{ route('productor.confirmar-distribuidor', [$solicitud->id, 'S', $distribuidor->id]) }}">¡Confirmar!</a>
                     <a class="btn btn-danger btn-xs" href="{{ route('productor.confirmar-distribuidor', [$solicitud->id, 'N', $distribuidor->id]) }}">¡No Confirmar!</a>
                  </div>
               </div>
            </li>
         @endforeach
      </ul>
   </div>
@endsection

@section('paginacion')
   {{$solicitudes->render()}}
@endsection
