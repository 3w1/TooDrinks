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
			{!! Form::label('marca', 'Marca') !!}
			{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'id' => 'marca', 'placeholder' => 'Seleccione una marca..', 'onchange' => 'cargarProductos();']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('producto_id', 'Producto') !!}
			<select class="form-control" id="productos" name="producto_id">
				<option value="">Seleccione un producto..</option>
			</select>
		</div>
	@endif

	<div class="form-group">
		{!! Form::label('titulo', 'Título') !!}
		{!! Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'Título'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripcion'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_unitario', 'Precio por Unidad') !!}
		{!! Form::text('precio_unitario', null, ['class' => 'form-control', 'placeholder' => 'Precio por Unidad'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_lote', 'Precio por el Lote') !!}
		{!! Form::text('precio_lote', null, ['class' => 'form-control', 'placeholder' => 'Precio por el Lote'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_producto', 'Cantidad de Productos') !!}
		{!! Form::number('cantidad_producto', null, ['class' => 'form-control', 'placeholder' => 'Cantidad de Productos'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_caja', 'Cantidad de Cajas') !!}
		{!! Form::number('cantidad_caja', null, ['class' => 'form-control', 'placeholder' => 'Cantidad de Cajas'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Cantidad Mínima de Venta') !!}
		{!! Form::number('cantidad_minima', null, ['class' => 'form-control', 'placeholder' => 'Cantidad Mínima de Venta'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('env', 'Envío Disponible') !!}
		{!! Form::select('envio', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción']); !!}
	</div>

	<div class="form-group">
		{!! Form::label('costo_envio', 'Costo del Envío') !!}
		{!! Form::text('costo_envio', null, ['class' => 'form-control', 'placeholder' => 'Costo del Envío'] ) !!}
	</div>
	
	@if (session('perfilTipo') != 'M')
		<div class="form-group">
			{!! Form::label('pais', 'Seleccione el país que será destino de la oferta') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id']) !!}
		</div>
	@endif

	<div class="form-group">
		{!! Form::label('pais', 'Seleccione las provincias que serán destino de la oferta') !!}
		{!! Form::select('opciones', ['T' => 'Todas las Provincias', 'P' => 'Personalizado'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...', 'id' => 'opciones', 'onchange' => 'cargarProvincias();'] ) !!}
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
    	@if ( (session('perfilSuscripcion') == 'Gratis') || (session('perfilSuscripcion') == 'Basic') )
	    	@if (session('perfilSaldo') >= '25')
				{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary']) !!}
			@else
				{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary', 'disabled']) !!}
			@endif
		@else
			{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary']) !!}
		@endif
	</div>
		
{!! Form::close() !!}
	