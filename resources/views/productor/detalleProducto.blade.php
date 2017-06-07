@extends('plantillas.productor.mainProductor')
@section('title', 'Ver Producto')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3>Detalles del Producto: <strong>{{ $producto->nombre }}</strong></h3>
	@endsection
		
	@include('producto.show')

@endsection
