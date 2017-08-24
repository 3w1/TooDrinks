@extends('plantillas.main')
@section('title', 'Demanda de Distribuidor')

@section('title-header')
   Demanda de Distribuidor
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
                  No tiene créditos suficientes para ver la información de las demandas de distribuidores. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Bronce, Plata u Oro. <a href="">Ver Suscripciones</a> 
               </div>
            @else
               <div class="alert alert-danger">
                  Se le descontarán <strong> {{$coste->cantidad_creditos}} créditos</strong> de su saldo. Para ver datos de contacto sin pagar créditos debe obtener una Suscripción Bronce, Plata u Oro. 
               </div>
            @endif
         @endif
      @endif
   @endsection

   <?php 
      if ($demandaDistribuidor->tipo_creador == 'P'){
         $creador = DB::table('productor')
                  ->select('nombre', 'persona_contacto', 'telefono', 'email')
                  ->where('id', '=', $demandaDistribuidor->creador_id)
                  ->first();
      }else{
         $creador = DB::table('importador')
                  ->select('nombre', 'persona_contacto', 'telefono', 'email')
                  ->where('id', '=', $demandaDistribuidor->creador_id)
                  ->first();
      }
   ?>

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
         <a href="" class="thumbnail"><img src="{{ asset('imagenes/marcas/thumbnails') }}/{{ $demandaDistribuidor->marca->logo }}"></a>
      </div>
      <div class="col-md-4"></div>
   </div>

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <center>
            <b>Visitas:</b> <label class="label bg-blue label-lg">{{$demandaDistribuidor->cantidad_visitas}}</label>
            <b>Contactos:</b> <small class="label bg-green">{{$demandaDistribuidor->cantidad_contactos}}</small>
         </center>
      </div>
      <div class="col-md-4"></div>
   </div><br />

   <div class="row">
      <div class="col-md-1"></div>
         
      <div class="col-md-10 col-xs-12"> 
         <div class="panel panel-default panel-success">
            <div class="panel-heading"><h4><b> 
               Marca Demandada: {{ $demandaDistribuidor->marca->nombre }}</b></h4>
            </div>
             
            <ul class="list-group">
               <li class="list-group-item"><b>Fecha:</b> {{ $demandaDistribuidor->created_at->format('d-m-Y') }}</li>
               <li class="list-group-item"><b>Provincia:</b> {{ $demandaDistribuidor->provincia_region->provincia }}</li>
               @if ( $restringido == '1' )
                  <li class="list-group-item"><center>
                     @if (session('perfilSuscripcion') == 'Gratis')
                        @if (session('perfilSaldo') < $coste->cantidad_creditos)
                           <a class="btn btn-danger" disabled>¡Me Interesa!</a>
                        @else
                           <a href="{{ route('credito.gastar-creditos-dd', $demandaDistribuidor->id) }}" class="btn btn-success">¡Me Interesa! <b>({{$coste->cantidad_creditos}} <i class="fa fa-certificate"></i>)</b></a>
                        @endif
                     @else
                        <a href="{{ route('demanda-distribuidor.marcar', [$demandaDistribuidor->id, '1'] ) }}" class="btn btn-success">¡Me Interesa! <i class="fa fa-thumbs-o-up"></i></a>
                     @endif
                     <a href="{{ route('demanda-distribuidor.marcar', [$demandaDistribuidor->id, '0']) }}" class="btn btn-danger">¡No Me Interesa! <i class="fa fa-thumbs-o-down"></i></a>
                  </center></li>
               @else
                  <li class="list-group-item">
                     @if ($demandaDistribuidor->tipo_creador == 'P')
                        <b>Productor:</b> 
                     @else
                        <b>Importador:</b>
                     @endif
                     {{ $creador->nombre }}</li>
                  <li class="list-group-item"><b>Persona de Contacto:</b> {{ $creador->persona_contacto }}</li>
                  <li class="list-group-item"><b>Teléfono:</b> {{ $creador->telefono }}</li>
                  <li class="list-group-item"><b>Correo Electrónico:</b> {{ $creador->email }}</li>
               @endif
            </ul>
         </div>
      </div>
   </div>
@endsection