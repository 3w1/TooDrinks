{!! Html::script('js/ofertas/edit.js') !!}

{!! Form::open(['route' => ['oferta.update', $oferta->id], 'method' => 'PUT']) !!}

	{!! Form::hidden('producto_id', $oferta->producto_id) !!}

	<div class="form-group">
		{!! Form::label('titulo', 'Título (*)') !!}
		{!! Form::text('titulo', $oferta->titulo, ['class' => 'form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion (*)') !!}
		{!! Form::textarea('descripcion', $oferta->descripcion, ['class' => 'form-control', 'required', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_unitario', 'Precio por Unidad (*)') !!}
		{!! Form::text('precio_unitario', $oferta->precio_unitario, ['class' => 'form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_lote', 'Precio por Lote (*)') !!}
		{!! Form::text('precio_lote', $oferta->precio_lote, ['class' => 'form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_producto', 'Cantidad de Productos') !!}
		{!! Form::number('cantidad_producto', $oferta->cantidad_producto, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_caja', 'Cantidad de Cajas') !!}
		{!! Form::number('cantidad_caja', $oferta->cantidad_caja, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Cantidad Mínima de Venta') !!}
		{!! Form::number('cantidad_minima', $oferta->cantidad_minima, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('env', 'Envío Disponible (*)') !!}
		{!! Form::select('envio', ['0' => 'No', '1' => 'Si'], $oferta->envio, ['class' => 'form-control', 'required', 'id' => 'envio', 'onchange' => 'activarCosto();']); !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('costo_envio', 'Costo del Envío') !!}
		@if ($oferta->envio == '0')
			{!! Form::text('costo_envio', $oferta->costo_envio, ['class' => 'form-control', 'id' => 'costo', 'disabled'] ) !!}
		@else
			{!! Form::text('costo_envio', $oferta->costo_envio, ['class' => 'form-control', 'id' => 'costo'] ) !!}
		@endif
	</div>
	
	@if (session('perfilTipo') == 'P')
		<div class="form-group">
            {!! Form::label('visible_importador', 'Disponible para Importadores (*)') !!}
            {!! Form::select('visible_importadores', ['0' => 'No', '1' => 'Si'], $oferta->visible_importadores, ['class' => 'form-control']) !!}
        </div>
    @endif

    @if (session('perfilTipo') != 'D')
        <div class="form-group">
            {!! Form::label('visible_distribuidor', 'Disponible para Distribuidores (*)') !!}
            {!! Form::select('visible_distribuidores', ['0' => 'No', '1' => 'Si'], $oferta->visible_distribuidores, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
	        {!! Form::label('visible_horeca', 'Visible para Horecas (*)') !!}
	        {!! Form::select('visible_horecas', ['0' => 'No', '1' => 'Si'], $oferta->visible_horecas, ['class' => 'form-control']); !!}
	    </div>       
	@endif
    
    