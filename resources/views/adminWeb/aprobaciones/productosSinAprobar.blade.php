@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Productos')

{!! Html::script('js/adminWeb/detalleProducto.js') !!}

@section('title-header')
  Productos
@endsection

@section('title-complement')
   (Por Publicar)
@endsection

@include('adminWeb.modales.detalleProducto')

@section('content-left')   
   @section('alertas')
      @if (Session::has('msj-success'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj-success')}}.
         </div>
      @endif
   @endsection

   @foreach($productos as $producto)
      @if($producto->id != 0)
         <div class="col-md-3 col-xs-6">
            <div class="thumbnail">
               <div>
                  <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
               </div>             
               <div class="caption">
                  <h3>{{ $producto->nombre }}</h3> 
                  <p>
                     <strong>{{ $producto->bebida->nombre }}</strong> ({{ $producto->clase_bebida->clase }})
                  </p>
                  <p><center>
                     <a href="#" class="btn btn-info" role="button" onclick="cargarDetalles({{$producto->id}});">Ver Más</a>
                     <a href="{{ route('admin.aprobar-producto', $producto->id) }}" class="btn btn-primary" role="button">Aprobar</a>
                  </center></p>
                  <p><center>
                     <a href="#" class="btn btn-danger" role="button">Eliminar</a>
                  </center></p>
               </div>
            </div>
         </div>
      @endif
   @endforeach
@endsection

@section('pagination')
   {{$productos->render()}}
@endsection


