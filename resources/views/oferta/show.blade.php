@extends('plantillas.main')
@section('title', 'Detalle de Oferta')

@section('title-header')
   Detalle de Oferta
@endsection

@section('title-complement')
   ({{$oferta->titulo}})
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
   
   @include('oferta.modales.edit')

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
         <a class="thumbnail"><img src="{{ asset('imagenes/productos/thumbnails') }}/{{ $oferta->producto->imagen }}"></a>
      </div>
      <div class="col-md-4"></div>
   </div>

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <center>
            <b>Visitas:</b> <label class="label bg-blue label-lg">{{$oferta->cantidad_visitas}}</label>
            <b>Contactos:</b> <small class="label bg-green">{{$oferta->cantidad_contactos}}</small>
         </center>
      </div>
      <div class="col-md-4"></div>
   </div><br />
   
   @if ($oferta->status == '1')
      <div class="row">
         <center>
         <div class="btn-group btn-toggle"> 
               <button class="btn btn-primary active" id="on" onclick="cambiar(this.id);">Visible</button>
               <button class="btn btn-default" id="off" onclick="cambiar(this.id);">No Visible</button>
            {!! Form::open(['route' => 'oferta.status', 'method' => 'POST', 'id' => 'formStatus' ]) !!}
               {!! Form::hidden('id_oferta', $oferta->id) !!}
               {!! Form::hidden('titulo_oferta', $oferta->titulo) !!}
               {!! Form::hidden('status', null, ['id' => 'status']) !!}
            {!! Form::close() !!}
         </div>
         </center>
      </div><br>
   @endif
  
   <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10 col-xs-12">
        
         <div class="panel panel-default panel-success">
            @if ($oferta->status == '1')
               <div class="pull-right"><a class="btn btn-primary btn-xs" href="" data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></a></div>
            @endif
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

   <script>
      function cambiar($id){
         if ($id == 'on'){
            document.getElementById("status").value = "1";
         }else{
            document.getElementById("status").value = "0";
         }

         document.forms['formStatus'].submit();
      }
   </script>
@endsection

