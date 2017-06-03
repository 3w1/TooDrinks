@extends('plantillas.productor.mainProductor')
@section('title', 'Listado de Productos')

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Productos de la Marca <strong>{{ $marca }}</strong></h3></strong></span>
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
               <img src="{{ asset('imagenes/productos/') }}/{{ $producto->imagen }}" >
               <div class="caption">
                  <h3>{{ $producto->nombre }}</h3>
                  <p><strong>{{ $tipo_bebida->nombre }}</strong> ({{ $clase_bebida->clase }})</p>
                  <ul class="nav nav-stacked">
                     <li><a><strong>Año de Producción: </strong> {{ $producto->ano_produccion }} </a></li>
                     <li><a><strong>País: </strong> {{ $pais->pais }} </a></li>
                  </ul>
                  <p>
                     <a href="#" class="btn btn-primary" role="button">Ver Más</a>
                     <a href="#" class="btn btn-info" role="button">Ofertar</a>
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

@section('content-right')
   Holaaa
@endsection


