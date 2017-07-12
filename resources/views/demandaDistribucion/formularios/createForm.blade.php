{!! Form::open(['route' => 'demanda-distribuidor.store', 'method' => 'POST']) !!}
	
	{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
	{!! Form::hidden('creador_id', session('perfilId')) !!}
	{!! Form::hidden('cantidad_visitas', '0') !!}
	{!! Form::hidden('cantidad_contactos', '0') !!}

	<div class="form-group">
		{!! Form::label('marca', 'Seleccione la marca que desea distribuir') !!}
		{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción..']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('provincia_region_id', 'Seleccione la provincia a la cual desea distribuir') !!}
		{!! Form::select('provincia_region_id', $provincias, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción..']) !!}
	</div>
	
	{!! Form::hidden('status', '1')  !!}

	<div class="form-group">
		{!! Form::submit('Crear Solicitud', ['class' => 'btn btn-primary']) !!}
	</div>
{!! Form::close() !!}