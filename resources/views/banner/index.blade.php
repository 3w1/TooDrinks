@extends('plantillas.main')
@section('title', 'Mis Banners')

@section('title-header')
   Banners Publicitarios
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
               </center></p>
            </div>
         </div>
      </div>
   @endforeach
@endsection

@section('paginacion')
   {{$banners->render()}}
@endsection


