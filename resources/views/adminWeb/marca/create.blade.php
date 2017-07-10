@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Crear Marca')

@section('title-header')
   Crear Marca
@endsection

{!! Html::script('js/marcas/create.js') !!}

@section('content-left')

	{!! Form::open(['route'=>'marca.store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
	
		{!! Form::hidden('tipo_creador', 'AD') !!}
		{!! Form::hidden('creador_id', Auth::user()->id) !!}
		{!! Form::hidden('productor_id', '0') !!}
		{!! Form::hidden('reclamada', '0') !!}
		{!! Form::hidden('aprobada', '0') !!}
		{!! Form::hidden('publicada', '1') !!}

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
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'id' => 'pais_id', 'placeholder' => 'Seleccione un país..', 'onchange' => 'cargarProvincias();']) !!}
		</div>

		<div class="form-group">
			{!! Form::label ('provincia_region_id','Provincia / Región') !!}
			<select name="provincia_region_id" class="form-control" id="provincias">
				<option value="">Seleccione una provincia..</option>
			</select>
		</div>

		<div class="form-group">
			{!! Form::label ('logo', 'Logo') !!}
			{!! Form::file ('logo', ['class'=>'form-control','required']) !!}
		</div>

		{!! Form::submit ('Agregar',['class'=>'btn btn-primary']) !!}
	
	{!! Form::close() !!}
@endsection