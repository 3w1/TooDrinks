@extends('plantillas.main')
@section('title', 'Comercialización')

@section('title-header')
   Comercialización
@endsection

@section('title-complement')
   (Historial)
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
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.create') }}"><strong>BUSCAR PRODUCTO</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.bebida') }}"><strong>BUSCAR TIPO DE BEBIDA</strong></a>
      </li>
      <li class="active btn btn-default">
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
                                 </tr>
                              @endforeach
                           @else
                              <tr>
                                 <td colspan="3">Actualmente no posee búsquedas de productos o bebidas en su historial.</td>
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
