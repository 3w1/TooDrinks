@extends('plantillas.main')
@section('title', 'Demandas de Importadores')

@section('title-header')
   Demandas de Importadores
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
         @foreach($demandasImportadores as $demandaImportador)
            <?php 
               $existe = DB::table('importador_marca')
                           ->where('importador_id', '=', session('perfilId'))
                           ->where('marca_id', '=', $demandaImportador->marca_id)
                           ->first();

               if ($existe == null){
                  $relacion = DB::table('importador_demanda_importador')
                           ->select('demanda_importador_id')
                           ->where('demanda_importador_id', '=', $demandaImportador->id)
                           ->where('importador_id', '=', session('perfilId'))
                           ->first();
               }else{
                  $relacion = '1';
               }            
            ?>

            @if ($relacion == null)
               <li>
                  <i class="fa fa-hand-pointer-o bg-blue"></i>

                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaImportador->created_at)) }}</span>

                        <h3 class="timeline-header">Un productor está buscando importadores para su marca.</h3>

                        <div class="timeline-body">
                           El productor <strong>{{ $demandaImportador->productor->nombre }}</strong> ha indicado que está en la búsqueda de nuevos importadores para su marca <strong>{{ $demandaImportador->marca->nombre }}</strong> en tu país...
                        </div>
               
                        <div class="timeline-footer">
                           <a class="btn btn-primary btn-xs" href="{{ route('demanda-importador.show', $demandaImportador->id) }}">¡Más Detalles!</a>
                           <a class="btn btn-danger btn-xs" href="{{ route('demanda-importador.marcar', [$demandaImportador->id, '0']) }}">¡No Me Interesa!</a>
                        </div>
                     </div>
                  </li>
               @endif
            @endforeach
         </ul>
      </div>
@endsection

@section('pagination')
	{{$demandasImportadores->render()}}
@endsection
