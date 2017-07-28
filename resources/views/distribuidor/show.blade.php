@extends('plantillas.main')
@section('title', 'Perfil de Distribuidor')

@section('items')
@endsection

@section('content-left')
    
    @section('title-header')
        <h3><b>Distribuidor {{ $distribuidor->nombre }}</b></h3>
    @endsection

    @if (Session::has('msj'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
      </div>
    @endif

    <div class="row">
       <div class="col-md-4"></div>
        <div class="col-sm-6 col-md-4">
            <a class="thumbnail"><img src="{{ asset('imagenes/distribuidores/thumbnails') }}/{{ $distribuidor->logo }}"></a>
        </div>
        <div class="col-md-4"></div>
    </div>

    <div class="row">
       <div class="col-md-1"></div>
       <div class="col-md-10 col-xs-12">
          
          <div class="panel panel-default panel-success">
             <div class="panel-heading"><h4><b>Persona de Contacto: {{ $distribuidor->persona_contacto }}</b></h4></div>
             
             <ul class="list-group">
                <li class="list-group-item"><b>Dirección:</b> {{ $distribuidor->direccion }}</li>
                <li class="list-group-item"><b>Teléfono:</b> {{ $distribuidor->telefono }}</li>
                <li class="list-group-item"><b>Correo Electrónico:</b> {{ $distribuidor->email }}</li>
                <li class="list-group-item"><b>Website:</b> {{ $distribuidor->website }}</li>
                <li class="list-group-item"><b>Facebook:</b> {{ $distribuidor->facebook }}</li>
                <li class="list-group-item"><b>Twitter:</b> {{ $distribuidor->twitter }}</li>
                <li class="list-group-item"><b>Instagram:</b> {{ $distribuidor->instagram }}</li>
             </ul>
          </div>
       </div>
       <div class="col-md-1"></div>
    </div>

    
@endsection