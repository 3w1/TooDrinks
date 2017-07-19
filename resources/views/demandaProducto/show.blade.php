@extends('plantillas.main')
@section('title', 'Demanda de Producto')

@section('items')
@endsection

@section('content-left')
   <?php 
      if ($demandaProducto->tipo_creador == 'I'){
         $creador = DB::table('importador')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $demandaProducto->creador_id)
                     ->first();
      }elseif ($demandaProducto->tipo_creador == 'D'){
         $creador = DB::table('distribuidor')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $demandaProducto->creador_id)
                     ->first();
      }else{
         $creador = DB::table('horeca')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $demandaProducto->creador_id)
                     ->first();
      }
   ?>

   @section('title-header')
      <h3><b>{{ $demandaProducto->titulo }}</b></h3>
   @endsection

   @if (Session::has('msj'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
      </div>
   @endif

   <div class="row">
      @if ($restringido == '1')
         @if (session('perfilSuscripcion') != 'Premium')
            @if (session('perfilSaldo') < '30')
               <div class="alert alert-danger">
                  No tiene créditos suficientes para ver la información de las demandas de producto. Por favor compre créditos. <a href="{{ route('credito.index') }}">Ver Planes de Crédito</a> O consiga una Suscripción Premium. <a href="">Ver Suscripciones</a> 
               </div>
            @else
               <div class="alert alert-danger">
                  Se le descontarán 30 créditos de su saldo. Para ver datos de contacto sin pagar créditos debe obtener una Suscripción Premium. 
               </div>
            @endif
         @else
            <div class="alert alert-info">
               <b>Presione el botón de "Me Interesa" para agregar la Demanda de Producto a su sección de ¡¡Demandas de Interés!!</b> 
            </div>
         @endif
      @endif
      
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
         @if ($demandaProducto->producto_id != '0')
            <a href="" class="thumbnail"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $demandaProducto->producto->imagen }}"></a>
         @else
            <a href="" class="thumbnail"><img src="{{ asset('imagenes/productos/bebida.jpg') }}"></a>
         @endif
      </div>
      <div class="col-md-4"></div>
   </div>

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <center>
            <b>Visitas:</b> <label class="label bg-blue label-lg">{{$demandaProducto->cantidad_visitas}}</label>
            <b>Contactos:</b> <small class="label bg-green">{{$demandaProducto->cantidad_contactos}}</small>
         </center>
      </div>
      <div class="col-md-4"></div>
   </div><br />

   <div class="row">
      <div class="col-md-1"></div>
         
      <div class="col-md-10 col-xs-12"> 
         <div class="panel panel-default panel-success">
            <div class="panel-heading"><h4><b> 
               @if ($demandaProducto->producto_id != '0') 
                  Demanda de Producto: 
               @else 
                  Demanda de Bebida: 
               @endif 
               {{ $demandaProducto->bebida->nombre }}</b></h4>
            </div>
             
            <ul class="list-group">
               <li class="list-group-item"><b>Descripción:</b> {{ $demandaProducto->descripcion }}</li>
               <li class="list-group-item"><b>Cantidad Mínima Requerida:</b> {{ $demandaProducto->cantidad_minima }} unidades.</li>
               <li class="list-group-item"><b>Cantidad Máxima Requerida:</b> {{ $demandaProducto->cantidad_maxima }} unidades.</li>
               @if ( $restringido == '1' )
                  <li class="list-group-item"><center>
                     @if (session('perfilSuscripcion') != 'Premium')
                        @if (session('perfilSaldo') < '30')
                           <a class="btn btn-danger" disabled>¡Me Interesa!</a>
                        @else
                           @if ($demandaProducto->producto_id != '0')
                              <a href="{{ route('credito.gastar-creditos-dp', ['30', $demandaProducto->id]) }}" class="btn btn-warning">¡Me Interesa! <b>(30 <i class="fa fa-certificate"></i>)</b></a>
                           @else
                              <a href="{{ route('credito.gastar-creditos-db', ['30', $demandaProducto->id]) }}" class="btn btn-warning">¡Me Interesa! <b>(30 <i class="fa fa-certificate"></i>)</b></a>
                           @endif
                        @endif
                     @else
                         <a href="{{ route('demanda-producto.marcar', $demandaProducto->id) }}" class="btn btn-warning">¡Me Interesa! <i class="fa fa-thumbs-o-up"></i></a>
                     @endif
                  </center></li>
               @else
                  <li class="list-group-item" >
                     @if ($demandaProducto->tipo_creador == 'I') 
                        <b>Importador:</b> 
                     @elseif ($demandaProducto->tipo_creador == 'D') 
                        <b>Distribuidor:</b> 
                     @else 
                        <b>Horeca:</b> 
                     @endif 
                     {{ $creador->nombre }}
                  </li>
                  <li class="list-group-item"><b>Persona de Contacto:</b> {{ $creador->persona_contacto }}</li>
                  <li class="list-group-item"><b>Teléfono:</b> {{ $creador->telefono }}</li>
                  <li class="list-group-item"><b>Correo Electrónico:</b> {{ $creador->email }}</li>
               @endif
            </ul>
         </div>
      </div>
   </div>
@endsection