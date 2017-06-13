@extends('plantillas.main')
@section('title', 'Demanda de Importador')

@section('items')
	<span><strong><h3>Modificar Demanda de Importador</h3></strong></span>
@endsection

@section('content-left')
	{!! Form::open(['route' => ['demanda-importador.update', $demandaImportador->id], 'method' => 'PUT']) !!}
		{!! Form::hidden('who', 'P') !!}
		
		@include('demandaImportacion.formularios.editForm')
	{!! Form::close() !!}

@endsection