{!! Html::script('js/ofertas/create.js') !!}
	
{!! Form::open(['route' => 'oferta.store', 'method' => 'POST']) !!}
	{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
	{!! Form::hidden('creador_id', session('perfilId')) !!}
	{!! Form::hidden('cantidad_visitas', '0') !!}
	{!! Form::hidden('cantidad_contactos', '0') !!}
	
	@if (session('perfilTipo') == 'M')
		{!! Form::hidden('pais_id', session('perfilPais')) !!}
	@endif

	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

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
		</div>
	@endif

	<div class="form-group">
		{!! Form::label('titulo', 'Título (*)') !!}
		{!! Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un título para la oferta'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción (*)') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese una descripción para la oferta', 'required', 'rows'=>'5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_unitario', 'Precio por Unidad (*)') !!}
		{!! Form::text('precio_unitario', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el precio por unidad', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_lote', 'Precio por Lote (*)') !!}
		{!! Form::text('precio_lote', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el precio por lote', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_producto', 'Cantidad de Productos (*)') !!}
		{!! Form::number('cantidad_producto', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la cantidad de productos', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_caja', 'Cantidad de Cajas (*)') !!}
		{!! Form::number('cantidad_caja', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la cantidad de cajas', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Cantidad Mínima de Venta (*)') !!}
		{!! Form::number('cantidad_minima', null, ['class' => 'form-control', 'placeholder' => 'Ingrese la cantidad mínima de venta', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('env', 'Envío Disponible (*)') !!}
		{!! Form::select('envio', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control', 'id' => 'envio', 'placeholder' => 'Seleccione una opción..', 'onchange' => 'activarCosto();']); !!}
	</div>

	<div class="form-group">
		{!! Form::label('costo_envio', 'Costo del Envío') !!}
		{!! Form::text('costo_envio', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el costo del envío', 'id' => 'costo', 'disabled'] ) !!}
	</div>
	
	@if (session('perfilTipo') != 'M')
		<div class="form-group">
			{!! Form::label('pais', 'País Destino (*)') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id', 'required']) !!}
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
	
	@if( (session('perfilTipo') == 'P') || (session('perfilTipo') == 'M') )
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
	