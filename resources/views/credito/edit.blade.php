@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Modificar Plan '. $credito->plan)

@section('title-header')
  Modificar Plan de Crédito
@endsection

@section('content-left')

	{!! Html::script('js/creditos/edit.js') !!}
	@include('plantillas.alertas.AlertasRequest')	
	@include('credito.formularios.editForm')
	
@endsection