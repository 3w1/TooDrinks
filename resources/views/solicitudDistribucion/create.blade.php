@extends('plantillas.main')
@section('title', 'Solicitar Importación de una Marca')

	{!!Html::script('js/productos/buscar.js') !!}

@section('items')
@endsection

@section('content-left')

	@include('solicitudDistribucion.modales.confirmarDistribucion')
	@section('title-header')
		<h3><b>Solicitar Distribución</b></h3>
	@endsection
	
	<div class="row">
		<div class="form-group">
			{!! Form::label('label', 'Introduzca el nombre del producto que desea distribuir')!!}
			{!! Form::text('busqueda', null, ['class' => 'form-control', 'placeholder' => 'Producto', 'id' => 'busqueda']) !!}
		</div>
		<div class="form-group">
			<button class="btn btn-primary" onclick="buscarProducto();">Buscar</button>
		</div>
	</div>

	<div class="row" id="productos"></div>
@endsection