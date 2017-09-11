@extends('plantillas.main')
@section('title', 'Solicitudes')

@section('title-header')
   Solicitudes
@endsection

@section('title-complement')
   (Productos)
@endsection

@section('content-left')
   <?php 
      $not_dp = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DP')->where('leida', '=', '0')->get();
      $dp=0;
      foreach($not_dp as $ndp){
         $dp++;
         DB::table('notificacion_d')->where('id', '=', $ndp->id)->update(['leida' => '1']);
      }

      $not_db = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DB')->where('leida', '=', '0')->get();
      $db=0;
      foreach($not_db as $ndb){
         $db++;
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
      <li class="active btn btn-default">
         <a href="{{ route('demanda-producto.demandas-productos-disponibles') }}"><strong>PRODUCTO | 
         <small class="label bg-orange">{{ $dp }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.demandas-bebidas-disponibles') }}"><strong>BEBIDA | <small class="label bg-red">{{ $db }}</small></strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <ul class="timeline">
                  @if ($cont > 0)
                     @foreach($demandasProductos as $demandaProducto)
                        <?php 
                           $relacion = DB::table('distribuidor_demanda_producto')
                                    ->select('demanda_producto_id')
                                    ->where('demanda_producto_id', '=', $demandaProducto->id)
                                    ->where('distribuidor_id', '=', session('perfilId'))
                                    ->first();

                            $horeca = DB::table('horeca')
                            			->select('pais_id')
                            			->where('id', '=', $demandaProducto->creador_id)
                            			->first();

                           	if ($horeca->pais_id == session('perfilPais')){
                           		$disponible = '1';
                           	}else{
                           		$disponible = '0';
                           	}
                        ?>
                        @if ($relacion == null)
                        	@if ($disponible == '1')
	                           <li>
	                              <i class="fa fa-hand-pointer-o bg-blue"></i>
	                              <div class="timeline-item">
	                                 <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaProducto->created_at)) }}</span>
	                                 <h3 class="timeline-header"> Un Horeca está demandando tu producto.</h3>
	                                 
	                                 <div class="timeline-body">
	                                    Un Horeca ha demandado tu producto <strong>{{ $demandaProducto->producto->nombre }}</strong>. <br>
	                                    <strong>Descripción de la Demanda:</strong> {{ $demandaProducto->titulo }}. ({{ $demandaProducto->descripcion }}).
	                                 </div>
	                        
	                                 <div class="timeline-footer">
	                                    <a class="btn btn-primary btn-xs" href="{{ route('demanda-producto.show', $demandaProducto->id) }}">¡Más Detalles!</a>
	                                    <a class="btn btn-danger btn-xs" href="{{ route('demanda-producto.marcar', [$demandaProducto->id, '0']) }}">¡No Me Interesa!</a>
	                                 </div>
	                              </div>
	                           </li>
	                        @endif
                        @endif
                     @endforeach
                  @else
                     <strong>No existen demandas de producto disponibles en su zona.</strong>
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
                  @include('solicitudes.tabs.filtroProducto')
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$demandasProductos->appends(Request::only(['producto']))->render()}}
@endsection

