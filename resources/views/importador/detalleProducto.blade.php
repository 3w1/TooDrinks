@extends('plantillas.main')
@section('title', 'Ver Producto')

@section('items')
@endsection

@section('content-left')

	@include('importador.modales.cambiarLogoProducto')

	@include('importador.modales.editProducto')

	@section('title-header')
		<h3>Detalles del Producto: <strong>{{ $producto->nombre }}</strong></h3>
	@endsection
		
	@include('producto.show')

@endsection
