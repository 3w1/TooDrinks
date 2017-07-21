@extends('plantillas.main')
@section('title', 'Banner Publicitario')

@section('items')
	 <span><strong><h3>Crear Banner Publicitario</h3></strong></span>
@endsection

@section('content-left')
	
	{!! Form::open(['route' => 'banner-publicitario.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
		{!! Form::hidden('creador_id', session('perfilId')) !!}
		{!! Form::hidden('aprobado', '0') !!}

		<div class="form-group">	
			{!! Form::label('titulo', 'Título del Banner')!!}
			{!! Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el Título del Espacio Publicitario']) !!}
		</div>	
		<div class="form-group">	
			{!! Form::label('descripcion', 'Descripción')!!}
			{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese una breve descripción para el Espacio Publicitario', 'rows' => '5']) !!}
		</div>	
		<div class="form-group">	
			{!! Form::label('url', 'Enlace del Banner')!!}
			{!! Form::url('url_banner', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la url a la cual redirigirá el banner']) !!}
		</div>
		<div class="form-group">	
			{!! Form::label('imagen', 'Imagen del Banner')!!}
			{!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
		</div>	
		<div class="form-group">	
			{!! Form::submit('Crear Banner', ['class' => 'btn btn-primary'])!!}
		</div>	
	{!! Form::close() !!}
@endsection