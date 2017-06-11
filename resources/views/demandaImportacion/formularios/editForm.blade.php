	<div class="form-group">
		{!! Form::label('producto_id', 'Marca') !!}
		{!! Form::select('marca_id', $marcas, $demandaImportador->marca_id, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais_id', 'País') !!}
		{!! Form::select('pais_id', $paises, $demandaImportador->pais_id, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('statu', 'Status') !!}
		{!! Form::select('status', ['0' => 'Inactiva', '1' => 'Activa'], $demandaImportador->status, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
	</div>