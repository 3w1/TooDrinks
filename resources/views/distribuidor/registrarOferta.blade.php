@extends('plantillas.distribuidor.mainDistribuidor')
@section('title', 'Crear Oferta')

@section('items')

@endsection

@section('content-left')
	
	@section('title-header')
		<h3><b>Crear Oferta  del Producto {{ $producto }}</b></h3>
	@endsection
	
	{!! Form::open(['route' => 'oferta.store', 'method' => 'POST']) !!}
		
		{!! Form::hidden('who', 'D') !!}

		{!! Form::hidden('tipo_creador', 'D') !!}
		{!! Form::hidden('creador_id', session('distribuidorId')) !!}
		{!! Form::hidden('producto_id', $id) !!}
		{!! Form::hidden('visible_importadores', '0') !!}
		{!! Form::hidden('visible_distribuidores', '0') !!}
		{!! Form::hidden('visible_horecas', '1') !!}

			@include('oferta.formularios.createForm')
		
		{!! Form::close() !!}

@endsection