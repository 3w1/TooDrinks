@extends('plantillas.main')
@section('title', 'Listado de Ofertas')

@section('title-header')
   Ofertas
@endsection

@section('title-complement')
   (Mis Ofertas)
@endsection

@section('content-left')
   @section('alertas')
      @if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
      @endif
   @endsection

   @foreach($ofertas as $oferta)
      <div class="col-md-4 col-xs-6">
         <div class="thumbnail">
            <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $oferta->producto->imagen }}" >
            <div class="caption">
               <h3>{{ $oferta->titulo }}</h3>
               <ul class="nav nav-stacked">
                  <li><a><strong>Producto:</strong> {{ $oferta->producto->nombre }}</a></li>
                  <li><a><strong>Precio Unitario: </strong> {{ $oferta->precio_unitario }} $</a></li>
                  <li><a><strong>Envío Disponible: </strong> @if ( $oferta->envio == '1') Si  @else No @endif </a></li>
               </ul>
               <p>
                  <a href="{{ route('oferta.show', $oferta->id) }}" class="btn btn-primary" role="button">Ver Más</a>
               </p>
            </div>
         </div>
      </div>
   @endforeach
@endsection

@section('paginacion')
   {{$ofertas->render()}}
@endsection



