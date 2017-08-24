@extends('plantillas.main')
@section('title', 'Crear Demanda de Importación')

@section('title-header')
   Demanda de Importador
@endsection

@section('title-complement')
   (Nueva Demanda)
@endsection

@section('content-left')
	<?php 
		$coste = DB::table('coste_credito')
				->select('cantidad_creditos')
				->where('accion', '=', 'DI')
				->where('entidad', '=', 'P')
				->first();
	?>
	
	@section('alertas')
      	@if ( (session('perfilSuscripcion') == 'Gratis') || (session('perfilSuscripcion') == 'Bronce') )
			@if (session('perfilSaldo') >= $coste->cantidad_creditos)
				<div class="alert alert-danger">
			        Se le descontarán <strong>{{$coste->cantidad_creditos}} créditos</strong> de su saldo para crear la solciitud. Para publicar una soliciutd sin pagar créditos debe tener Suscripción Plata u Oro.
			    </div>
			@else
				<div class="alert alert-danger">
			        No tiene créditos suficientes para realizar esta acción. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Plata u Oro. <a href="#">Ver Suscripciones</a> 
			    </div>
			@endif
		@endif

		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Recuerde que solo se muestran los países que eligió como posibles destinos laborales. Para agregar o quitar países diríjase a la sección de su Perfil</strong>
		</div> 
   	@endsection

	@include('demandaImportacion.formularios.createForm')
	
@endsection