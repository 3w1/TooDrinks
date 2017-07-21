@extends('plantillas.main')
@section('title', 'Banner Publicitario')

@section('items')
@endsection

@section('content-left')
   @section('title-header')
      <h3><b>Detalles del Banner</b></h3>
   @endsection

   @if (Session::has('msj'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
      </div>
   @endif
   
   @include('banner.modales.editarBanner')
   @include('banner.modales.cambiarImagen')
	
	@if ($banner->aprobado == '2')
		<div class="alert alert-danger">
        	<strong>¡Upss!</strong> Su banner tiene algunas correcciones pendientes. <strong>({{$banner->correcciones}}</strong>). Por favor, modifique lo que se especifica en el mensaje para que pueda solicitar su publicación.
    	</div>
    @endif
   	<div class="row">
      	<div class="col-md-4"></div>
      	<div class="col-sm-6 col-md-4">
        	<a href="" class="thumbnail"  data-toggle='modal' data-target="#modalImagen"><img src="{{ asset('imagenes/banners/thumbnails') }}/{{ $banner->imagen }}"></a>
      	</div>
      	<div class="col-md-4"></div>
   	</div>

   <div class="row">
      <div class="col-md-1"></div>
         
      <div class="col-md-10 col-xs-12"> 
         <div class="panel panel-default panel-success">
            <div class="pull-right"><a class="btn btn-primary btn-xs" href="" data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></a></div>
            <div class="panel-heading"><h4><b> 
               {{ $banner->titulo }}</b></h4>
            </div>
             
            <ul class="list-group">
               <li class="list-group-item"><b>Descripción:</b> {{ $banner->descripcion }}</li>
               <li class="list-group-item"><b>URL Destino:</b> {{ $banner->url_banner }}</li>
            </ul>
         </div>
      </div>
   </div>
@endsection