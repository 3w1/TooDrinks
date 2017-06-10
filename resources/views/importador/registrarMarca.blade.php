@extends('plantillas.importador.mainImportador')
@section('title', 'Registrar Narca')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Registrar Marca</h3>
	@endsection
		
	{!! Form::open(['route'=>'marca.store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('who', 'I') !!}
		{!! Form::hidden ('tipo_creador','I') !!}
		{!! Form::hidden('creador_id', session('importadorId')) !!}
		{!! Form::hidden('productor_id', '0') !!}
		{!! Form::hidden('reclamada', '0') !!}
		
		@include('marca.formularios.createForm')
	{!! Form::close() !!}

@endsection