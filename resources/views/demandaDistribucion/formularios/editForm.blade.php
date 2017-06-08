	{!! Html::script('js/demandaDistribuidores/edit.js') !!}
	
	{!! Form::hidden('status_hidden', $demandaDistribuidor->status, ['id' => 'status_hidden']) !!}

	<div class="form-group">
		{!! Form::label('marca_id', 'Seleccione la Marca que desea distribuir') !!}
		{!! Form::select('marca_id', $marcas, $demandaDistribuidor->marca_id, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('provincia_region_id', 'Seleccione la provincia') !!}
		{!! Form::select('provincia_region_id', $provincias, $demandaDistribuidor->provincia_region_id, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('producto_id', 'Seleccione el status') !!}
		<select name="status" id="status" class="form-control">
			<option value="1">Activa</option>
			<option value="0">Inactiva</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
	</div>
