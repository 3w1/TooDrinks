@extends('plantillas.main')
@section('title', 'Demanda de Importador')

@section('items')
	<span><strong><h3>Modificar Demanda de Importador</h3></strong></span>
@endsection

@section('content-left')
	
	@include('demandaImportacion.formularios.editForm')
	
@endsection