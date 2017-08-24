@extends('plantillas.main')
@section('title', 'Listado de Productos')

@section('title-header')
   Catálogo de Productos
@endsection

@section('title-complement')
   (Marca: {{$marca}})
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
   
   @foreach($productos as $producto)
      <div class="col-md-4 col-xs-6">
         <div class="thumbnail">
            <div>
               <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
            </div>             
            <div class="caption">
               <p>
                  @if ($producto->confirmado == '0')
                     @if (session('perfilTipo')== 'P')
                        <a href="#" class="label label-danger">Sin Confirmar</a>   
                     @else 
                        <label class="label label-danger">Sin Confirmar</label>
                     @endif
                  @else
                     <label class="label label-success">Confirmado</label>
                  @endif
               </p>
               <h3>{{ $producto->nombre }}</h3>
               <p><strong>{{ $producto->bebida->nombre }}</strong> ({{ $producto->clase_bebida->clase }})</p>
               <p>
                  <a href="{{ route('producto.detalle', [$producto->id, $producto->nombre_seo]) }}" class="btn btn-primary" role="button">Ver Más</a>
                  <a href="{{ route('oferta.crear-oferta', [$producto->id, $producto->nombre]) }}" class="btn btn-info" role="button">Ofertar</a>
               </p>
            </div>
         </div>
      </div>
   @endforeach
@endsection

@section('paginacion')
   {{$productos->render()}}
@endsection


