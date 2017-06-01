{!! Form::open(['route' => 'credito.show', 'method' => 'Get']) !!}
		<div class="form-group">
			{!! Form::label('plan', 'Nombre del Plan de Crédito') !!}
			{!! Form::text('plan', null, ['class' => 'form-control', 'placeholder' => 'Nombre del Plan de Crédito'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('cantidad_creditos', 'Cantidad de Créditos') !!}
			{!! Form::number('cantidad_creditos', null, ['class' => 'form-control', 'placeholder' => 'Cantidad de Créditos'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('precio', 'Precio') !!}
			{!! Form::text('precio', null, ['class' => 'form-control', 'placeholder' => 'Precio'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('descripcion', 'Descripción') !!}
			{!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción del Plan'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
		</div>
		
		
	{!! Form::close() !!}

	