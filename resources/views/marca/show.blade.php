@extends('plantillas.main')
@section('title', 'Crear Marca')

@section('title-header')
   Detalles de Marca
@endsection

@section('title-complement')
   ({{$marca->nombre}})
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
  
   @include('marca.modales.editLogo')
  
   @include('marca.modales.editMarca')

   {!! Form::hidden('marca', $marca->id, ['id' => 'marca']) !!}

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
         @if (session('perfilTipo') == 'P')
            <a href="" class="thumbnail" data-toggle='modal' data-target="#modalImagen"><img src="{{ asset('imagenes/marcas/thumbnails') }}/{{ $marca->logo }}"></a>
         @else 
            <a class="thumbnail"><img src="{{ asset('imagenes/marcas/thumbnails') }}/{{ $marca->logo }}"></a>
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
            <div class="panel-heading"><h4><b>Nombre SEO: {{ $marca->nombre_seo }}</b></h4></div>
            
            <ul class="list-group">
               @if (session('perfilTipo') != 'P')
                  <li class="list-group-item"><b>Productor:</b> @if ($marca->productor->nombre == 'master') Sin Reclamar @else {{ $marca->productor->nombre }} @endif</li>
               @endif
               <li class="list-group-item"><b>Descripción:</b> {{ $marca->descripcion }}</li>
               <li class="list-group-item"><b>País Originario:</b> {{ $marca->pais->pais }}</li>
               <li class="list-group-item"><b>Website:</b> <a href="{{$marca->website}}" target="_blank">{{ $marca->website }}</a></li>
            </ul>
         </div>

      </div>
      <div class="col-md-1"></div>
   </div>
@endsection