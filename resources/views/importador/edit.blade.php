@extends('plantillas.importador.mainImportador')
@section('title', 'Modificar Importador '.$importador->nombre)
@section('content-left')

	{!! Html::script('js/importadores/edit.js') !!}
	
	@if (Session::has('msj'))
		<div class="alert alert-success alert-dismissable">
	  		<button type="button" class="close" data-dismiss="alert">&times;</button>
	  		<strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
		</div>
	@endif

	@section('title-header')
		<span><h3>Editar Perfil</h3></span>
	@endsection

	@include('importador.modales.modalAvatar')

	@include('importador.formularios.editForm')
	
@endsection