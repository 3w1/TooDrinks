		<div class="form-group">
			{!! Form::label('nombre', 'Nombre') !!}
			{!! Form::text('nombre', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nombre del Producto'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('nombre_seo', 'Nombre Seo') !!}
			{!! Form::text('nombre_seo', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nombre SEO del Producto'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('descripcion', 'Descripción') !!}
			{!! Form::text('descripcion', null, ['class' => 'form-control', 'required', 'placeholder' => 'Descripción del Producto'] ) !!}
		</div>
		
		<div class="form-group">
			<select name="pais_id" class="form-control">
				@foreach ($paises as $pais )
					<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<select name="provincia_region_id" class="form-control">
				@foreach ($provincias as $provincia )
					<option value="{{ $provincia->id }}">{{ $provincia->provincia }}</option>
				@endforeach
			</select>
		</div>


		<div class="form-group">
			<select name="clase_bebida_id" class="form-control">
				@foreach ($bebidas as $bebida )
					<option value="{{ $bebida->id }}">{{ $bebida->clase }}</option>
				@endforeach
			</select>
		</div>
		
		<div class="form-group">
			{!! Form::label('ano_produccion', 'Imagen') !!}
			{!! Form::text('ano_produccion', null, ['class' => 'form-control', 'required', 'placeholder' => 'Año de Producción'] ) !!}
		</div>
		
		<div class="form-group">
			{!! Form::label('imagen', 'Imagen') !!}
			{!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
		</div>
		
	{!! Form::close() !!}