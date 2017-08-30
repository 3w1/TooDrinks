@extends('adminWeb.plantillas.main')
@section('title', 'Crear Marca')

@section('title-header')
   Nueva Marca
@endsection

{!! Html::script('js/marcas/create.js') !!}

@section('content-left')

	{!! Form::open(['route'=>'admin.marca-store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
		
		@if (session('adminRol') == 'AD')
			{!! Form::hidden('tipo_creador', 'AD') !!}
		@else
			{!! Form::hidden('tipo_creador', 'SA') !!}
		@endif

		{!! Form::hidden('creador_id', session('adminId')) !!}
		{!! Form::hidden('productor_id', '0') !!}
		{!! Form::hidden('reclamada', '0') !!}
		{!! Form::hidden('aprobada', '0') !!}
		{!! Form::hidden('publicada', '1') !!}

		<div class="form-group">
			{!! Form::label ('nombre','Nombre (*)') !!}
			{!! Form::text ('nombre',null,['class'=>'form-control','placeholder'=>'Ej. Polar', 'required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('nombre_seo','Nombre Seo') !!}
			{!! Form::text ('nombre_seo',null,['class'=>'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('descripcion','Descripción') !!}
			{!! Form::textarea('descripcion',null,['class'=>'form-control', 'rows' => '4']) !!}
		</div>

		<div class="form-group">
			{!! Form::label ('pais_id','País (*)') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'id' => 'pais_id', 'placeholder' => 'Seleccione un país..', 'onchange' => 'cargarProvincias();','required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label ('website','Website') !!}
			{!! Form::text ('website', null, ['class'=>'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label ('logo', 'Logo') !!}
			{!! Form::file ('logo', ['class'=>'form-control','required']) !!}
		</div>

		{!! Form::submit ('Agregar',['class'=>'btn btn-primary']) !!}
	
	{!! Form::close() !!}
@endsection