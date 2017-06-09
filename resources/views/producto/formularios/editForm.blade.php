	{!! Html::script('js/productos/edit.js') !!}

	<?php 
		$paises = DB::table('pais')
					->orderBy('pais', 'ASC')
					->pluck('pais', 'id');

		$provincias = DB::table('provincia_region')
						->orderBy('provincia')
						->where('pais_id', '=', $producto->pais_id)
						->pluck('provincia', 'id');

		$clases_bebidas = DB::table('clase_bebida')
							->orderBy('clase')
							->pluck('clase', 'id');
	 ?>
	
	{!! Form::hidden('id', $producto->id) !!}
	{!! Form::hidden('marca_id', $producto->marca_id, ['id' => 'marca_hidden']) !!}

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre') !!}
		{!! Form::text('nombre', $producto->nombre, ['class' => 'form-control', 'required', 'id' => 'nombre'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre Seo') !!}
		{!! Form::text('nombre_seo', $producto->nombre_seo, ['class' => 'form-control', 'required', 'id' => 'nombre_seo'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción') !!}
		{!! Form::text('descripcion', $producto->descripcion, ['class' => 'form-control', 'required', 'id' => 'descripcion'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'País') !!}
		{!! Form::select('pais_id', $paises, $producto->pais_id, ['class' => 'form-control', 'onchange' => 'cargarProvincias();', 'id' => 'pais_id']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('provincia_region_id','Provincia / Región') !!}
		{!! Form::select('provincia_region_id', $provincias, $producto->provincia_region_id, ['class' => 'form-control', 'id' => 'provincias']) !!}
	</div>
	<div class="form-group">
		{!! Form::label('clase_bebida', 'Clase de Bebida') !!}
		{!! Form::select('clase_bebida_id', $clases_bebidas, $producto->clase_bebida_id, ['class' => 'form-control']) !!}
	</div>
			
	<div class="form-group">
		{!! Form::label('ano_produccion', 'Año de Producción') !!}
		{!! Form::text('ano_produccion', $producto->ano_produccion, ['class' => 'form-control', 'required', 'id' => 'ano_produccion'] ) !!}
	</div>