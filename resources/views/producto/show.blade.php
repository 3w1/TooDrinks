@extends('plantillas.main')
@section('title', 'Ver Producto')

@section('items')
@endsection

{!! Html::script('js/opiniones/edit.js') !!}

@section('content-left')
   @if (Session::has('msj'))
     <div class="alert alert-success alert-dismissable">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
     </div>
   @endif
   
   @include('producto.modales.editLogo')

   @include('producto.modales.editProducto')

   @section('title-header')
      <h3>Detalles del Producto: <strong>{{ $producto->nombre }}</strong></h3>
   @endsection

   <div class="row">
      <div class="col-md-4"></div>
       <div class="col-sm-6 col-md-4">
         @if (session('perfilTipo') == 'P')
           <a href="" class="thumbnail" data-toggle='modal' data-target="#modalImagen"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $producto->imagen }}"></a>
         @else
           <a class="thumbnail"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $producto->imagen }}"></a>
         @endif
       </div>
       <div class="col-md-4"></div>
   </div>

   <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10 col-xs-12">
         
         <div class="panel panel-default panel-success">
           @if (session('perfilTipo') == 'P')
             <div class="pull-right"><a class="btn btn-primary btn-xs" data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></a></div>
           @endif
            <div class="panel-heading"><h4><b>Nombre SEO: {{ $producto->nombre_seo }}</b></h4></div>
            
            <ul class="list-group">
               <li class="list-group-item"><b>Tipo de Bebida:</b> {{ $producto->bebida->nombre }}</li>
               <li class="list-group-item"><b>Características del Tipo de Bebida:</b> {{ $producto->bebida->caracteristicas }}</li>
               <li class="list-group-item"><b>Clase de Bebida:</b> {{ $producto->clase_bebida->clase }}</li>
               <li class="list-group-item"><b>Características de la Clase de Bebida:</b> {{ $producto->clase_bebida->caracteristicas }}</li>
               <li class="list-group-item"><b>País Originario:</b> {{ $producto->pais->pais }}</li>
               <li class="list-group-item"><b>Año de Producción:</b> {{ $producto->ano_produccion }}</li>
               <li class="list-group-item"><b>Marca:</b> {{ $producto->marca->nombre }}</li>
               @if (session('perfilTipo') != 'P')
                  <li class="list-group-item"><b>Productor:</b> {{ $productor->nombre }}</li>
               @endif
            </ul>
         </div>
      </div>
      <div class="col-md-1"></div>
   </div>
@endsection


