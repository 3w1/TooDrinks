@extends('plantillas.distribuidor.mainDistribuidor')
@section('title', 'Modificar Producto '.$distribuidor->nombre)
@section('content-left')

	{!! Html::script('js/distribuidores/edit.js') !!}

	@if (Session::has('msj'))
	<div class="alert alert-success alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
	</div>
	@endif

	@section('title-header')
		<span><h3>Editar Perfil</h3></span>
	@endsection

	@include('distribuidor.modales.modalAvatar')

	@include('distribuidor.formularios.editForm')
	
@endsection