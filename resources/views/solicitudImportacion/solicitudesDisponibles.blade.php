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
                        <a class="btn btn-primary btn-xs" href="{{ route('solicitar-importacion.show', $demandaImportacion->id) }}">¡Más Detalles!</a>
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
