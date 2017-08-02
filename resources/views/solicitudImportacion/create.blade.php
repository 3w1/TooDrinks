@extends('plantillas.main')
@section('title', 'Solicitar Importación de una Marca')

{!!Html::script('js/productos/buscar.js') !!}

@section('title-header')
   Demanda de Importación
@endsection

@section('title-complement')
   (Crear Nueva)
@endsection

@section('content-left')
	@section('alertas')
		<div class="alert alert-danger alert-dismissable" style="display: none;" id="alerta">
	        <button type="button" class="close" data-dismiss="alert">&times;</button>
	        <div id="mensaje"></div>
	    </div>
	@endsection
	
	@include('solicitudImportacion.modales.confirmarImportacion')
	
	<div class="box box-success">
   		<div class="box-header with-border">
      		<h3 class="box-title">Búsqueda por Nombre</h3>
      		<div class="box-tools pull-right">
         		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      		</div>
   		</div>
	   	<div class="box-body">
      		<div class="form-group">
				{!! Form::label('label', 'Introduzca el nombre del producto que desea importar')!!}
				{!! Form::text('busqueda', null, ['class' => 'form-control', 'placeholder' => 'Producto', 'id' => 'busqueda']) !!}

			</div>
			
			<div class="form-group">
				<center><button class="btn btn-primary" onclick="buscarProducto();">Buscar</button></center>
			</div>
   		</div>
   	</div>

   	<div class="box box-success">
   		<div class="box-header with-border">
      		<h3 class="box-title">Búsqueda Personalizada</h3>
      		<div class="box-tools pull-right">
         		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      		</div>
   		</div>
	   	<div class="box-body">
	   		<div class="col-md-6">
		   		<div class="box box-warning">
		   			<div class="box-header with-border">
			      		<h3 class="box-title">Búsqueda por Bebida</h3>
			   		</div>

			   		<div class="box-body">
			   			<div class="form-group">
			   				{!! Form::select('bebida', $bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo de bebida..', 'onchange' => 'cargarCategorias();', 'id' => 'bebida']) !!}
			   			</div>
			   			<div class="form-group">
			   				<select class="form-control" id="clase">
			   					<option value="">Seleccione una clase de bebida..</option>
			   					<option value="0">Todas</option>
			   				</select>
			   			</div>
			   			<div class="form-group">
							<center><button class="btn btn-primary" onclick="buscarPorClase();">Buscar</button></center>
						</div>
			   		</div>
		   		</div>
		   	</div>

		   	<div class="col-md-6">
		   		<div class="box box-danger">
		   			<div class="box-header with-border">
			      		<h3 class="box-title">Búsqueda por País</h3>
			   		</div>

			   		<div class="box-body">
			   			<div class="form-group">
			   				{!! Form::select('tipo_bebida', $bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo de bebida..', 'id' => 'tipo_bebida']) !!}
			   			</div>
			   			<div class="form-group">
			   				{!! Form::select('pais', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'id' => 'pais']) !!}
			   			</div>
			   			<div class="form-group">
							<center><button class="btn btn-primary" onclick="buscarPorPais();">Buscar</button></center>
						</div>
			   		</div>
		   		</div>
		   	</div>
		</div>
   	</div>

	<div class="row" id="productos"></div>
@endsection