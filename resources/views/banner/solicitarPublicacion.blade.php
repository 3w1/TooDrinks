@extends('plantillas.main')
@section('title', 'Banner Publicitario')

{!! Html::script('js/banners/consultarDisponibilidad.js') !!}

@section('items')
	 <span><h3>Solicitar Publicación del Banner <strong>{{ $banner->titulo}}</h3></strong></span>
@endsection

@section('content-left')
	
	{!! Form::open(['route' => 'banner-publicitario.guardar-solicitud', 'method' => 'POST']) !!}
		
		{!! Form::hidden('banner_id', $banner->id, ['id' => 'banner_id']) !!}
		{!! Form::hidden('cantidad_clics', 0) !!}
		{!! Form::hidden('publicado', 0) !!}
		{!! Form::hidden('pagado', 0) !!}
		{!! Form::hidden('fecha_inicio', null, ['id' => 'fecha_inicio']) !!}
		{!! Form::hidden('fecha_fin', null, ['id' => 'fecha_fin']) !!}
		{!! Form::hidden('precio', null, ['id' => 'precio']) !!}
		
		<div class="form-group">	
			{!! Form::label('pais', 'País Destino')!!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una país...', 'id' => 'pais']) !!}
		</div>		

		<div class="form-group">	
			{!! Form::label('tiempo', 'Tiempo de Publicación (Días)')!!}
			{!! Form::select('tiempo_publicacion', ['15' => '15 Días', '30' => '30 Días', '60' => '60 Días'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción..', 'id' => 'dias']) !!}
		</div>

		<div class="form-group">	
			{!! Form::button('Consultar Disponibilidad', ['class' => 'btn btn-primary pull-right', 'onclick' => 'consultarDisponibilidad();'])!!}
		</div><br><br><br>	

		<div class="alert alert-success" id="fechas" style="display: none;">
			
		</div>
	
		<button class="btn btn-primary pull-right" id="boton" style="display: none;">Continuar</button>

	{!! Form::close() !!}
@endsection