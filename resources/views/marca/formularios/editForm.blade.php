<?php 
	$paises= DB::table('pais')
				->orderBy('pais')
				->pluck('pais', 'id');
?>

{!! Html::script('js/marcas/edit.js') !!}

{!! Form::open(['route' => ['marca.update', $marca->id], 'method' => 'PUT', 'name' => 'editForm']) !!}
	
	{!! Form::hidden('id_marca', $marca->id, ['id' => 'id_marca']) !!}
	
	<div class="form-group">
		{!! Form::label ('nombre','Nombre (*)') !!}
		{!! Form::text ('nombre', $marca->nombre,['class' => 'form-control', 'required', 'id' => 'nombre']) !!}
		<div class="alert alert-danger" style="display: none;" id="errorNombre">
			<strong>Ups!!</strong> Ya existe una marca con este nombre.
		</div>
	</div>

	<div class="form-group">
		{!! Form::label ('nombre_seo','Nombre Seo (*)') !!}
		{!! Form::text ('nombre_seo',$marca->nombre_seo,['class'=>'form-control', 'required']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label ('descripcion','Descripción') !!}
		{!! Form::text ('descripcion',$marca->descripcion,['class'=>'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('pais_id','País (*)') !!}
		{!! Form::select('pais_id', $paises, $marca->pais_id, ['class' => 'form-control', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('website', 'Website') !!}
		{!! Form::url('website', $marca->website, ['class'=>'form-control', 'placeholder' => '(http://www.dominio.com)' ]) !!}
	</div>

