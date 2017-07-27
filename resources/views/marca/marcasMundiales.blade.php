@extends('plantillas.main')
@section('title', 'Listado de Marcas')

{!!Html::script('js/marcas/buscar.js') !!}

@section('title-header')
	<span><strong><h3>Marcas Mundiales</h3></strong></span>
@endsection

@section('content-left')
	<div class="alert alert-danger alert-dismissable" style="display: none;" id="alerta">
        <div id="mensaje"></div>
    </div>
	
	@include('marca.modales.detallesMarca')

	<div class="box box-success">
   		<div class="box-header with-border">
      		<h3 class="box-title">Búsqueda por Nombre</h3>
      		<div class="box-tools pull-right">
         		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      		</div>
   		</div>
	   	<div class="box-body">
      		<div class="form-group">
				{!! Form::label('label', 'Introduzca el nombre de la marca que desea buscar')!!}
				{!! Form::text('busqueda', null, ['class' => 'form-control', 'placeholder' => 'Marca', 'id' => 'busqueda']) !!}
			</div>
			
			<div class="form-group">
				<center><button class="btn btn-primary" onclick="buscarMarca();">Buscar</button></center>
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
			      		<h3 class="box-title">Búsqueda por Productor</h3>
			   		</div>

			   		<div class="box-body">
			   			<div class="form-group">
			   				{!! Form::text('productor', null, ['class' => 'form-control', 'placeholder' => 'Escriba el nombre del productos..', 'id' => 'productor']) !!}
			   			</div>
			   			<div class="form-group">
							<center><button class="btn btn-primary" onclick="buscarPorProductor();">Buscar</button></center>
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

	<div id="marcas"></div>

@endsection