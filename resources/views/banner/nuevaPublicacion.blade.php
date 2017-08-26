@extends('plantillas.main')
@section('title', 'Banner Publicitario')

{!! Html::script('js/banners/consultarDisponibilidad.js') !!}

@section('title-header')
   Nueva Publicación
@endsection

@section('title-complement')
   (Banners)
@endsection

@section('content-left')
	
	{!! Form::open(['route' => 'payment', 'method' => 'GET']) !!}
		
		{!! Form::hidden('cantidad_clics', 0) !!}
		{!! Form::hidden('pagado', 0) !!}
		{!! Form::hidden('fecha_inicio', null, ['id' => 'fecha_inicio']) !!}
		{!! Form::hidden('fecha_fin', null, ['id' => 'fecha_fin']) !!}
		{!! Form::hidden('precio', null, ['id' => 'precio']) !!}
		{!! Form::hidden('tipo', 'Banner') !!}
		
		<div class="form-group">	
			{!! Form::label('banner', 'Banner Publicitario')!!}
			{!! Form::select('banner_id', $banners, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un banner...', 'id' => 'banner']) !!}
		</div>	

		<div class="form-group">	
			{!! Form::label('pais', 'País Destino')!!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una país...', 'id' => 'pais']) !!}
		</div>		

		<div class="form-group">	
			{!! Form::label('tiempo', 'Tiempo de Publicación (Semanas)')!!}
			{!! Form::select('tiempo_publicacion', ['1' => '1 Semana', '2' => '2 Semanas', '3' => '3 Semanas', '4' => '4 Semanas'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción..', 'id' => 'semanas', 'onchange' => 'consultarDisponibilidad();']) !!}
		</div>

		<div class="alert alert-success" id="fechas" style="display: none;">
			
		</div>
	
		<button class="btn btn-primary pull-right" id="boton" style="display: none;">Continuar</button>

	{!! Form::close() !!}
@endsection