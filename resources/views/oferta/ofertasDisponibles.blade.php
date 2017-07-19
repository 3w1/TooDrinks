@extends('plantillas.main')
@section('title', 'Listado de Ofertas')

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Ofertas Disponibles en su País / Provincia</h3></strong></span>
@endsection

@section('content-left')
   <div class="row">
      @foreach($ofertas as $oferta)
         
         <div class="col-md-4 col-xs-6">
            <div class="thumbnail">
               <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $oferta->producto->imagen }}" >
               <div class="caption">
                  <h3>{{ $oferta->titulo }}</h3>
                  <p>{{ $oferta->descripcion }}</p>
                  <ul class="nav nav-stacked">
                     <li><a><strong>Producto:</strong> {{ $oferta->producto->nombre }}</a></li>
                  </ul>
                  <p>
                     <a href="{{ route('oferta.detalle', $oferta->id)}}" class="btn btn-primary" role="button">Ver Detalles</a>
                  </p>
               </div>
            </div>
         </div>
      @endforeach
   </div>
   <div>
      <center>{{ $ofertas->render() }}</center>
   </div>
@endsection



