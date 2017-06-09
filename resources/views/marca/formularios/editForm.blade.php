	<?php 
		$paises= DB::table('pais')
					->orderBy('pais')
					->pluck('pais', 'id');

		$provincias = DB::table('provincia_region')
						->orderBy('provincia')
						->where('pais_id', '=', $marca->pais_id)
						->pluck('provincia', 'id');
	 ?>

	{!! Html::script('js/marcas/edit.js') !!}

	{!! Form::hidden('id', $marca->id) !!}
	{!! Form::hidden('reclamada_hidden', $marca->reclamada) !!}
	{!! Form::hidden('productor_id', $marca->productor_id) !!}
	{!! Form::hidden('creador_id', $marca->creador_id) !!}
	{!! Form::hidden('tipo_creador', $marca->tipo_creador) !!}

	<div class="form-group">
		{!! Form::label ('nombre','Nombre') !!}
		{!! Form::text ('nombre', $marca->nombre,['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('nombre_seo','Nombre Seo') !!}
		{!! Form::text ('nombre_seo',$marca->nombre_seo,['class'=>'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label ('descripcion','Descripcion') !!}
		{!! Form::text ('descripcion',$marca->descripcion,['class'=>'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('pais_id','País') !!}
		{!! Form::select('pais_id', $paises, $marca->pais_id, ['class' => 'form-control', 'onchange' => 'cargarProvincias();']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('provincia_region_id','Provincia / Región') !!}
		{!! Form::select('provincia_region_id', $provincias, $marca->provincia_region_id, ['class' => 'form-control', 'id' => 'provincias']) !!}
	</div>
