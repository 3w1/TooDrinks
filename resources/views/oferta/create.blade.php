@extends('plantillas.main')
@section('title', 'Crear Oferta de Producto')

@section('items')
	
@endsection

@section('content-left')
	@section('title-header')

		@if ($tipo == '1')
			<h3><b>Crear Oferta  del Producto {{ $producto }}</b></h3>
		@else
			<h3><b>Crear Oferta  de Producto </b></h3>
		@endif
	@endsection

	<div class="form-group">
		@if ( (session('perfilSuscripcion') == 'Gratis') || (session('perfilSuscripcion') == 'Basic') )
			@if (session('perfilSaldo') >= '25')
				<div class="alert alert-danger">
			        Se le descontarán <strong>25 Créditos</strong> de su saldo para crear la oferta. Para crear una oferta sin créditos debe tener Suscripción Advanced o Premium.
			    </div>
			@else
				<div class="alert alert-danger">
			        No tiene créditos suficientes para realizar esta acción. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Advanced o Premium. <a href="">Ver Suscripciones</a> 
			    </div>
			@endif
		@endif
	</div>

	@include('oferta.formularios.createForm')
	
@endsection