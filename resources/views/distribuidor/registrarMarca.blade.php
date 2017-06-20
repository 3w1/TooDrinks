@extends('plantillas.distribuidor.mainDistribuidor')
@section('title', 'Registrar Narca')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Registrar Marca</h3>
	@endsection
		
	{!! Form::open(['route'=>'marca.store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('who', 'D') !!}
		{!! Form::hidden ('tipo_creador','D') !!}
		{!! Form::hidden('creador_id', session('distribuidorId')) !!}
		{!! Form::hidden('productor_id', '0') !!}
		{!! Form::hidden('reclamada', '0') !!}
		{!! Form::hidden('aprobada', '0') !!}
		{!! Form::hidden('publicada', '0') !!}
		
		@include('marca.formularios.createForm')
	{!! Form::close() !!}

@endsection