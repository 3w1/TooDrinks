@extends('plantillas.main')
@section('title', 'Registrar Narca')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Registrar Marca</h3>
	@endsection
		
	{!! Form::open(['route'=>'marca.store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('who', 'P') !!}
		{!! Form::hidden ('tipo_creador','P') !!}
		{!! Form::hidden('creador_id', session('perfilId')) !!}
		{!! Form::hidden('productor_id', session('perfilId')) !!}
		{!! Form::hidden('reclamada', '1') !!}
		{!! Form::hidden('publicada', '0') !!}
		{!! Form::hidden('aprobada', '1') !!}
		
		@include('marca.formularios.createForm')
	{!! Form::close() !!}

@endsection