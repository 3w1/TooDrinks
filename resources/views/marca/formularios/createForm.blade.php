	{!! Html::script('js/marcas/create.js') !!}

	<div class="form-group">
		{!! Form::label ('nombre','Nombre') !!}
		{!! Form::text ('nombre',null,['class'=>'form-control','placeholder'=>'Ej. Polar', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('nombre_seo','Nombre Seo') !!}
		{!! Form::text ('nombre_seo',null,['class'=>'form-control','placeholder'=>'Ej. Polar Seo', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('descripcion','Descripcion') !!}
		{!! Form::text ('descripcion',null,['class'=>'form-control','placeholder'=>'Ej. ', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('pais_id','País') !!}
		<select name="pais_id" class="form-control" id="pais_id" onchange="cargarProvincias();">
			<option value="">Seleccione un país..</option>
			@foreach($paises as $pais)
				<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		{!! Form::label ('provincia_region_id','Provincia / Región') !!}
		<select name="provincia_region_id" class="form-control" id="provincias">
			<option value="">Seleccione una provincia..</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label ('logo', 'Logo') !!}
		{!! Form::file ('logo', ['class'=>'form-control','required']) !!}
	</div>

	{!! Form::submit ('Agregar',['class'=>'btn btn-primary']) !!}
