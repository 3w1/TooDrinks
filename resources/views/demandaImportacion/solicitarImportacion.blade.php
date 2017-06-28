@extends('plantillas.main')
@section('title', 'Solicitar Importación de una Marca')

@section('items')
@endsection

@section('content-left')
	
	{!! Html::script('js/productos/buscar.js') !!}
	
	@section('title-header')
		<h3><b>Solicitar Importación</b></h3>
	@endsection
	
	<div class="row">
		<div class="form-group col-md-6">
			{!! Form::text('producto', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del producto que quiere importar', 'id' => 'producto']) !!}
		</div>
		<div class="form-group col-md-6">
			<a href="#" class="btn btn-success" onclick="buscarProducto();">Buscar</a> 
		</div>
	</div>

	<div class="row">
		<div class="col-md-12" id="productos">
			
		</div>
	</div>
	
	
@endsection