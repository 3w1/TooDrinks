@extends('plantillas.main')
@section('title', 'Demanda de Distribuidor')

@section('items')
	<span><strong><h3>Modificar Demanda de Distribución</h3></strong></span>
@endsection

@section('content-left')
	{!! Form::open(['route' => ['demanda-distribuidor.update', $demandaDistribuidor->id], 'method' => 'PUT']) !!}
		{!! Form::hidden('who', 'P') !!}
		
		@include('demandaDistribucion.formularios.editForm')
	{!! Form::close() !!}

@endsection