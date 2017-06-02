@extends('plantillas.productor.mainProductor')
@section('title', 'Registrar Perfil')

@section('items')
@endsection

@section('content-left')

	@if ($perfil == 'I')

		@section('title-header')
			<h3><b>Registrar Importador</b></h3>
		@endsection
		{!! Form::open(['route' => 'importador.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
			{!! Form::hidden('who', 'P') !!}
			@include('importador.formularios.createForm')
		{!! Form::close() !!}

	@elseif($perfil == 'D')
		
		@section('title-header')
			<h3><b>Registrar Distribuidor</b></h3>
		@endsection
		{!! Form::open(['route' => 'distribuidor.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
			{!! Form::hidden('who', 'P') !!}
			@include('distribuidor.formularios.createForm')
		{!! Form::close() !!}
	@endif

@endsection