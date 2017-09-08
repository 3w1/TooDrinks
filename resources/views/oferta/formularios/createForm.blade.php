{!! Html::script('js/ofertas/create.js') !!}

{!! Form::open(['route' => 'oferta.store', 'method' => 'POST']) !!}
	{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
	{!! Form::hidden('creador_id', session('perfilId')) !!}
	{!! Form::hidden('cantidad_visitas', '0') !!}
	{!! Form::hidden('cantidad_contactos', '0') !!}
	{!! Form::hidden('status', '1') !!}

	@if ($tipo == '1')
		{!! Form::hidden('producto_id', $id) !!}
	@else 
		<div class="form-group">
			{!! Form::label('marca', 'Marca (*)') !!}
			{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'id' => 'marca', 'placeholder' => 'Seleccione una marca..', 'onchange' => 'cargarProductos();', 'required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('producto_id', 'Producto (*)') !!}
			<select class="form-control" id="productos" name="producto_id" disabled required>
				<option value="">Seleccione un producto..</option>
			</select>
			<div class="alert alert-warning" style="display: none;" id="errorProductos">
				<strong>Actualmente no posee productos asociados de la marca seleccionada</strong>
			</div>
		</div>
	@endif

	<div class="form-group">
		{!! Form::label('titulo', 'Título (*)') !!}
		{!! Form::text('titulo', null, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción (*)') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'required', 'rows'=>'5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_unitario', 'Precio por Unidad (*)') !!}
		{!! Form::text('precio_unitario', null, ['class' => 'form-control', 'placeholder' => '00.000', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_lote', 'Precio por Lote (*)') !!}
		{!! Form::text('precio_lote', null, ['class' => 'form-control', 'placeholder' => '00.000', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_producto', 'Cantidad de Productos') !!}
		{!! Form::number('cantidad_producto', null, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_caja', 'Cantidad de Cajas)') !!}
		{!! Form::number('cantidad_caja', null, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Cantidad Mínima de Venta') !!}
		{!! Form::number('cantidad_minima', null, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('env', 'Envío Disponible (*)') !!}
		{!! Form::select('envio', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control', 'id' => 'envio', 'placeholder' => 'Seleccione una opción..', 'onchange' => 'activarCosto();']); !!}
	</div>

	<div class="form-group">
		{!! Form::label('costo_envio', 'Costo del Envío') !!}
		{!! Form::text('costo_envio', null, ['class' => 'form-control', 'id' => 'costo', 'disabled'] ) !!}
	</div>
	
	@if (session('perfilTipo') == 'P')
		<div class="form-group">
			{!! Form::label('pais', 'País Destino (*)') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'id' => 'pais_id', 'required']) !!}
			<div class="alert alert-info">Se muestran los países que eligió como posibles destinos laborales. Para agregar o quitar países, diríjase a su perfil.</div>
		</div>
	@else
		<div class="form-group">
			{!! Form::label('pais', 'País Destino (*)') !!}
			{!! Form::text('pais', $paises->pais, ['class' => 'form-control', 'disabled']) !!}
			{!! Form::hidden('pais_id', $paises->id, ['id' => 'pais_id'])!!}
		</div>
	@endif

	<div class="form-group">
		{!! Form::label('pais', 'Provincias Destino (*)') !!}
		{!! Form::select('opciones', ['T' => 'Todas las Provincias', 'P' => 'Personalizado'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...', 'id' => 'opciones', 'onchange' => 'cargarProvincias();', 'required'] ) !!}
	</div>

	<div class="form-group" id="estados"></div>

	<div class="row">
		<br>
	</div>
	
	@if (session('perfilTipo') == 'P')
		<div class="form-group">
            {!! Form::label('visible_importador', 'Disponible para Importadores') !!}
            {!! Form::select('visible_importadores', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
        </div>
	@else
		{!! Form::hidden('visible_importadores', '0') !!}
	@endif

	@if( session('perfilTipo') != 'D')
		<div class="form-group">
            {!! Form::label('visible_distribuidor', 'Disponible para Distribuidores') !!}
            {!! Form::select('visible_distribuidores', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
        </div>

          <div class="form-group">
	        {!! Form::label('visible_horeca', 'Visible para Horecas') !!}
	        {!! Form::select('visible_horecas', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']); !!}
	    </div>  
    @else
    	{!! Form::hidden('visible_distribuidores', '0') !!}
    	{!! Form::hidden('visible_horecas', '1') !!}
    @endif

    <div class="form-group">
    	@if ( session('perfilSuscripcion') != 'Oro' )
	    	@if (session('perfilSaldo') >= $coste->cantidad_creditos)
				{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary pull-right']) !!}
			@else
				{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary pull-right', 'disabled']) !!}
			@endif
		@else
			{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary pull-right']) !!}
		@endif
	</div>
		
{!! Form::close() !!}
	