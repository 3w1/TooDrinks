@extends('plantillas.main')
@section('title', 'Agregar Producto')

@section('items')

@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Agregar Producto a la Marca {{ $marca }}</b></h3>
	@endsection
	
	@include('producto.formularios.createForm')

@endsection