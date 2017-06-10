@extends('plantillas.distribuidor.mainDistribuidor')
@section('title', 'Ver Producto')

@section('items')
@endsection

@section('content-left')

	@include('distribuidor.modales.cambiarLogoProducto')

	@include('distribuidor.modales.editProducto')

	@section('title-header')
		<h3>Detalles del Producto: <strong>{{ $producto->nombre }}</strong></h3>
	@endsection
		
	@include('producto.show')

@endsection
