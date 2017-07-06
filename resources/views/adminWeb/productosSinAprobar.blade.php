@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Productos')

{!! Html::script('js/adminWeb/detalleProducto.js') !!}

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3><center>Productos sin Aprobar</center></strong></h3></strong></span>
@endsection

@include('adminWeb.modales.detalleProducto')

@section('content-left')   

   <div class="row">
      @foreach($productos as $producto)
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
                  <p>
                     <a href="#" class="btn btn-info" role="button" onclick="cargarDetalles({{$producto->id}});">Ver Detalles</a>
                     <a href="{{ route('admin.aprobar-producto', $producto->id) }}" class="btn btn-primary" role="button">Aprobar</a>
                     <a href="#" class="btn btn-danger" role="button">Eliminar</a>
                  </p>
               </div>
            </div>
         </div>
      @endforeach
   </div>

   <div>
      <center>{{ $productos->render() }}</center>
   </div>
@endsection


