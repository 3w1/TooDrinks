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
	
	@section('alertas')
      	@if (Session::has('msj'))
         	<div class="alert alert-success alert-dismissable">
            	<button type="button" class="close" data-dismiss="alert">&times;</button>
            	<strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        	</div>
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