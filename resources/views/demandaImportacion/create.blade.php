@extends('plantillas.main')
@section('title', 'Crear Demanda de Importación')

@section('title-header')
   Demanda de Importador
@endsection

@section('title-complement')
   (Nueva Demanda)
@endsection

@section('content-left')
	
	@include('demandaImportacion.formularios.createForm')
	
@endsection