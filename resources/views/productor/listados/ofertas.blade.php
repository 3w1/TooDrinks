@extends('plantillas.main')
@section('title', 'Listado de Ofertas')

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Mis Ofertas</h3></strong></span>
@endsection

@section('content-left')
   <div class="row">
      @foreach($ofertas as $oferta)
         <?php 
            $producto = DB::table('producto')
                           ->select('nombre', 'imagen')
                           ->where('id', '=', $oferta->producto_id)
                           ->get()
                           ->first();
         ?>
         
         <div class="col-md-4 col-xs-6">
            <div class="thumbnail">
               <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" >
               <div class="caption">
                  <h3>{{ $oferta->titulo }}</h3>
                  <p>{{ $oferta->descripcion }}</p>
                  <ul class="nav nav-stacked">
                     <li><a><strong>Producto Ofertado:</strong> {{ $producto->nombre }}</a></li>
                     <li><a><strong>Precio Unitario: </strong> {{ $oferta->precio_unitario }} $</a></li>
                     <li><a><strong>Precio por Lote: </strong> {{ $oferta->precio_lote }} $</a></li>
                     <li><a><strong>Envío Disponible: </strong> @if ( $oferta->envio == '1') Si  @else No @endif </a></li>
                  </ul>
                  <p>
                     <a href="{{ route('productor.oferta', $oferta->id) }}" class="btn btn-primary" role="button">Ver Más</a>
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



