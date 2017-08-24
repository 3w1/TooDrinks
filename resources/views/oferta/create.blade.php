@extends('plantillas.main')
@section('title', 'Crear Oferta de Producto')

@section('title-header')
   Oferta
@endsection

@section('title-complement')
	@if ($tipo == '1')
   		(Nueva Oferta de {{$producto}})
   	@else
   		(Nueva Oferta)
   	@endif
@endsection

@section('content-left')
	<?php 
		$coste = DB::table('coste_credito')
				->select('cantidad_creditos')
				->where('accion', '=', 'CO')
				->where('entidad', '=', session('perfilTipo'))
				->first();
	?>
	
	@section('alertas')
      	@if (Session::has('msj'))
         	<div class="alert alert-success alert-dismissable">
            	<button type="button" class="close" data-dismiss="alert">&times;</button>
            	<strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        	</div>
      	@endif

      	@if ( session('perfilSuscripcion') != 'Oro' )
			@if (session('perfilSaldo') >= $coste->cantidad_creditos)
				<div class="alert alert-danger">
			        Se le descontarán <strong>{{$coste->cantidad_creditos}} créditos</strong> de su saldo para crear la oferta. Para publicar una oferta sin pagar créditos debe tener Suscripción Oro.
			    </div>
			@else
				<div class="alert alert-danger">
			        No tiene créditos suficientes para realizar esta acción. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Oro. <a href="#">Ver Suscripciones</a> 
			    </div>
			@endif
		@endif
   	@endsection

	@include('oferta.formularios.createForm')
	
@endsection