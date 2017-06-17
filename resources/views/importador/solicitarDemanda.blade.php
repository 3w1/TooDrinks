@extends('plantillas.main')
@section('title', 'Solicitar Demanda')

@section('items')
@endsection

@section('content-left')

	@if($tipo == 'D')

		@section('title-header')
			<h3><b>Solicitar Distribuidor</b></h3>
		@endsection

		{!! Form::open(['route' => 'demanda-distribuidor.store', 'method' => 'POST']) !!}

			{!! Form::hidden('who', 'I') !!}
			{!! Form::hidden('tipo_creador', 'I') !!}
			{!! Form::hidden('creador_id', session('perfilId')) !!}

			@include('demandaDistribucion.formularios.createForm')

		{!! Form::close() !!}

	@endif

@endsection