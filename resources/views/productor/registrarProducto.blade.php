@extends('plantillas.productor.mainProductor')
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

			@include('producto.formularios.createForm')

		{!! Form::close() !!}

@endsection