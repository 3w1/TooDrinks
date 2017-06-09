@extends('plantillas.importador.mainImportador')
@section('title', 'Registrar Distribuidor')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Registrar Distribuidor</b></h3>
	@endsection
	
	{!! Form::open(['route' => 'distribuidor.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('who', 'I') !!}
		@include('distribuidor.formularios.createForm')
	{!! Form::close() !!}

@endsection