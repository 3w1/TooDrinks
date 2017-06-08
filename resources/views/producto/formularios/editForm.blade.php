	{!! Html::script('js/productos/edit.js') !!}

	<?php 
		$paises = DB::table('pais')
					->select('id', 'pais')
					->orderBy('pais', 'ASC')
					->get();

		$provincias = DB::table('provincia_region')
						->select('id', 'provincia')
						->orderBy('provincia')
						->where('pais_id', '=', $producto->pais_id)
						->get();

		$clases_bebidas = DB::table('clase_bebida')
							->select('id', 'clase', 'bebida_id')
							->orderBy('clase')
							->get();
	 ?>

	{!! Form::hidden('pais_hidden', $producto->pais->id, ['id' => 'pais_hidden']) !!}
	{!! Form::hidden('provincia_hidden', $producto->provincia_region->id, ['id' => 'provincia_hidden']) !!}
	{!! Form::hidden('marca_id', $producto->marca_id, ['id' => 'marca_hidden']) !!}
	{!! Form::hidden('clase_bebida_hidden', $producto->clase_bebida_id, ['id' => 'clase_bebida_hidden']) !!}

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
		<select name="pais_id" id="pais_id" class="form-control" onchange="cargarProvincias();">
			@foreach ($paises as $pais)
				<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('provincia', 'Provincia') !!}
		<select name="provincia_region_id" id="provincia_id" class="form-control">
			@foreach ($provincias as $provincia) 
				<option value="{{ $provincia->id }}"> {{ $provincia->provincia }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('clase_bebida', 'Clase de Bebida') !!}
		<select name="clase_bebida_id" id="clase_bebida_id" class="form-control">
			@foreach ($clases_bebidas as $clase_bebida) 
				<option value="{{ $clase_bebida->id }}"> {{ $clase_bebida->clase }}</option>
			@endforeach
		</select>
	</div>
			
	<div class="form-group">
		{!! Form::label('ano_produccion', 'Año de Producción') !!}
		{!! Form::text('ano_produccion', $producto->ano_produccion, ['class' => 'form-control', 'required', 'id' => 'ano_produccion'] ) !!}
	</div>