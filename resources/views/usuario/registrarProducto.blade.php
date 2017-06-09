@extends('plantillas.usuario.mainUsuario')
@section('title', 'Registrar Producto')

@section('items')

@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Agregar Producto</b></h3>
	@endsection
	
	{!! Form::open(['route' => 'producto.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('who', 'U') !!}
		{!! Form::hidden('productor_id', '9') !!}
		{!! Form::hidden('tipo_creador', 'U') !!}
		{!! Form::hidden('creador_id', Auth::user()->id) !!}
		{!! Form::hidden('publicado', '0') !!}
		{!! Form::hidden('confirmado', '0') !!}

		{!! Form::label('marca', 'Marca propietaria del Producto') !!}
		{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una marca..']) !!}

			@include('producto.formularios.createForm')
		

		{!! Form::close() !!}

@endsection