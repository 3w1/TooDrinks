@extends('adminWeb.plantillas.main')
@section('title', 'Banner Publicitario')

{!! Html::script('js/adminWeb/cargarEntidades.js') !!}

@section('title-header')
   Banner Publicitario
@endsection

@section('title-complement')
   (Crear Nuevo)
@endsection

@section('content-left')
	
	{!! Form::open(['route' => 'admin.banner-store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('aprobado', '1') !!}
		{!! Form::hidden('admin', '1') !!}
		
		<div class="form-group">	
			{!! Form::label('tipo_entidad', 'Tipo de Entidad (*)')!!}
			{!! Form::select('tipo_creador', ['P' => 'Productor', 'I' => 'Importador', 'D' => 'Distribuidor'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...', 'required', 'onchange' => 'cargarEntidades();', 'id' => 'tipo_entidad']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('url', 'Entidad (*)')!!}
			<select class="form-control" name="creador_id" id="entidad_id" disabled>
				<option value="">Seleccione una opción</option>
			</select>
		</div>

		<div class="form-group">	 
			{!! Form::label('titulo', 'Título (*)')!!}
			{!! Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un título para el banner publicitario', 'required']) !!}
		</div>	

		<div class="form-group">	
			{!! Form::label('descripcion', 'Descripción (*)')!!}
			{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese una breve descripción para el Espacio Publicitario', 'rows' => '5', 'required']) !!}
		</div>

		<div class="form-group">	
			{!! Form::label('url', 'Enlace (*)')!!}
			{!! Form::url('url_banner', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la url a la cual redirigirá el banner', 'required']) !!}
		</div>

		<div class="form-group">	
			{!! Form::label('imagen', 'Imagen (*)')!!}
			{!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
		</div>

		<div class="form-group">	
			{!! Form::submit('Crear Banner', ['class' => 'btn btn-primary pull-right'])!!}
		</div>	
	{!! Form::close() !!}
@endsection