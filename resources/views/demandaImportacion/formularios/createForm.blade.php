	<div class="form-group">
		{!! Form::label('marca_id', 'Seleccione la marca que desea importar') !!}
		<select name="marca_id" class="form-control">
			@foreach ($marcas as $marca) 
				<option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('pais_id', 'Seleccione el país al cual desea importar') !!}
		<select name="pais_id" class="form-control">
			@foreach ($paises as $pais )
				@if ($pais->id != $pais_origen->pais_id)
					<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
				@endif
			@endforeach
		</select>
	</div>
	
	{!! Form::hidden('status', '1') !!}
	
	<div class="form-group">
		{!! Form::submit('Crear Solicitud', ['class' => 'btn btn-primary']) !!}
	</div>
	