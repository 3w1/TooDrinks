@extends('plantillas.usuario.mainUsuario')
@section('title', 'Registrar Perfil')

@section('items')
@endsection

@section('content-left')

	@if($perfil == 'P')

		@section('title-header')
			<h3><b>Registrar Productor</b></h3>
		@endsection
		{!! Form::open(['route' => 'productor.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
			@include('productor.formularios.createForm')
		{!! Form::close() !!}

	@elseif ($perfil == 'I')

		@section('title-header')
			<h3><b>Registrar Importador</b></h3>
		@endsection
		{!! Form::open(['route' => 'importador.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
			{!! Form::hidden('who', 'U') !!}
			@include('importador.formularios.createForm')
		{!! Form::close() !!}

	@elseif($perfil == 'D')
		
		@section('title-header')
			<h3><b>Registrar Distribuidor</b></h3>
		@endsection
		{!! Form::open(['route' => 'distribuidor.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
			{!! Form::hidden('who', 'U') !!}
			@include('distribuidor.formularios.createForm')
		{!! Form::close() !!}
		
	@elseif($perfil == 'H')
		
		@section('title-header')
			<h3><b>Registrar Horeca</b></h3>
		@endsection
		{!! Form::open(['route' => 'horeca.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
			@include('horeca.formularios.createForm')
		{!! Form::close() !!}

	@endif

@endsection