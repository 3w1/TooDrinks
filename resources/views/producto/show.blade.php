@extends('plantillas.main')
@section('title', 'Ver Producto')

@section('items')
@endsection

{!! Html::script('js/opiniones/edit.js') !!}

@section('content-left')
   @if (Session::has('msj'))
     <div class="alert alert-success alert-dismissable">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
     </div>
   @endif
   
   @include('producto.modales.editLogo')

   @include('producto.modales.editProducto')

   @section('title-header')
      <h3>Detalles del Producto: <strong>{{ $producto->nombre }}</strong></h3>
   @endsection

   <div class="row">
      <div class="col-md-4"></div>
       <div class="col-sm-6 col-md-4">
         @if (session('perfilTipo') == 'P')
           <a href="" class="thumbnail" data-toggle='modal' data-target="#modalImagen"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $producto->imagen }}"></a>
         @else
           <a class="thumbnail"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $producto->imagen }}"></a>
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
         <h3 class="box-title">Últimos Comentarios</h3>
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
                           <span class="text-muted pull-right">{{ date('d-m-Y', strtotime($comentario->created_at)) }}</span>
                        </span>
                        {{ $comentario->comentario }}
                     </div>
                  </div>
               @endforeach
            @else
               <div class="comment-text">
                  No existen opiniones del producto. Se tú el primero en dejar tu comentario.
               </div>
            @endif
         </div>
      </div>
      <!-- /.box-body -->

      <div class="box-footer text-center">
         <div class="box-footer">
            @if (session('perfilTipo') == 'P')
               <img class="img-responsive img-circle img-sm" src="{{ asset('imagenes/productores/thumbnails')}}/{{ session('perfilLogo') }}">
            @elseif (session('perfilTipo') == 'I')
               <img class="img-responsive img-circle img-sm" src="{{ asset('imagenes/importadores/thumbnails')}}/{{ session('perfilLogo') }}">
            @elseif (session('perfilTipo') == 'D')
               <img class="img-responsive img-circle img-sm" src="{{ asset('imagenes/distribuidores/thumbnails')}}/{{ session('perfilLogo') }}">
            @elseif (session('perfilTipo') == 'H')
               <img class="img-responsive img-circle img-sm" src="{{ asset('imagenes/horecas/thumbnails')}}/{{ session('perfilLogo') }}">
            @endif
      
            <div class="img-push">
               @if ($existe == '0')
                  {!! Form::open(['route' => 'opinion.store', 'method' => 'POST']) !!}
                     {!! Form::hidden('producto_id', $producto->id) !!}
                     {!! Form::text('comentario', null, ['class' => 'form-control input-sm', 'placeholder' => 'Presione Enter para dejar su comentario']) !!}
                  {!! Form::close() !!}
               @else
                  {!! Form::open(['route' => 'opinion.store', 'method' => 'POST']) !!}
                     {!! Form::hidden('producto_id', $producto->id) !!}
                     {!! Form::text('comentario', $comentarioPerfil->comentario, ['class' => 'form-control input-sm', 'id' => 'comentarioPerfil', 'disabled']) !!}
                  {!! Form::close() !!}
                  <div id="info" style="display: block;">
                     Ya has dejado tu comentario sobre este producto. Click <a href="#" onclick="modificarComentario();">aquí</a> para modificarlo...
                  </div>
               @endif
            </div>
         </div>
      </div>
   </div>
@endsection
