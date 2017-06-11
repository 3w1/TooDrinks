@extends('plantillas.horeca.mainHoreca')
@section('title', 'Modificar Usuario'.$horeca->nombre)
@section('content-left')

	{!! Html::script('js/horecas/edit.js') !!}

	@if (Session::has('msj'))
	<div class="alert alert-success alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
	</div>
	@endif

	@section('title-header')
		<span><h3>Editar Perfil</h3></span>
	@endsection

	@include('horeca.modales.modalAvatar')

	@include('horeca.formularios.editForm')
	
@endsection