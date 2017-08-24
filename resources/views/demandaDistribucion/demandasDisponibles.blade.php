@extends('plantillas.main')
@section('title', 'Demandas de Distribuidores')

@section('title-header')
   Demandas de Distribuidores
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
            
            @foreach($demandasDistribuidores as $demandaDistribuidor)
               <?php 
                  $existe = DB::table('distribuidor_marca')
                           ->where('distribuidor_id', '=', session('perfilId'))
                           ->where('marca_id', '=', $demandaDistribuidor->marca_id)
                           ->first();

                  if ($existe == null){
                     $relacion = DB::table('distribuidor_demanda_distribuidor')
                              ->select('demanda_distribuidor_id')
                              ->where('demanda_distribuidor_id', '=', $demandaDistribuidor->id)
                              ->where('distribuidor_id', '=', session('perfilId'))
                              ->first();
                  }else{
                     $relacion = '1';
                  }            
               ?>

               @if ($relacion == null)
                  <?php 
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
                            @if($demandaDistribuidor->tipo_creador == 'P') El productor @else El importador @endif <strong>{{ $creador->nombre }}</strong> ha indicado que está en la búsqueda de nuevos distribuidores para su marca <strong>{{ $demandaDistribuidor->marca->nombre }}</strong> en tu provincia...
                        </div>
               
                        <div class="timeline-footer">
                           <a class="btn btn-primary btn-xs" href="{{ route('demanda-distribuidor.show', $demandaDistribuidor->id) }}">¡Más Detalles!</a>
                           <a class="btn btn-danger btn-xs" href="{{ route('demanda-distribuidor.marcar', [$demandaDistribuidor->id, '0']) }}">¡No Me Interesa!</a>
                        </div>
                     </div>
                  </li>
               @endif
            @endforeach
         </ul>
      </div>
@endsection

@section('paginacion')
   {{$demandasDistribuidores->render()}}
@endsection
