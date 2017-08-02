@extends('plantillas.main')
@section('title', 'Producto')

@section('title-header')
   Productos
@endsection

@section('title-complement')
	@if ($id == '0')
   		(Nuevo Producto)
   	@else
   		(Nuevo Producto a la Marca {{$marca}})
   	@endif
@endsection

@section('content-left')
	
	@section('alertas')
     	@include('plantillas.alertas.AlertasRequest')
   	@endsection 
	
	@include('producto.formularios.createForm')

@endsection