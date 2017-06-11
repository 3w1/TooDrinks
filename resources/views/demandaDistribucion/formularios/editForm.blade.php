
	<div class="form-group">
		{!! Form::label('marca_id', 'Seleccione la Marca que desea distribuir') !!}
		{!! Form::select('marca_id', $marcas, $demandaDistribuidor->marca_id, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('provincia_region_id', 'Seleccione la provincia') !!}
		{!! Form::select('provincia_region_id', $provincias, $demandaDistribuidor->provincia_region_id, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('producto_id', 'Status') !!}
		{!! Form::select('status', ['0' => 'Inactiva', '1' => 'Activa'], $demandaDistribuidor->status, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
	</div>
