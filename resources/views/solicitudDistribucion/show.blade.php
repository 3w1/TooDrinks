@extends('plantillas.main')
@section('title', 'Solicitudes')

@section('title-header')
   Solicitud de Distribución
@endsection

@section('title-complement')
   (Detalles)
@endsection

@section('content-left')
	<?php 
      $coste = DB::table('coste_credito')
            ->select('cantidad_creditos')
            ->where('accion', '=', 'VD')
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

      @if ($restringido == '1')
        @if (session('perfilSuscripcion') == 'Gratis')
            @if (session('perfilSaldo') < $coste->cantidad_creditos)
               <div class="alert alert-danger">
                  No tiene créditos suficientes para ver la información de las demandas de distribución. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Bronce, Plata u Oro. <a href="">Ver Suscripciones</a> 
               </div>
            @else
               <div class="alert alert-danger">
                  Se le descontarán <strong> {{$coste->cantidad_creditos}} créditos</strong> de su saldo. Para ver datos de contacto sin pagar créditos debe obtener una Suscripción Bronce, Plata u Oro. 
               </div>
            @endif
         @endif
      @endif
   @endsection

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
         @if ($demandaDistribucion->bebida_id != null)
            <a href="" class="thumbnail"><img src="{{ asset('imagenes/bebida.jpg') }}"></a>
         @else
            <a href="" class="thumbnail"><img src="{{ asset('imagenes/marcas/thumbnails') }}/{{ $demandaDistribucion->marca->logo }}"></a>
         @endif
      </div>
      <div class="col-md-4"></div>
   </div>

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <center>
            <b>Visitas:</b> <label class="label bg-blue label-lg">{{$demandaDistribucion->cantidad_visitas}}</label>
            <b>Contactos:</b> <small class="label bg-green">{{$demandaDistribucion->cantidad_contactos}}</small>
         </center>
      </div>
      <div class="col-md-4"></div>
   </div><br />

   <div class="row">
      <div class="col-md-1"></div>
         
      <div class="col-md-10 col-xs-12"> 
         <div class="panel panel-default panel-success">
            <div class="panel-heading"><h4><b> 
               @if ($demandaDistribucion->bebida_id != null)
                  Bebida Demandada: {{ $demandaDistribucion->bebida->nombre }}</b></h4>
               @else
                  Marca Demandada: {{ $demandaDistribucion->marca->nombre }}</b></h4>
               @endif
            </div>
             
            <ul class="list-group">
               <li class="list-group-item"><b>Provincia:</b> {{ $demandaDistribucion->provincia_region->provincia }}</li>
               <li class="list-group-item"><b>Fecha:</b> {{ date('d-m-Y', strtotime($demandaDistribucion->fecha)) }}</li>
               @if ( $restringido == '1' )
                  <li class="list-group-item"><center>
                     @if (session('perfilSuscripcion') == 'Gratis')
                        @if (session('perfilSaldo') < $coste->cantidad_creditos)
                           <a class="btn btn-danger" disabled>¡Me Interesa!</a>
                        @else
                           <a href="{{ route('credito.gastar-creditos-sd', $demandaDistribucion->id) }}" class="btn btn-success">¡Me Interesa! <b>({{$coste->cantidad_creditos}} <i class="fa fa-certificate"></i>)</b></a>
                        @endif
                     @else
                        <a href="{{ route('solicitud-distribucion.marcar', [$demandaDistribucion->id, '1'] ) }}" class="btn btn-success">¡Me Interesa! <i class="fa fa-thumbs-o-up"></i></a>
                     @endif
                     <a href="{{ route('solicitud-distribucion.marcar', [$demandaDistribucion->id, '0']) }}" class="btn btn-danger">¡No Me Interesa! <i class="fa fa-thumbs-o-down"></i></a>
                  </center></li>
               @else
                  <li class="list-group-item"><b>Distribuidor:</b> {{ $demandaDistribucion->distribuidor->nombre }}</li>
                  <li class="list-group-item"><b>Persona de Contacto:</b> {{ $demandaDistribucion->distribuidor->persona_contacto }}</li>
                  <li class="list-group-item"><b>Teléfono:</b> {{ $demandaDistribucion->distribuidor->telefono }}</li>
                  <li class="list-group-item"><b>Correo Electrónico:</b> {{ $demandaDistribucion->distribuidor->email }}</li>
               @endif
            </ul>
         </div>
      </div>
   </div>
@endsection