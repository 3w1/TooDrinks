@extends('plantillas.main')
@section('title', 'Mis Banners')

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Mis Banners</strong></h3></strong></span>
@endsection

@section('content-left')   

   <div class="row">
      @foreach($banners as $banner)
         <div class="col-md-4 col-xs-6">
            <div class="thumbnail">
               <div>
                  <img src="{{ asset('imagenes/banners/thumbnails/') }}/{{ $banner->imagen }}" class="img-responsive">
               </div>             
               <div class="caption">
                  <p><center>
                     @if($banner->aprobado == '0')
                        <label class="label label-warning">En Revisión</label> 
                     @elseif ($banner->aprobado == '1')
                        <label class="label label-success">Aprobado</label>
                     @else 
                        <label class="label label-danger">Con Correcciones</label>
                     @endif
                  </center></p>
                  <p><center>
                    <a href="{{ route('banner-publicitario.show', $banner->id) }}" class="btn btn-primary" role="button">Detalles</a>
                    @if ($banner->aprobado == '1')
                      <a href="{{ route('banner-publicitario.solicitar-publicacion', $banner->id)}}" class="btn btn-success" role="button">Solicitar Publicación</a>
                    @else 
                       <a href="{{ route('banner-publicitario.solicitar-publicacion', $banner->id)}}" class="btn btn-success" role="button" disabled>Solicitar Publicación</a>
                    @endif
                  </center></p>
               </div>
            </div>
         </div>
      @endforeach
      <div>
         {{ $banners->render() }}
      </div>
   </div>
@endsection

