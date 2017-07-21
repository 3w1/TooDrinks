@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Banners')

{!! Html::script('js/adminWeb/detallePublicacionBanner.js') !!}

@section('title-header')
   Banners
@endsection

@section('title-complement')
   (Por Programar Publicación)
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

   @foreach($solicitudes as $solicitud)
      <div class="col-md-4 col-xs-6">
         <div class="thumbnail">
            <div>
               <img src="{{ asset('imagenes/banners/thumbnails/') }}/{{ $solicitud->banner->imagen }}" class="img-responsive">
            </div>             
            <div class="caption">
               <p><center>
                  <b>País Destino:</b> {{$solicitud->pais->pais}} 
               </center></p>
               <p><center>
                  <b>Tiempo de Duración:</b> {{$solicitud->tiempo_publicacion}} Días.
               </center></p>
               <p><center>
                  <a href="{{ route('admin.asignar-fechas', $solicitud->id) }}" class="btn btn-warning" role="button">Asignar Período</a>
               </center></p>
               </div>
            </div>
         </div>
      @endforeach
      <div>
         {{ $solicitudes->render() }}
      </div>
   </div>
@endsection


