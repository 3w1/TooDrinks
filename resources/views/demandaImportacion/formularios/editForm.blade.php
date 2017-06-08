{!! Form::open(['route' => ['demanda-importador.update', $demandaImportador->id], 'method' => 'PUT']) !!}

	{!! Form::hidden('productor_id', session('productorId')) !!}
	{!! Form::hidden('status_hidden', $demandaImportador->status, ['id' => 'status_hidden']) !!}

	
	<div class="form-group">
		{!! Form::label('producto_id', 'Seleccione el producto') !!}
		{!! Form::select('marca_id', $marcas, $demandaImportador->marca_id, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais_id', 'Seleccione el país') !!}
		{!! Form::select('pais_id', $paises, $demandaImportador->pais_id, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('status', 'Seleccione el status') !!}
		<select name="status" id="status" class="form-control">
			<option value="1">Activa</option>
			<option value="0">Inactiva</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
	</div>
{!! Form::close() !!}