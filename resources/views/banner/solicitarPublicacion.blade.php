@extends('plantillas.main')
@section('title', 'Banner Publicitario')

@section('items')
	 <span><h3>Solicitar Publicación del Banner <strong>{{ $banner->titulo}}</h3></strong></span>
@endsection

@section('content-left')
	
	{!! Form::open(['route' => 'banner-publicitario.guardar-solicitud', 'method' => 'POST']) !!}
		
		{!! Form::hidden('banner_id', $banner->id) !!}
		{!! Form::hidden('cantidad_clics', 0) !!}
		{!! Form::hidden('publicado', 0) !!}

		<div class="form-group">	
			{!! Form::label('pais', 'País Destino')!!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una país...']) !!}
		</div>		
		<div class="form-group">	
			{!! Form::label('tiempo', 'Tiempo de Publicación (Días)')!!}
			{!! Form::number('tiempo_publicacion', null, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">	
			{!! Form::submit('Guardar Solicitud', ['class' => 'btn btn-primary'])!!}
		</div>	
	{!! Form::close() !!}
@endsection