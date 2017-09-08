{!! Html::script('js/productos/edit.js') !!}
{!! Html::script('js/productos/cargarClases.js') !!}

<?php 
	$paises = DB::table('pais')
				->orderBy('pais', 'ASC')
				->pluck('pais', 'id');

	$provincias = DB::table('provincia_region')
					->orderBy('provincia')
					->where('pais_id', '=', $producto->pais_id)
					->pluck('provincia', 'id');

	$bebidas = DB::table('bebida')
						->orderBy('nombre')
						->pluck('nombre', 'id');
	
	$clases_bebidas = DB::table('clase_bebida')
						->where('bebida_id', $producto->bebida_id)
						->orderBy('clase')
						->pluck('clase', 'id');
?>

{!! Form::open(['route' => ['producto.update', $producto->id], 'method' => 'PUT', 'name' => 'editForm']) !!}
	
	{!! Form::hidden('id_producto', $producto->id, ['id' => 'id_producto']) !!}
	{!! Form::hidden('marca_id', $producto->marca_id, ['id' => 'marca_hidden']) !!}

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre (*)') !!}
		{!! Form::text('nombre', $producto->nombre, ['class' => 'form-control', 'required', 'id' => 'nombre'] ) !!}
		<div class="alert alert-danger" style="display: none;" id="errorNombre">
			<strong>Ups!!</strong> Ya existe un producto con este nombre.
		</div>
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre Seo (*)') !!}
		{!! Form::text('nombre_seo', $producto->nombre_seo, ['class' => 'form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción') !!}
		{!! Form::text('descripcion', $producto->descripcion, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'País (*)') !!}
		{!! Form::select('pais_id', $paises, $producto->pais_id, ['class' => 'form-control', 'onchange' => 'cargarProvincias();']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('bebida', 'Bebida (*)') !!}
		{!! Form::select('bebida_id', $bebidas, $producto->bebida_id, ['class' => 'form-control', 'onchange' => 'cargarClases("C");', 'id' => 'bebida_id', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('clase_bebida', 'Clase de Bebida (*)') !!}
		{!! Form::select('clase_bebida_id', $clases_bebidas, $producto->clase_bebida_id, ['class' => 'form-control', 'id' => 'clases_bebidas', 'required']) !!}
	</div>
			
	<div class="form-group">
		{!! Form::label('ano_produccion', 'Año de Producción') !!}
		{!! Form::text('ano_produccion', $producto->ano_produccion, ['class' => 'form-control'] ) !!}
	</div>