@extends('plantillas.productor.mainProductor')
@section('title', 'Registrar Narca')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Registrar Marca</h3>
	@endsection
		
	{!! Form::open(['route'=>'marca.store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('who', 'P') !!}
		{!! Form::hidden ('tipo_creador','P') !!}
		{!! Form::hidden('creador_id', session('productorId')) !!}
		{!! Form::hidden('productor_id', session('productorId')) !!}
		{!! Form::hidden('reclamada', '1') !!}
		
	<div class="form-group">
		{!! Form::label ('nombre','Nombre') !!}
		{!! Form::text ('nombre',null,['class'=>'form-control','placeholder'=>'Ej. Polar', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('nombre_seo','Nombre Seo') !!}
		{!! Form::text ('nombre_seo',null,['class'=>'form-control','placeholder'=>'Ej. Polar Seo', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('descripcion','Descripcion') !!}
		{!! Form::text ('descripcion',null,['class'=>'form-control','placeholder'=>'Ej. ', 'required']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label ('pais_id','País') !!}
		<select name="pais_id" class="form-control">
			@foreach($paises as $pais)
				<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		{!! Form::label ('provincia_region_id','Provincia / Región') !!}
		<select name="provincia_region_id" class="form-control">
			@foreach($provincias as $provincia)
				<option value="{{ $provincia->id }}">{{ $provincia->provincia }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		{!! Form::label ('logo', 'Logo') !!}
		{!! Form::file ('logo', ['class'=>'form-control','required']) !!}
	</div>

	{!! Form::submit ('Agregar',['class'=>'btn btn-primary']) !!}
	{!! Form::close() !!}

@endsection