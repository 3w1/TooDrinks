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
                           <a class="btn btn-primary btn-xs" href="{{ route('demanda-importador.show', $demandaImportador->id) }}">¡Más Detalles!</a>
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
