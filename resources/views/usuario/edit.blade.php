@extends('plantillas.usuario.mainUsuario')
@section('title', 'Modificar Usuario'.$usuario->nombre)
@section('content-left')

	{!! Html::script('js/usuarios/edit.js') !!}

	@include('usuario.modales.modalAvatar')
	
	@if (Session::has('status'))
		<div class="alert alert-success alert-dismissable">
	  		<button type="button" class="close" data-dismiss="alert">&times;</button>
	  		<strong>¡Enhorabuena!</strong> {{Session::get('status')}}.
		</div>
	@endif

	@include('usuario.formularios.editForm')

@endsection