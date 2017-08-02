@extends('plantillas.main')
@section('title', 'Modificar Demanda de Producto')

@section('title-header')
   Demanda de Producto
@endsection

@section('title-complement')
	(Editar Demanda)
@endsection

@section('content-left')
	
	@include('demandaProducto.formularios.editForm')
	
@endsection