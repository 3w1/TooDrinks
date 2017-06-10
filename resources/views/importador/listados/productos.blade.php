@extends('plantillas.importador.mainImportador')
@section('title', 'Listado de Productos')

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Productos de la Marca <strong>{{ $marca }}</strong></h3></strong></span>
@endsection

@section('content-left')   

   <div class="row">
      @foreach($productos as $producto)
         <?php 
            $clase_bebida = DB::table('clase_bebida')
                              ->select('clase', 'bebida_id')
                              ->where('id', $producto->clase_bebida_id)
                              ->get()
                              ->first();

            $tipo_bebida = DB::table('bebida')
                              ->select('nombre')
                              ->where('id', $clase_bebida->bebida_id)
                              ->get()
                              ->first();

         ?>
         
         <div class="col-md-4 col-xs-6">
            <div class="thumbnail">
               <div class="fondo">
                  <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
               </div>             
               <div class="caption">
                  <h3>{{ $producto->nombre }}</h3>
                  <p><strong>{{ $tipo_bebida->nombre }}</strong> ({{ $clase_bebida->clase }})</p>
                  <p>
                     <a href="{{ route('importador.producto', [$producto->id, $producto->nombre]) }}" class="btn btn-primary" role="button">Ver Más</a>
                     <a href="{{ route('importador.registrar-oferta', [$producto->id, $producto->nombre]) }}" class="btn btn-info" role="button">Ofertar</a>
                  </p>
               </div>
            </div>
         </div>
      @endforeach
      <div>
         {{ $productos->render() }}
      </div>
   </div>
@endsection


