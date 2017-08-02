@extends('plantillas.main')
@section('title', 'Mis Solicitudes de Producto')

{!! Html::script('js/demandaProductos/cambiarStatus.js') !!}

@section('title-header')
   Demanda de Producto
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
   
   <div class="col-md-12">
      <div class="box">
         <div class="box-header">
            <h3 class="box-title">Mis Demandas</h3>

            <div class="box-tools">
               <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar">
                  <div class="input-group-btn">
                     <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
               </div>
            </div>
         </div>

         <div class="box-body table-responsive no-padding table-bordered">
            <table class="table table-hover">
               <thead>
                  <th><center>N°</center></th>
                  <th><center>Fecha de Solicitud</center></th>
                  <th><center>Producto / Bebida</center></th>
                  <th><center>País</center></th>
                  <th><center>Status</center></th>
                  <th ><center>Visitas / Contactos</center></th>
                  <th ><center>Acción</center></th>
               </thead>
               <tbody>
                  @foreach ($demandasProductos as $demandaProducto)
                     <?php $cont++; ?>  
                     <tr>
                        <td><center>{{ $cont }}</td>
                        <td><center>{{ $demandaProducto->created_at->format('d-m-Y') }}</td>
                        <td><center> 
                              @if ($demandaProducto->producto_id == '0') 
                                 {{ $demandaProducto->bebida->nombre." (B)" }} 
                              @else 
                                 {{ $demandaProducto->producto->nombre." (P)" }} 
                              @endif
                        </center></td>
                        <td><center>{{ $demandaProducto->pais->pais }}</td>
                        <td><center>
                           <div class="btn-group btn-toggle"> 
                              @if ($demandaProducto->status == '1')
                                 <button class="btn btn-primary btn-xs active" id="on-{{$demandaProducto->id}}" onclick="cambiar(this.id);">Visible</button>
                                 <button class="btn btn-default btn-xs" id="off-{{$demandaProducto->id}}" onclick="cambiar(this.id);">No Visible</button>
                              @else
                                 <button class="btn btn-default btn-xs" id="on-{{$demandaProducto->id}}" onclick="cambiar(this.id);">Visible</button>
                                 <button class="btn btn-primary btn-xs active" id="off-{{$demandaProducto->id}}" onclick="cambiar(this.id);">No Visible</button>
                              @endif
                           </div>
                        </center></td>
                        <td><center>
                           <label class="label label-warning">{{$demandaProducto->cantidad_visitas}}</label> /
                           <label class="label label-success">{{$demandaProducto->cantidad_contactos}}</label>
                        </center></td>
                        <td><center><a href="{{ route('demanda-producto.edit', $demandaProducto->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a></td>
                     </tr>
                  @endforeach
                  {!! Form::open(['route' => 'demanda-producto.status', 'method' => 'POST', 'id' => 'formStatus' ]) !!}
                     {!! Form::hidden('id', null, ['id' => 'id']) !!}
                     {!! Form::hidden('status', null, ['id' => 'status'] ) !!}
                  {!! Form::close() !!}
               </tbody>
            </table>
         </div>      
      </div>
   </div>
@endsection