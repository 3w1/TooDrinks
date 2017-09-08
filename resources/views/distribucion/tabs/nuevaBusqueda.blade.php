@extends('plantillas.main')
@section('title', 'Exportación')

@section('title-header')
   Demandas de Distribuidor
@endsection

@section('title-complement')
   (Nueva)
@endsection

@section('content-left')
   <?php 
      $coste = DB::table('coste_credito')
            ->select('cantidad_creditos')
            ->where('accion', '=', 'DD')
            ->where('entidad', '=', session('perfilTipo'))
            ->first();
   ?>
   
   @section('alertas')
      @if ( (session('perfilSuscripcion') == 'Gratis') || (session('perfilSuscripcion') == 'Bronce') )
         @if (session('perfilSaldo') >= $coste->cantidad_creditos)
            <div class="alert alert-danger">
               Se le descontarán <strong>{{$coste->cantidad_creditos}} créditos</strong> de su saldo para crear la solicitud. Para publicar una solicitud sin pagar créditos debe tener Suscripción Plata u Oro.
            </div>
         @else
            <div class="alert alert-danger">
              No tiene créditos suficientes para realizar esta acción. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Plata u Oro. <a href="#">Ver Suscripciones</a>  
            </div>
         @endif
      @endif
   @endsection
   
   <ul class="nav nav-pills">
   	<li class="btn btn-default"><a href="{{ route('demanda-distribuidor.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a></li>
      <li class="active btn btn-default"><a href="{{ route('demanda-distribuidor.create') }}"><strong>NUEVA BÚSQUEDA</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('demanda-distribuidor.historial') }}"><strong>HISTORIAL DE BÚSQUEDAS</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
   	<div class="panel-heading"></div>
      <div class="panel-body">
      	<div class="tab-content">
            <div class="tab-pane fade in active">
               @include('demandaDistribucion.formularios.createForm')		
            </div>
         </div>
      </div>
   </div>
@endsection



