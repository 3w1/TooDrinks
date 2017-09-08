{!! Form::open(['route' => 'demanda-importador.store', 'method' => 'POST']) !!}

	{!! Form::hidden('productor_id', session('perfilId')) !!}
	{!! Form::hidden('cantidad_visitas', '0') !!}
	{!! Form::hidden('cantidad_contactos', '0') !!}
	{!! Form::hidden('status', '1') !!}

	<div class="form-group">
		{!! Form::label('marca', 'Marca que desea exportar') !!}
		{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una marca..', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'País al cual desea exportar') !!}
		{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'required']) !!}
	</div>
		
	<div class="form-group">
		@if ( (session('perfilSuscripcion') == 'Gratis') || (session('perfilSuscripcion') == 'Bronce') )
	    	@if (session('perfilSaldo') >= $coste->cantidad_creditos)
				{!! Form::submit('Crear Solicitud', ['class' => 'btn btn-primary pull-right']) !!}
			@else
				{!! Form::submit('Crear Solicitud', ['class' => 'btn btn-primary pull-right', 'disabled']) !!}
			@endif
		@else
			{!! Form::submit('Crear Solicitud', ['class' => 'btn btn-primary pull-right']) !!}
		@endif
	</div>
{!! Form::close() !!}

