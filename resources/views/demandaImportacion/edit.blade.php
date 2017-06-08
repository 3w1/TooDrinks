@extends('plantillas.productor.mainProductor')
@section('title', 'Modificar Demanda ')
@section('content-left')
	
	{!! Html::script('js/demandaImportadores/edit.js') !!}
	@include('demandaImportacion.formularios.editForm')
	
@endsection