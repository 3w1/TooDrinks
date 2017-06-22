@extends('plantillas.main')
@section('title', 'Crear Demanda de Importación')

@section('items')
@endsection

@section('content-left')
	
	@section('title-header')
		<h3><b>Solicitar Importador</b></h3>
	@endsection

	@include('demandaImportacion.formularios.createForm')
	
@endsection