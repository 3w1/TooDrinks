{!! Html::script('js/marcas/create.js') !!}

{!! Form::open(['route'=>'marca.store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
	
	{!! Form::hidden ('tipo_creador', session('perfilTipo')) !!}
	{!! Form::hidden('creador_id', session('perfilId')) !!}
	@if (session('perfilTipo') == 'P')
		{!! Form::hidden('productor_id', session('perfilId')) !!}
		{!! Form::hidden('reclamada', '1') !!}
		{!! Form::hidden('publicada', '1') !!}
	@else
		{!! Form::hidden('productor_id', '0') !!}
		{!! Form::hidden('reclamada', '0') !!}
		{!! Form::hidden('publicada', '0') !!}
	@endif
	
	<!-- Para efectos de la Consulta Ajax de Verificar Nombre-->
	{!! Form::hidden('id_marca', '0', ['id' => 'id_marca']) !!}

	<div class="form-group">
	    {!! Form::label ('nombre','Nombre (*)') !!}
	    {!! Form::text ('nombre',null,['class'=>'form-control', 'required', 'id' => 'nombre', 'onblur' => 'verificarNombre();']) !!}
	    <div class="alert alert-danger" style="display: none;" id="errorNombre">
			<strong>Ups!!</strong> Ya existe una marca con este nombre.
		</div>
    </div>

    <div class="form-group">
    	{!! Form::label ('nombre_seo','Nombre SEO (*)') !!}
	    {!! Form::text ('nombre_seo',null,['class'=>'form-control', 'required']) !!}
    </div>

	<div class="form-group">
		{!! Form::label ('descripcion', 'Descripción') !!}
		{!! Form::textarea('descripcion',null,['class'=>'form-control', 'rows' => '5']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('pais_id','País de Origen (*)') !!}
		{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'id' => 'pais_id', 'placeholder' => 'Seleccione un país..', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('website', 'Website') !!}
		{!! Form::url('website', null, ['class'=>'form-control', 'placeholder' => '(http://www.dominio.com)' ]) !!}
	</div>
			
	<div class="form-group">
		{!! Form::label ('logo', 'Logo / Imagen (*)') !!}
		{!! Form::file ('logo', ['class'=>'form-control', 'required']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::submit ('Registrar Marca',['class'=>'btn btn-primary pull-right', 'id' => 'boton']) !!}
	</div>
	
{!! Form::close() !!}