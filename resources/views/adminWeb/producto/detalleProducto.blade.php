@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Ver Producto')

@section('title-header')
   {{ $producto->nombre}}
@endsection

@section('title-complement')
   Detalles del Producto
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

   @include('producto.modales.editLogo')

   @include('producto.modales.editProducto')

   <div class="row">
      <div class="col-md-4"></div>
         <div class="col-sm-6 col-md-4">
           <a href="" class="thumbnail" data-toggle='modal' data-target="#modalImagen"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $producto->imagen }}"></a>
         </div>
      <div class="col-md-4"></div>
   </div>

   <div class="row">
      <div class="col-md-1"></div>

      <div class="col-md-10 col-xs-12">
         <div class="panel panel-default panel-success">
            <div class="pull-right"><a class="btn btn-primary btn-xs" data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></a></div>
            <div class="panel-heading"><h4><b>Nombre SEO: {{ $producto->nombre_seo }}</b></h4></div>
            
            <ul class="list-group">
               <li class="list-group-item"><b>Tipo de Bebida:</b> {{ $producto->bebida->nombre }}</li>
               <li class="list-group-item"><b>Características del Tipo de Bebida:</b> {{ $producto->bebida->caracteristicas }}</li>
               <li class="list-group-item"><b>Clase de Bebida:</b> {{ $producto->clase_bebida->clase }}</li>
               <li class="list-group-item"><b>Características de la Clase de Bebida:</b> {{ $producto->clase_bebida->caracteristicas }}</li>
               <li class="list-group-item"><b>País Originario:</b> {{ $producto->pais->pais }}. ({{ $producto->provincia_region->provincia }})</li>
               <li class="list-group-item"><b>Año de Producción:</b> {{ $producto->ano_produccion }}</li>
               <li class="list-group-item"><b>Marca:</b> {{ $producto->marca->nombre }}</li>
               <li class="list-group-item"><b>Productor:</b> {{ $productor->nombre }}</li>
            </ul>
         </div>
      </div>
      
      <div class="col-md-1"></div>
   </div>
@endsection

@section('content-right')
   <!-- PRODUCT LIST -->
   <div class="box box-primary">
      <div class="box-header with-border">
         <h3 class="box-title">Últimas Opiniones</h3>
         @if ($cont > 6)
            <div class="box-tools pull-right">
              <a href="#">Ver Todos</a>
            </div>
         @endif
      </div>
      <!-- /.box-header -->

      <div class="box-body">
         <div class="box-footer box-comments">
            @if ($cont > 0)
               @foreach ($comentarios as $comentario)
                  <?php 
                     if ($comentario->tipo_creador == 'P'){
                        $perfil = DB::table('productor')
                                    ->select('nombre', 'logo')
                                    ->where('id', '=', $comentario->creador_id)
                                    ->first();
                     }elseif ($comentario->tipo_creador == 'I'){
                        $perfil = DB::table('importador')
                                    ->select('nombre', 'logo')
                                    ->where('id', '=', $comentario->creador_id)
                                    ->first();
                     }elseif ($comentario->tipo_creador == 'D'){
                        $perfil = DB::table('distribuidor')
                                    ->select('nombre', 'logo')
                                    ->where('id', '=', $comentario->creador_id)
                                    ->first();
                     }elseif ($comentario->tipo_creador == 'H'){
                        $perfil = DB::table('horeca')
                                    ->select('nombre', 'logo')
                                    ->where('id', '=', $comentario->creador_id)
                                    ->first();
                     }
                     
                   ?>
                  <div class="box-comment">
                     @if ($comentario->tipo_creador == 'P')
                        <img class="img-circle img-sm" src="{{ asset('imagenes/productores/thumbnails')}}/{{ $perfil->logo }}">
                     @elseif ($comentario->tipo_creador == 'I')
                        <img class="img-circle img-sm" src="{{ asset('imagenes/importadores/thumbnails')}}/{{ $perfil->logo }}">
                     @elseif ($comentario->tipo_creador == 'D')
                        <img class="img-circle img-sm" src="{{ asset('imagenes/distribuidores/thumbnails')}}/{{ $perfil->logo }}">
                     @elseif ($comentario->tipo_creador == 'H')
                        <img class="img-circle img-sm" src="{{ asset('imagenes/horecas/thumbnails')}}/{{ $perfil->logo }}">
                     @endif
                  
                     <div class="comment-text">
                        <span class="username">
                           {{ $perfil->nombre }}
                           <span class="text-muted pull-right">   
                              @if ( $comentario->valoracion == '1')
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star-o"></i>
                                 <i class="fa fa-star-o"></i>
                                 <i class="fa fa-star-o"></i>
                                 <i class="fa fa-star-o"></i>
                              @elseif ($comentario->valoracion == '2') 
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star-o"></i>
                                 <i class="fa fa-star-o"></i>
                                 <i class="fa fa-star-o"></i>
                              @elseif ($comentario->valoracion == '3')
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star-o"></i>
                                 <i class="fa fa-star-o"></i>
                              @elseif ($comentario->valoracion == '4')
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star-o"></i>
                              @elseif ($comentario->valoracion == '5')
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i>
                                 <i class="fa fa-star" style="color: orange;"></i> 
                              @endif
                           </span>
                        </span>
                        {{ $comentario->comentario }}
                        
                     </div>
                  </div>
               @endforeach
            @else
               <div class="comment-text">
                  No existen opiniones del producto.
               </div>
            @endif
         </div>
      </div>
      <!-- /.box-body -->

      <div class="box-footer text-center">
         <a href="#">Ver Todos</a>
      </div>
   </div>
@endsection
