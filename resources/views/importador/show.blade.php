@extends('plantillas.main')
@section('title', 'Perfil de Importador')

@section('items')
@endsection

@section('content-left')
    
    @section('title-header')
        <h3><b>Importador {{ $importador->nombre }}</b></h3>
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
            <a href="" class="thumbnail"><img src="{{ asset('imagenes/importadores/thumbnails') }}/{{ $importador->logo }}"></a>
        </div>
        <div class="col-md-4"></div>
    </div>

    <div class="row">
       <div class="col-md-1"></div>
       <div class="col-md-10 col-xs-12">
          
          <div class="panel panel-default panel-success">
             <div class="panel-heading"><h4><b>Persona de Contacto: {{ $importador->persona_contacto }}</b></h4></div>
             
             <ul class="list-group">
                <li class="list-group-item"><b>Dirección:</b> {{ $importador->direccion }}</li>
                <li class="list-group-item"><b>Teléfono:</b> {{ $importador->telefono }}</li>
                <li class="list-group-item"><b>Correo Electrónico:</b> {{ $importador->email }}</li>
                <li class="list-group-item"><b>Website:</b> {{ $importador->website }}</li>
                <li class="list-group-item"><b>Facebook:</b> {{ $importador->facebook }}</li>
                <li class="list-group-item"><b>Twitter:</b> {{ $importador->twitter }}</li>
                <li class="list-group-item"><b>Instagram:</b> {{ $importador->instagram }}</li>
             </ul>
          </div>
       </div>
       <div class="col-md-1"></div>
    </div>

    
@endsection