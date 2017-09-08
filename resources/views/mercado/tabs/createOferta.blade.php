@extends('plantillas.main')
@section('title', 'Nueva Oferta')

@section('title-header')
   Nueva Oferta
@endsection

@section('content-left')
   <?php 
      $coste = DB::table('coste_credito')
            ->select('cantidad_creditos')
            ->where('accion', '=', 'CO')
            ->where('entidad', '=', session('perfilTipo'))
            ->first();
   ?>
   
   @section('alertas')
      @if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
         </div>
      @endif

      @if ( session('perfilSuscripcion') != 'Oro' )
         @if (session('perfilSaldo') >= $coste->cantidad_creditos)
            <div class="alert alert-danger">
               Se le descontarán <strong>{{$coste->cantidad_creditos}} créditos</strong> de su saldo para crear la oferta. Para publicar una oferta sin pagar créditos debe tener Suscripción Oro.
            </div>
         @else
            <div class="alert alert-danger">
               No tiene créditos suficientes para realizar esta acción. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Oro. <a href="#">Ver Suscripciones</a> 
            </div>
         @endif
      @endif
   @endsection 
   
   <ul class="nav nav-pills">
      <li class="btn btn-default"><a href="{{ route('oferta.index') }}"><strong>MIS OFERTAS ACTIVAS</strong></a></li>
      <li class="active btn btn-default"><a href="{{ route('oferta.create') }}"><strong>NUEVA OFERTA</strong></a></li>
      @if (session('perfilTipo') != 'P')
         <li class="btn btn-default"><a href="{{ route('oferta.disponibles') }}"><strong>OFERTAS DISPONIBLES</strong></a></li>
      @endif
      <li class="btn btn-default"><a href="{{ route('oferta.historial')}}"><strong>HISTORIAL DE OFERTAS</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
               @include('oferta.formularios.createForm')
            </div>
         </div>
      </div>
   </div>
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
 
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   
@endsection

