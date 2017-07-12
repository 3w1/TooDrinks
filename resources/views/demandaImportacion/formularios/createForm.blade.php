{!! Form::open(['route' => 'demanda-importador.store', 'method' => 'POST']) !!}

	{!! Form::hidden('productor_id', session('perfilId')) !!}
	{!! Form::hidden('cantidad_visitas', '0') !!}
	{!! Form::hidden('cantidad_contactos', '0') !!}

	<div class="form-group">
		{!! Form::label('marca', 'Marca que desea importar') !!}
		{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una marca']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'País al cual desea importar') !!}
		{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país']) !!}
		
	</div>

	{!! Form::hidden('status', '1') !!}
		
	<div class="form-group">
		{!! Form::submit('Crear Solicitud', ['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}

