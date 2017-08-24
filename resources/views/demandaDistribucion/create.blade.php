@extends('plantillas.main')
@section('title', 'Solicitar Distribuidor')

@section('title-header')
   Demanda de Distribuidor
@endsection

@section('title-complement')
   (Nueva Demanda)
@endsection

@section('content-left')
	<?php 
		$coste = DB::table('coste_credito')
				->select('cantidad_creditos')
				->where('accion', '=', 'DD')
				->where('entidad', '=', session('perfilTipo'))
				->first();
	?>
	
	@section('alertas')
      	@if ( (session('perfilSuscripcion') == 'Gratis') || (session('perfilSuscripcion') == 'Bronce') )
			@if (session('perfilSaldo') >= $coste->cantidad_creditos)
				<div class="alert alert-danger">
			        Se le descontarán <strong>{{$coste->cantidad_creditos}} créditos</strong> de su saldo para crear la solicitud. Para publicar una soliciutd sin pagar créditos debe tener Suscripción Plata u Oro.
			    </div>
			@else
				<div class="alert alert-danger">
			        No tiene créditos suficientes para realizar esta acción. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Plata u Oro. <a href="#">Ver Suscripciones</a> 
			    </div>
			@endif
		@endif
   	@endsection

	@include('demandaDistribucion.formularios.createForm')

@endsection