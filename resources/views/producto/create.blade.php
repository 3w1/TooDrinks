@extends('plantillas.main')
@section('title', 'Agregar Producto')

@section('items')

@endsection

@section('content-left')

	@section('title-header')
		@if ($id == '0')
			<h3><b>Agregar Producto</b></h3>
		@else 
			<h3><b>Agregar Producto a la Marca {{ $marca }}</b></h3>
		@endif
	@endsection
	
	@include('producto.formularios.createForm')

@endsection