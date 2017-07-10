{!! Form::open(['route' => ['credito.update', $credito->id], 'method' => 'PUT']) !!}
	<div class="form-group">
		{!! Form::label('plan', 'Nombre del Plan de Crédito') !!}
		{!! Form::text('plan', $credito->plan, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_creditos', 'Cantidad de Créditos') !!}
		{!! Form::text('cantidad_creditos', $credito->cantidad_creditos, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio', 'Precio') !!}
		{!! Form::text('precio', $credito->precio, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción') !!}
		{!! Form::textarea('descripcion', $credito->descripcion, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
	</div>
		
{!! Form::close() !!}