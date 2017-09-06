@extends('adminWeb.plantillas.main')
@section('title', 'Banners')

{!! Html::script('js/adminWeb/detallesBanner.js') !!}

@section('title-header')
   Banners
@endsection

@section('title-complement')
   (Por Aprobar)
@endsection

@include('adminWeb.banner.modales.detallesBanner')

@section('content-left')  

   @section('alertas')
      @if (Session::has('msj-success'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj-success')}}.
         </div>
      @endif
   @endsection

   @foreach($banners as $banner)
      <div class="col-md-4 col-xs-6">
         <div class="thumbnail">
            <div>
               <img src="{{ asset('imagenes/banners/thumbnails/') }}/{{ $banner->imagen }}" class="img-responsive">
            </div>             
            <div class="caption">
               <p><strong>{{ $banner->titulo}}</strong></p>
               <p><center>
                  <a href="#" class="btn btn-info" role="button" onclick="cargarDetalles({{$banner->id}});">Detalles</a>
                  <a href="{{ route('admin.aprobar-banner', $banner->id) }}" class="btn btn-primary" role="button">Aprobar</a>
               </center></p>
               <p><center>
                  <a href="{{ route('admin.sugerir-correcciones-banner', $banner->id) }}" class="btn btn-warning" role="button">Sugerir Correcciones</a>
               </center></p>
            </div>
         </div>
      </div>
   @endforeach
@endsection

@section('pagination')
   {{ $banners->render()}}
@endsection


