@extends('plantillas.main')
@section('title', 'Crear Marca')

@section('title-header')
   Marcas
@endsection

@section('title-complement')
   (Nueva Marca)
@endsection

@section('content-left')
	
	@include('marca.formularios.createForm')
	
@endsection