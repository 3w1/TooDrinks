@extends('plantillas.main')
@section('title', 'Solicitudes')

@section('title-header')
   Solicitudes
@endsection

@section('title-complement')
   (Bebidas)
@endsection

@section('content-left')
   <?php 
      $not_dp = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DP')->where('leida', '=', '0')->get();
      $dp=0;
      foreach($not_dp as $ndp){
         $dp++;
      }

      $not_db = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DB')->where('leida', '=', '0')->get();
      $db=0;
      foreach($not_db as $ndb){
         $db++;
         DB::table('notificacion_d')->where('id', '=', $ndb->id)->update(['leida' => '1']);
      }

       $not_dd = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DD')->where('leida', '=', '0')->get();
      $dd=0;
      foreach($not_dd as $ndd){
         $dd++;
      }
   ?>

   @section('alertas')
      @if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
         </div>
      @endif
   @endsection  
   
   <ul class="nav nav-pills">
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.demandas-productos-disponibles') }}"><strong>PRODUCTO | 
         <small class="label bg-red">{{ $dp }}</small></strong></a>
      </li>
      <li class="active btn btn-default">
         <a href="{{ route('demanda-producto.demandas-bebidas-disponibles') }}"><strong>BEBIDA | <small class="label bg-orange">{{ $db }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-distribuidor.demandas-disponibles') }}"><strong>DISTRIBUCIÓN | <small class="label bg-orange">{{ $dd }}</small></strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <ul class="timeline">
                  @if ($cont > 0)
                     @foreach($demandasBebidas as $demandaBebida)
                        <?php 
                           $relacion = DB::table('distribuidor_demanda_producto')
                                    ->select('demanda_producto_id')
                                    ->where('demanda_producto_id', '=', $demandaBebida->id)
                                    ->where('distribuidor_id', '=', session('perfilId'))
                                    ->first();

                            if ($relacion == null){
                            	$demanda = App\Models\Demanda_Producto::find($demandaBebida->id);

                            	$horeca = DB::table('horeca')
                            			->select('pais_id')
                            			->where('id', '=', $demanda->creador_id)
                            			->first();

	                           	if ($horeca->pais_id == session('perfilPais')){
	                           		$disponible = '1';
	                           	}else{
	                           		$disponible = '0';
	                           	}
                            }
                        ?>
                        @if ($relacion == null)
                        	@if ($disponible == '1')
	                           <li>
	                              <i class="fa fa-hand-pointer-o bg-blue"></i>
	                              <div class="timeline-item">
	                                 <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demanda->created_at)) }}</span>
	                                 <h3 class="timeline-header">
	                                    Un Horeca está demandando un tipo de bebida que tu posees.
	                                 </h3>

	                                 <div class="timeline-body">
	                                    Un Horeca está en la búsqueda de <strong>{{ $demanda->bebida->nombre }}</strong>. 
	                                    <br><strong>Descripción de la Demanda:</strong> {{ $demanda->titulo }}. ({{ $demanda->descripcion }}).
	                                 </div>
	                           
	                                 <div class="timeline-footer">
	                                    <a class="btn btn-primary btn-xs" href="{{ route('demanda-producto.show', $demanda->id) }}">¡Más Detalles!</a>
	                                    <a class="btn btn-danger btn-xs" href="{{ route('demanda-producto.marcar', [$demandaBebida->id, '0']) }}">¡No Me Interesa!</a>
	                                 </div>
	                              </div>
	                           </li>
	                        @endif
                        @endif
                     @endforeach
                  @else
                     <strong>No existen demandas de bebida disponibles.</strong>
                  @endif
               </ul>
            </div>
         </div>
      </div>
   </div>
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                  
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$demandasBebidas->render()}}
@endsection

