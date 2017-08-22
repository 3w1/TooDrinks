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
               <li class="list-group-item"><b>País Originario:</b> {{ $producto->pais->pais }}</li>
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
         <!--<div class="box-footer">
            <!--@if (session('perfilTipo') == 'P')
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
                  <span class="text-muted pull-left"> 
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="1" onclick="valorar(this.id);"></i></a>
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="2" onclick="valorar(this.id);"></i></a>
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="3" onclick="valorar(this.id);"></i></a>
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="4" onclick="valorar(this.id);"></i></a>
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="5" onclick="valorar(this.id);"></i></a>
                  </span>
                  {!! Form::open(['route' => 'opinion.store', 'method' => 'POST']) !!}
                     {!! Form::hidden('valoracion', '0', ['id' => 'valoracion1']) !!}
                     {!! Form::hidden('producto_id', $producto->id) !!}
                     {!! Form::hidden('publicada', '0') !!}
                     
                     {!! Form::text('comentario', null, ['class' => 'form-control input-sm', 'placeholder' => 'Valore y presione Enter para dejar su comentario']) !!}
                     <span class="text-muted pull-right">
                        <br>{!! Form::submit('Opinar', ['class' => 'btn btn-success btn-xs']) !!}
                     </span>
                  {!! Form::close() !!}
               @else
                  <span class="text-muted pull-left" id="valoracionOculta" style="display: none;"> 
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="1.u" onclick="modificarValoracion(this.id);"></i></a>
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="2.u" onclick="modificarValoracion(this.id);"></i></a>
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="3.u" onclick="modificarValoracion(this.id);"></i></a>
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="4.u" onclick="modificarValoracion(this.id);"></i></a>
                     <a href="#"><i class="fa fa-star-o" style="color: black;" id="5.u" onclick="modificarValoracion(this.id);"></i></a>
                  </span>
                  {!! Form::open(['route' => ['opinion.update', $comentarioPerfil->id],  'method' => 'PUT']) !!}
                     {!! Form::hidden('valoracion', $comentarioPerfil->valoracion, ['id' => 'valoracion2']) !!}
                     {!! Form::hidden('producto_id', $producto->id) !!}
                     {!! Form::text('comentario', $comentarioPerfil->comentario, ['class' => 'form-control input-sm', 'id' => 'comentarioPerfil', 'disabled']) !!}
                     <span class="text-muted pull-right" style="display: none;" id="btnOculto">
                        <br>{!! Form::submit('Opinar', ['class' => 'btn btn-success btn-xs']) !!}
                     </span>
                  {!! Form::close() !!}
                  <div id="info" style="display: block;">
                     Ya has dejado tu comentario sobre este producto. Click <a href="#" onclick="modificarComentario();">aquí</a> para modificarlo...
                  </div>
               @endif
            </div>
            <a href="">Ver Todos</a>
         </div>-->
         <a href="">Ver Todos</a>
      </div>
   </div>
@endsection
