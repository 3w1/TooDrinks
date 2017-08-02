{!! Html::script('js/marcas/create.js') !!}

{!! Form::open(['route'=>'marca.store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
	
	{!! Form::hidden ('tipo_creador', session('perfilTipo')) !!}
	{!! Form::hidden('creador_id', session('perfilId')) !!}
	
	@if (session('perfilTipo') == 'P')
		{!! Form::hidden('productor_id', session('perfilId')) !!}
		{!! Form::hidden('reclamada', '1') !!}
	@else
		{!! Form::hidden('productor_id', '0') !!}
		{!! Form::hidden('reclamada', '0') !!}
	@endif

	@if (session('perfilTipo') == 'AD')
		{!! Form::hidden('publicada', '1') !!}
	@else
		{!! Form::hidden('publicada', '0') !!}
	@endif
	
	<div class="form-group">
	    {!! Form::label ('nombre','Nombre (*)') !!}
	    {!! Form::text ('nombre',null,['class'=>'form-control','placeholder'=>'Ingrese un nombre para la marca', 'required']) !!}
    </div>

    <div class="form-group">
    	{!! Form::label ('nombre_seo','Nombre SEO (*)') !!}
	    {!! Form::text ('nombre_seo',null,['class'=>'form-control','placeholder'=>'Ingrese un nombre seo para la marca']) !!}
    </div>

	<div class="form-group">
		{!! Form::label ('descripcion','Descripción (*)') !!}
		{!! Form::textarea('descripcion',null,['class'=>'form-control','placeholder'=>'Ingrese una breve descripción para la marca', 'rows' => '5', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('pais_id','País de Origen (*)') !!}
		{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'id' => 'pais_id', 'placeholder' => 'Seleccione un país..', 'required']) !!}
	</div>
			
	<div class="form-group">
		{!! Form::label ('logo', 'Logo / Imagen (*)') !!}
		{!! Form::file ('logo', ['class'=>'form-control', 'required']) !!}
	</div>
	
	<div class="fom-group">
		{!! Form::submit ('Registrar Marca',['class'=>'btn btn-primary pull-right']) !!}
	</div>
	
{!! Form::close() !!}