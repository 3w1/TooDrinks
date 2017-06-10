@if (Session::has('msj'))
  <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
  </div>
@endif

<div class="row">
   <div class="col-md-4"></div>
    <div class="col-sm-6 col-md-4">
      <a class="thumbnail"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $oferta->producto->imagen }}"></a>
    </div>
    <div class="col-md-4"></div>
</div>

<div class="row">
   <div class="col-md-1"></div>
   <div class="col-md-10 col-xs-12">
      
      <div class="panel panel-default panel-success">
         <div class="pull-right"><a class="btn btn-primary btn-xs" href="" data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></a></div>
         <div class="panel-heading"><h4>Producto Ofertado: <b>{{ $oferta->producto->nombre }}</b></h4>
         </div>
         
         <div class="panel-body">
           {{ $oferta->descripcion }}
         </div>
         
         <ul class="list-group">
            <li class="list-group-item"><b>Precio Unitario:</b> {{ $oferta->precio_unitario }} $</li>
            <li class="list-group-item"><b>Precio por Lote:</b> {{ $oferta->precio_lote }} $</li>
            <li class="list-group-item"><b>Cantidad de Productos:</b> {{ $oferta->cantidad_producto }}</li>
            <li class="list-group-item"><b>Cantidad de Cajas:</b> {{ $oferta->cantidad_caja }}</li>
            <li class="list-group-item"><b>Cantidad de Venta Mínima:</b> {{ $oferta->cantidad_minuma }}</li>
            <li class="list-group-item"><b>Envío Disponible:</b> @if ($oferta->envio == '1') Si @else No @endif </li>
            <li class="list-group-item"><b>Costo del Envío:</b> {{ $oferta->costo_envio }}</li>
            <li class="list-group-item"><b>País Destino:</b> {{ $destinos[0]->pais->pais }}</li>
            <li class="list-group-item"><b>Provincias Disponibles:</b> @foreach ($destinos as $destino) {{ $destino->provincia_region->provincia }}. @endforeach</li>
         </ul>
      </div>

   </div>
   <div class="col-md-1"></div>
</div>
