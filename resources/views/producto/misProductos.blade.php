<?php 
   if (session('perfilTipo') == 'I'){
      $pro = DB::table('producto')
                  ->select('producto.confirmado', 'producto.publicado')
                  ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                  ->where('importador_producto.importador_id', '=', session('perfilId'))
                  ->where('producto.id', '<>', 0)
                  ->get();
   }elseif (session('perfilTipo') == 'D'){
      $pro = DB::table('producto')
                  ->select('producto.confirmado', 'producto.publicado')
                  ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                  ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                  ->where('producto.id', '<>', 0)
                  ->get();
   }elseif (session('perfilTipo') == 'H'){
      $pro = DB::table('producto')
                  ->select('producto.confirmado', 'producto.publicado')
                  ->join('horeca_producto', 'producto.id', '=', 'horeca_producto.producto_id')
                  ->where('horeca_producto.horeca_id', '=', session('perfilId'))
                  ->where('producto.id', '<>', 0)
                  ->get();
   }

   $resumen = array('cont' => 0, 'confirmados' => 0, 'noConfirmados' => 0,
                         'publicados' => 0, 'noPublicados' => 0);
   foreach ($pro as $p){
      $resumen['cont']++; 
      if ($p->confirmado == '0'){
         $resumen['noConfirmados']++;
      }else{
         $resumen['confirmados']++;
      }
      if ($p->publicado == '0'){
          $resumen['noPublicados']++;
      }else{
         $resumen['publicados']++;
      }
  } 
?>
@extends('plantillas.main')
@section('title', 'Listado de Productos')

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Mis Productos</strong></h3></strong></span>
@endsection

@section('content-left')   

   <div class="row">
      @foreach($productos as $producto)
         <div class="col-md-4 col-xs-6">
            <div class="thumbnail">
               <div>
                  <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
               </div>             
               <div class="caption">
                  <p>
                     @if ($producto->publicado == '0')
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
                  <p>
                     <a href="{{ route('producto.detalle', $producto->id) }}" class="btn btn-primary" role="button">Ver Más</a>
                     @if (session('perfilTipo') != 'H')
                        <a href="{{ route('oferta.crear-oferta', [$producto->id, $producto->nombre]) }}" class="btn btn-info" role="button">Ofertar</a>
                     @endif
                  </p>
               </div>
            </div>
         </div>
      @endforeach
   </div>

   <div>
      {{ $productos->render() }}
   </div>
@endsection

@section('content-right')
   <div class="box box-solid box-success">
      <div class="box-header with-border">
         <h3 class="box-title">Filtros</h3>

         <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
         </div>
      </div>
      
      <div class="box-body no-padding">
         <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="{{ route('producto.mis-productos', 'todos') }}"><i class="fa fa-inbox"></i> Ver Todos
               <span class="label label-primary pull-right">{{$resumen['cont']}}</span></a>
            </li>
            <li class="active"><a href="{{route('producto.mis-productos', 'confirmados')}}">
               <i class="fa fa-envelope-o"></i> Confirmados
               <span class="label label-success pull-right">{{$resumen['confirmados']}}</span>
            </a></li>
            <li class="active"><a href="{{route('producto.mis-productos', 'no-confirmados')}}">
               <i class="fa fa-file-text-o"></i> Sin Confirmar
               <span class="label label-danger pull-right">{{$resumen['noConfirmados']}}</span>
            </a></li>
            <li class="active"><a href="{{route('producto.mis-productos', 'publicados')}}"><i class="fa fa-filter"></i> Publicados 
               <span class="label label-info pull-right">{{$resumen['publicados']}}</span>
            </a></li>
            <li class="active"><a href="{{route('producto.mis-productos', 'no-publicados')}}">
               <i class="fa fa-trash-o"></i> Sin Publicar
                <span class="label label-warning pull-right">{{$resumen['noPublicados']}}</span></a>
            </a></li>
         </ul>
      </div>
   </div>
@endsection


