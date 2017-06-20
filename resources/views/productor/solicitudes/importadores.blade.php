@extends('plantillas.main')
@section('title', 'Solicitudes de Importadores')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Solicitudes de Importadores</h3></strong></span>
@endsection

@section('content-left')
   <div class="row">
      <div class="col-md-12">
         <ul class="timeline">
            
            @foreach($solicitudes as $solicitud)
               <?php 
                  $importador = DB::table('importador')
                                 ->select('id', 'nombre', 'pais_id')
                                 ->where('id', '=', $solicitud->importador_id)
                                 ->get()
                                 ->first();

                  $pais = DB::table('pais')
                           ->select('pais')
                           ->where('id', '=', $importador->pais_id)
                           ->get()
                           ->first();

                  $marca = DB::table('marca')
                                 ->where('id', '=', $solicitud->marca_id)
                                 ->get()
                                 ->first();             
               ?>

               <li>
                  <i class="fa fa-hand-pointer-o bg-blue"></i>

                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                     <h3 class="timeline-header"><a href="#">{{ $importador->nombre }}</a> ha indicado que importa tu marca.</h3>

                     <div class="timeline-body">
                        El importador <strong>{{ $importador->nombre }}</strong> ha indicado que importa tu marca <strong>{{ $marca->nombre }}</strong> en <strong>{{ $pais->pais }}</strong>...
                     </div>
            
                     <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('productor.confirmar-importador', [$solicitud->id, 'S', $importador->id]) }}">¡Confirmar!</a>
                        <a class="btn btn-danger btn-xs" href="{{ route('productor.confirmar-importador', [$solicitud->id, 'N', $importador->id]) }}">¡No Confirmar!</a>
                     </div>
                  </div>
               </li>
            @endforeach
         </ul>
      </div>
   
      <div>
        
      </div>
   </div>
@endsection
