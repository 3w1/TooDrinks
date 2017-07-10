@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Crear Marca')

@section('title-header')
  {{ $marca->nombre }}
@endsection

@section('title-complement')
   (Detalles de la Marca)
@endsection

@section('content-left')
   @section('alertas')
      @if (Session::has('msj-success'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj-success')}}.
         </div>
      @endif
   @endsection
  
   @include('marca.modales.editLogo')
  
   @include('marca.modales.editMarca')
  
   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
         <a href="" class="thumbnail" data-toggle='modal' data-target="#modalImagen"><img src="{{ asset('imagenes/marcas/thumbnails') }}/{{ $marca->logo }}"></a>
      </div>
      <div class="col-md-4"></div>
   </div>

   <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10 col-xs-12">
         
         <div class="panel panel-default panel-success">
            <div class="pull-right"><a class="btn btn-primary btn-xs" data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></a></div>
            <div class="panel-heading"><h4><b>Nombre SEO: {{ $marca->nombre_seo }}</b></h4></div> 
            
            <ul class="list-group">
               <li class="list-group-item"><b>Productor:</b> @if ($marca->productor->nombre == 'master') Sin Propietario @else {{ $marca->productor->nombre }} @endif</li>
               <li class="list-group-item"><b>Descripción:</b> {{ $marca->descripcion }}</li>
               <li class="list-group-item"><b>País Originario:</b> {{ $marca->pais->pais }}. ({{ $marca->provincia_region->provincia }})</li>
               <li class="list-group-item"><b>Website:</b> {{ $marca->website }}</li>
            </ul>
         </div>
      </div>
      <div class="col-md-1"></div>
   </div>
@endsection