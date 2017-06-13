@extends('plantillas.main')
@section('title', 'Registrar Producto')

@section('items')

@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Agregar Producto a la Marca {{ $marca }}</b></h3>
	@endsection
	
	{!! Form::open(['route' => 'producto.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('who', 'P') !!}

		{!! Form::hidden('marca_id', $id)!!}
		{!! Form::hidden('marca_nombre', $marca) !!}
		{!! Form::hidden('tipo_creador', 'P') !!}
		{!! Form::hidden('creador_id', session('productorId')) !!}
		{!! Form::hidden('publicado', '1') !!}
		{!! Form::hidden('confirmado', '1') !!}

			@include('producto.formularios.createForm')
		

		{!! Form::close() !!}

@endsection