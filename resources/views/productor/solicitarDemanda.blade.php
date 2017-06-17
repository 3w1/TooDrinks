@extends('plantillas.main')
@section('title', 'Solicitar Demanda')

@section('items')
@endsection

@section('content-left')

	@if($tipo == 'I')

		@section('title-header')
			<h3><b>Solicitar Importador</b></h3>
		@endsection

		{!! Form::open(['route' => 'demanda-importador.store', 'method' => 'POST']) !!}

			{!! Form::hidden('productor_id', session('perfilId')) !!}
		
			@include('demandaImportacion.formularios.createForm')
		
		{!! Form::close() !!}

	@elseif ($tipo == 'D')

		@section('title-header')
			<h3><b>Solicitar Distribuidor</b></h3>
		@endsection

		{!! Form::open(['route' => 'demanda-distribuidor.store', 'method' => 'POST']) !!}

			{!! Form::hidden('who', 'P') !!}
			{!! Form::hidden('tipo_creador', 'P') !!}
			{!! Form::hidden('creador_id', session('perfilId')) !!}

			@include('demandaDistribucion.formularios.createForm')

		{!! Form::close() !!}

	@endif

@endsection