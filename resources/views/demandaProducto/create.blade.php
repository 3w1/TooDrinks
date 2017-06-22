@extends('plantillas.main')
@section('title', 'Crear Demanda de Producto')

@section('items')
@endsection

@section('content-left')

	@include('demandaProducto.formularios.createForm')
	
@endsection