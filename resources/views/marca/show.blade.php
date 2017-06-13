@if (Session::has('msj'))
  <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
  </div>
@endif

{!! Form::hidden('marca', $marca->id, ['id' => 'marca']) !!}

<div class="row">
   <div class="col-md-4"></div>
    <div class="col-sm-6 col-md-4">
      @if ($perfil == 'P')
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
         @if ($perfil == 'P') 
            <div class="pull-right"><a class="btn btn-primary btn-xs" data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></a></div> 
         @endif
         <div class="panel-heading"><h4><b>Nombre SEO: {{ $marca->nombre_seo }}</b></h4></div>
         
         <ul class="list-group">
            <li class="list-group-item"><b>Productor:</b> @if ($marca->productor->nombre == 'master') Sin Reclamar @else {{ $marca->productor->nombre }} @endif</li>
            <li class="list-group-item"><b>Descripción:</b> {{ $marca->descripcion }}</li>
            <li class="list-group-item"><b>País Originario:</b> {{ $marca->pais->pais }}. ({{ $marca->provincia_region->provincia }})</li>
            <li class="list-group-item"><b>Website:</b> {{ $marca->website }}</li>
         </ul>
      </div>

   </div>
   <div class="col-md-1"></div>
</div>
