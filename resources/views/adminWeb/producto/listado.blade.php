@extends('adminWeb.plantillas.main')
@section('title', 'Productos')

@section('title-header')
   Listado de Productos
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
   
   @foreach($productos as $producto)
      <div class="col-md-4 col-xs-6">
         <div class="thumbnail">
            <div>
               <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
            </div>             
            <div class="caption">
               <p>
                  @if ($producto->aprobado == '0')
                     <label class="label label-danger">Sin Publicar</label>
                  @else
                     <label class="label label-success">Publicado</label>
                  @endif
                  @if ($producto->confirmado == '0')
                     <label class="label label-danger">Sin Confirmar</label>
                  @else
                     <label class="label label-success">Confirmado</label>
                  @endif
               </p>
               <h3>{{ $producto->nombre }}</h3>
               <p><strong>{{ $producto->bebida->nombre }}</strong> ({{ $producto->clase_bebida->clase }})</p>
               <p><center>
                  <a href="{{ route('admin.producto-detallado', [$producto->id, $producto->nombre_seo])}}" class="btn btn-primary" role="button">Ver Más</a>
               </center></p>
            </div>
         </div>
      </div>
   @endforeach
@endsection

@section('pagination')
   {{ $productos->render()}}
@endsection

@section('content-right')
  
   <div class="box box-solid">
       <div class="box-header with-border">
         <h3 class="box-title">Búsqueda Personalizada</h3>

         <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
         </div>
      </div>

      <div class="box-body">
         <div class="input-group input-group-sm">
            <input type="text" name="table_search" class="form-control" placeholder="Buscar Producto">

            <div class="input-group-btn">
               <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
         </div>
      </div>
   </div>

   <div class="box box-solid">
      <div class="box-header with-border">
         <h3 class="box-title">Filtros</h3>

         <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
         </div>
      </div>
      
      <div class="box-body no-padding">
         <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="#"><i class="fa fa-inbox"></i> Ver Todos
               <span class="label label-primary pull-right">12</span></a>
            </li>
            <li class="active"><a href="#"><i class="fa fa-envelope-o"></i> Confirmados</a></li>
            <li class="active"><a href="#"><i class="fa fa-file-text-o"></i> Sin Confirmar</a></li>
            <li class="active"><a href="#"><i class="fa fa-filter"></i> Publicados 
               <span class="label label-warning pull-right">65</span></a>
            </li>
            <li class="active"><a href="#"><i class="fa fa-trash-o"></i> Sin Publicar</a></li>
         </ul>
      </div>
   </div>
@endsection


