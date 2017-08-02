<?php 
	$paises= DB::table('pais')
				->orderBy('pais')
				->pluck('pais', 'id');
?>

{!! Form::open(['route' => ['marca.update', $marca->id], 'method' => 'PUT']) !!}

	<div class="form-group">
		{!! Form::label ('nombre','Nombre') !!}
		{!! Form::text ('nombre', $marca->nombre,['class' => 'form-control', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('nombre_seo','Nombre Seo') !!}
		{!! Form::text ('nombre_seo',$marca->nombre_seo,['class'=>'form-control', 'required']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label ('descripcion','Descripcion') !!}
		{!! Form::text ('descripcion',$marca->descripcion,['class'=>'form-control', 'required']) !!}
	</div>

	<div class="form-group">
		{!! Form::label ('pais_id','País') !!}
		{!! Form::select('pais_id', $paises, $marca->pais_id, ['class' => 'form-control', 'required']) !!}
	</div>

