@extends('plantillas.main')
@section('title', 'Comercialización')

{!! Html::script('js/demandaProductos/cambiarStatus.js') !!}

@section('title-header')
   Comercialización
@endsection

@section('title-complement')
   (Mis Solicitudes)
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
   
   <ul class="nav nav-pills">
      <li class="active btn btn-default">
         <a href="{{ route('demanda-producto.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.create') }}"><strong>BUSCAR PRODUCTO</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.bebida') }}"><strong>BUSCAR TIPO DE BEBIDA</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.historial') }}"><strong>HISTORIAL</strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <div class="box">
                  <div class="box-body table-responsive no-padding table-bordered">
                     <table class="table table-hover">
                        <thead>
                           <th><center>Fecha de Solicitud</center></th>
                           <th><center>Producto / Bebida</center></th>
                           <th ><center>Visitas / Contactos</center></th>
                           <th><center>Status</center></th>
                        </thead>
                        <tbody>
                           @if ($cont > 0)
                              @foreach ($demandasProductos as $demandaProducto) 
                                 <tr>
                                    <td><center>{{ $demandaProducto->created_at->format('d-m-Y') }}</td>
                                    <td><center> 
                                       @if ($demandaProducto->producto_id == '0') 
                                          (B) {{ $demandaProducto->bebida->nombre }} 
                                          @if ($demandaProducto->pais_id == null)
                                             [Cualquier País]
                                          @else
                                             [{{$demandaProducto->pais->pais}}]
                                          @endif
                                       @else 
                                         (P) {{ $demandaProducto->producto->nombre }} 
                                       @endif
                                    </center></td>
                                    <td><center>
                                       <label class="label label-warning">{{$demandaProducto->cantidad_visitas}}</label> /
                                       <label class="label label-success">{{$demandaProducto->cantidad_contactos}}</label>
                                    </center></td>
                                    <td><center>
                                       <div class="btn-group btn-toggle"> 
                                          <button class="btn btn-primary btn-xs active" id="on-{{$demandaProducto->id}}" onclick="cambiar(this.id);">Visible</button>
                                          <button class="btn btn-default btn-xs" id="off-{{$demandaProducto->id}}" onclick="cambiar(this.id);">No Visible</button>
                                       </div>
                                    </center></td>
                                 </tr>
                              @endforeach
                              {!! Form::open(['route' => 'demanda-producto.status', 'method' => 'POST', 'id' => 'formStatus' ]) !!}
                                 {!! Form::hidden('id', null, ['id' => 'id']) !!}
                                 {!! Form::hidden('status', null, ['id' => 'status'] ) !!}
                              {!! Form::close() !!}
                           @else
                              <tr>
                                 <td colspan="4">Actualmente no posee búsquedas activas de productos o bebidas</td>
                              </tr>
                           @endif
                        </tbody>
                     </table>
                  </div>      
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection

@section('paginacion')
   {{$demandasProductos->render()}}
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                  
               </div>
            </div>
         </div>
      </div>
@endsection
