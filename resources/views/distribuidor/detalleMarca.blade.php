@extends('plantillas.main')
@section('title', 'Ver Marca')

@section('items')
@endsection

@section('content-left')
	
	<!-- MODAL PARA CAMBIAR EL LOGO DE LA MARCA -->
	@include('distribuidor.modales.cambiarLogoMarca')
	<!-- ./ MODAL PARA CAMBIAR EL LOGO DE LA MARCA ./ -->
	
	<!-- MODAL PARA MODIFICA LA MARCA -->
	@include('distribuidor.modales.editMarca')
	<!-- ./ MODAL PARA MODIFICAR LA MARCA ./ -->

	@section('title-header')
		<h3>Detalles de la Marca: <strong>{{ $marca->nombre }}</strong></h3>
	@endsection
		
	@include('marca.show')

@endsection
