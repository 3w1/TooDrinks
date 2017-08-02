@extends('plantillas.main')
@section('title', 'Crear Demanda de Producto')

@section('title-header')
   Demanda de Producto
@endsection

@section('title-complement')
   (Crear Nueva)
@endsection

@section('content-left')

	@include('demandaProducto.formularios.createForm')
	
@endsection