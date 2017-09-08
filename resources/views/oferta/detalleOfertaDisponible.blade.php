@extends('plantillas.main')
@section('title', 'Detalle de Oferta')

@section('title-header')
   Detalle de Oferta
@endsection

@section('title-complement')
   ({{$oferta->titulo}})
@endsection

@section('content-left')
    <?php 
      if ($oferta->tipo_creador == 'P'){
         $creador = DB::table('productor')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $oferta->creador_id)
                     ->first();
      }elseif ($oferta->tipo_creador == 'I'){
         $creador = DB::table('importador')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $oferta->creador_id)
                     ->first();
      }elseif ($oferta->tipo_creador == 'D'){
         $creador = DB::table('distribuidor')
                     ->select('nombre', 'persona_contacto', 'telefono', 'email')
                     ->where('id', '=', $oferta->creador_id)
                     ->first();
      }
   ?>

   @section('alertas')
      @if (Session::has('msj'))
       <div class="alert alert-success alert-dismissable">
           <button type="button" class="close" data-dismiss="alert">&times;</button>
           <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
       </div>
     @endif
   @endsection

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
         <div class="thumbnail"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $oferta->producto->imagen }}"></div>
      </div>
      <div class="col-md-4"></div>
   </div>

    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <center>
            <b>Visitas:</b> <label class="label bg-blue label-lg">{{$oferta->cantidad_visitas}}</label>
            <b>Contactos:</b> <small class="label bg-green">{{$oferta->cantidad_contactos}}</small>
         </center>
      </div>
      <div class="col-md-4"></div>
   </div><br />

   <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10 col-xs-12">
        
         <div class="panel panel-default panel-success">
            <div class="panel-heading"><h4>Producto Ofertado: <b>{{ $oferta->producto->nombre }}</b></h4>
            </div>
           
            <div class="panel-body">
               {{ $oferta->descripcion }}
            </div>
           
            <ul class="list-group">
               <li class="list-group-item"><b>Precio Unitario:</b> {{ $oferta->precio_unitario }} $</li>
               <li class="list-group-item"><b>Precio por Lote:</b> {{ $oferta->precio_lote }} $</li>
               <li class="list-group-item"><b>Cantidad de Productos:</b> {{ $oferta->cantidad_producto }}</li>
               <li class="list-group-item"><b>Cantidad de Cajas:</b> {{ $oferta->cantidad_caja }}</li>
               <li class="list-group-item"><b>Cantidad de Venta Mínima:</b> {{ $oferta->cantidad_minuma }}</li>
               <li class="list-group-item"><b>Envío Disponible:</b> @if ($oferta->envio == '1') Si @else No @endif </li>
               <li class="list-group-item"><b>Costo del Envío:</b> {{ $oferta->costo_envio }}</li>
               @if ($restringido == '1')
                  <li class="list-group-item"><center>
                     <a href="{{ route('oferta.marcar', [$oferta->id, '1']) }}" class="btn btn-warning">¡Me Interesa!</a>
                     <a href="{{ route('oferta.marcar', [$oferta->id, '0']) }}" class="btn btn-danger">¡No Me Interesa!</a>
                  </center></li>
               @else
                  <li class="list-group-item">
                  @if ($oferta->tipo_creador == 'P')
                     <b>Productor:</b>
                  @elseif ($oferta->tipo_creador == 'I') 
                     <b>Importador:</b> 
                  @elseif ($oferta->tipo_creador == 'D') 
                     <b>Distribuidor:</b>  
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
      <div class="col-md-1"></div>
  </div>
@endsection
