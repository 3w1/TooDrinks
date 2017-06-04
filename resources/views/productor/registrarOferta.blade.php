@extends('plantillas.productor.mainProductor')
@section('title', 'Crear Oferta')

@section('items')

@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Crear Oferta  del Producto {{ $producto }}</b></h3>
	@endsection
	
	{!! Form::open(['route' => 'oferta.store', 'method' => 'POST']) !!}
		{!! Form::hidden('who', 'P') !!}

		{!! Form::hidden('tipo_creador', 'P') !!}
		{!! Form::hidden('creador_id', session('productorId')) !!}
		{!! Form::hidden('producto_id', $id) !!}

			@include('oferta.formularios.createForm')
		
		{!! Form::close() !!}

@endsection