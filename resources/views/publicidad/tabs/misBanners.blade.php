@extends('plantillas.main')
@section('title', 'Publicidad')

@section('title-header')
   Publicidad
@endsection

@section('title-complement')
   (Mis Banners)
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
   
   <ul class="nav nav-pills">
      <li class="active btn btn-default">
         <a href="{{ route('banner-publicitario.index') }}"><strong>MIS BANNERS</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('banner-publicitario.create') }}"><strong>NUEVO BANNER</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('banner-publicitario.nueva-publicacion') }}"><strong>NUEVA PUBLICACIÓN</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('banner-publicitario.publicaciones-en-curso') }}"><strong>PUBLICACIONES EN CURSO</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('banner-publicitario.historial') }}"><strong>HISTORIAL</strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               @if ($cont > 0)
                  @foreach($banners as $banner)
                     <div class="col-md-4 col-xs-6">
                        <div class="thumbnail">
                           <div>
                              <img src="{{ asset('imagenes/banners/thumbnails/') }}/{{ $banner->imagen }}" class="img-responsive">
                           </div>             
                           <div class="caption">
                              <p><strong> {{ $banner->titulo }} </strong></p>
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
                              </center></p>
                           </div>
                        </div>
                     </div>
                  @endforeach
               @else
                  <strong>Actualmente no posee banners.</strong>
               @endif
            </div>
         </div>
      </div>
   </div>
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                  @include('publicidad.tabs.filtroMisBanners')
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$banners->render()}}
@endsection

