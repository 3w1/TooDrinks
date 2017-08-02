@extends('plantillas.main')
@section('title', 'Banner Publicitario')

@section('title-header')
   Banner Publicitario
@endsection

@section('title-complement')
   (Crear Nuevo)
@endsection

@section('content-left')
	
	{!! Form::open(['route' => 'banner-publicitario.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
		{!! Form::hidden('creador_id', session('perfilId')) !!}
		{!! Form::hidden('aprobado', '0') !!}

		<div class="form-group">	 
			{!! Form::label('titulo', 'Título del Banner (*)')!!}
			{!! Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un título para el banner publicitario', 'required']) !!}
		</div>	

		<div class="form-group">	
			{!! Form::label('descripcion', 'Descripción (*)')!!}
			{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese una breve descripción para el Espacio Publicitario', 'rows' => '5', 'required']) !!}
		</div>

		<div class="form-group">	
			{!! Form::label('url', 'Enlace del Banner (*)')!!}
			{!! Form::url('url_banner', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la url a la cual redirigirá el banner', 'required']) !!}
		</div>

		<div class="form-group">	
			{!! Form::label('imagen', 'Imagen del Banner (*)')!!}
			{!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
		</div>

		<div class="form-group">	
			{!! Form::submit('Crear Banner', ['class' => 'btn btn-primary pull-right'])!!}
		</div>	
	{!! Form::close() !!}
@endsection