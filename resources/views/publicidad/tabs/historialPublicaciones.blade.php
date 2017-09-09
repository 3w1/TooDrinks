@extends('plantillas.main')
@section('title', 'Publicidad')

@section('title-header')
   Publicidad
@endsection

@section('title-complement')
   (Publicaciones en Curso)
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
      <li class="btn btn-default">
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
      <li class="active btn btn-default">
         <a href="{{ route('banner-publicitario.historial') }}"><strong>HISTORIAL</strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <div class="box">
                  <div class="box-header"></div>
                  <div class="box-body table-responsive no-padding table-bordered">
                     <table class="table table-hover">
                        <thead>
                           <th><center>Banner</center></th>
                           <th><center>País</center></th>
                           <th><center>Fecha Inicial</center></th>
                           <th><center>Fecha Final</center></th>
                           <th><center>Clicks</center></th>
                        </thead>
                        <tbody>
                           @if ($cont > 0)
                              @foreach ($publicaciones as $publicacion) 
                                 <tr>
                                    <td><center>{{ $publicacion->banner->titulo }}</td>
                                    <td><center>{{ $publicacion->pais->pais}}</center></td>
                                    <td><center>{{ date('d-m-Y', strtotime($publicacion->fecha_inicio)) }}</center></td>
                                    <td><center>{{ date('d-m-Y', strtotime($publicacion->fecha_fin)) }}</center></td>
                                    <td><center>{{ $publicacion->cantidad_clics }}</center></td>
                                 </tr>
                              @endforeach
                           @else
                              <tr>
                                 <td colspan="5"><strong>No posee publicaciones en su historial.</strong></td>
                              </tr>
                           @endif
                        </tbody>
                     </table>
                  </div>      
               </div>      
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
                  @include('publicidad.tabs.filtroHistorial')
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$publicaciones->appends(Request::only(['pais']))->render()}}
@endsection

