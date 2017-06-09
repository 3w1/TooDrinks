@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Productos')

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Productos</h3></strong></span>
@endsection

@section('content-left')   

   <div class="row">
      @foreach($productos as $producto)
         <?php 
            $pais = DB::table('pais')
                    ->select('pais')
                    ->where('id', $producto->pais_id)
                    ->get()
                    ->first();
            
            $clase_bebida = DB::table('clase_bebida')
                              ->select('clase', 'bebida_id')
                              ->where('id', $producto->clase_bebida_id)
                              ->get()
                              ->first();

            $tipo_bebida = DB::table('bebida')
                              ->select('nombre')
                              ->where('id', $clase_bebida->bebida_id)
                              ->get()
                              ->first();

         ?>
         
         <div class="col-md-4 col-xs-6">
            <div class="thumbnail">
               <div class="fondo">
                  <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
               </div>             
               <div class="caption">
                  <h3>{{ $producto->nombre }}</h3>
                  <p><strong>{{ $tipo_bebida->nombre }}</strong> ({{ $clase_bebida->clase }})</p>
                  <p>
                     @if ($producto->publicado == '1')
                        <label class="label label-success">Publicado</label>
                     @else
                        <label class="label label-danger">Por Publicar</label>
                     @endif
                      @if ($producto->confirmado == '1')
                        <label class="label label-success">Confirmado</label>
                     @else
                        <label class="label label-danger">Por Confirmar</label>
                     @endif
                  </p>
               </div>
            </div>
         </div>
      @endforeach
      <div>
         {{ $productos->render() }}
      </div>
   </div>
@endsection


