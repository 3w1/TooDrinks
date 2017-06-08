	<div class="form-group">
		{!! Form::label('marca_id', 'Seleccione la marca que desea distribuir') !!}
		<select name="marca_id" class="form-control">
			@foreach ($marcas as $marca) 
				<option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('provincia_region_id', 'Seleccione la provincia a la cual desea distribuir') !!}
		<select name="provincia_region_id" class="form-control">
			@foreach ($provincias as $provincia )
				<option value="{{ $provincia->id }}">{{ $provincia->provincia }}</option>
			@endforeach
		</select>
	</div>
	
	{!! Form::hidden('status', '1')  !!}

	<div class="form-group">
		{!! Form::submit('Crear Solicitud', ['class' => 'btn btn-primary']) !!}
	</div>
