@extends('plantillas.productor.mainProductor')
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
               <img src="{{ asset('imagenes/productos/') }}/{{ $producto->imagen }}" >
               <div class="caption">
                  <h3>{{ $oferta->titulo }}</h3>
                  <p>{{ $oferta->descripcion }}</p>
                  <ul class="nav nav-stacked">
                     <li><a><strong>Precio Unitario: </strong> {{ $oferta->precio_unitario }} $</a></li>
                     <li><a><strong>Precio por Lote: </strong> {{ $oferta->precio_lote }} $</a></li>
                     <li><a><strong>País Destino: </strong> {{ $oferta->precio_lote }} $</a></li>
                     <li><a><strong>Provincia Destino: </strong> {{ $oferta->precio_lote }} $</a></li>
                  </ul>
                  <p>
                     <a href="#" class="btn btn-primary" role="button">Ver Más</a>
                  </p>
               </div>
            </div>
         </div>
      @endforeach
      <div>
         {{ $ofertas->render() }}
      </div>
   </div>
@endsection



