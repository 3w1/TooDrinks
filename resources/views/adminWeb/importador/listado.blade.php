@extends('adminWeb.plantillas.main')
@section('title', 'Importadores')

@section('title-header')
   Listado de Importadores
@endsection

@section('content-left')

   @section('alertas')
      @if (Session::has('msj-success'))
           <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>¡Enhorabuena!</strong> {{Session::get('msj-success')}}.
           </div>
       @endif
   @endsection

   <div class="col-md-12">
      <div class="box">
         <div class="box-header">
            <h3 class="box-title">Importadores</h3>
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
                  <th><center>Nombre</center></th>
                  <th><center>País</center></th>
                  <th><center>Persona de Contacto</center></th>
                  <th><center>Teléfono</center></th>
                  <th><center>Correo</center></th>
                  <th><center>Acción</center></th>
               </thead>
               <tbody>
                  @foreach ($importadores as $importador) 
                     <tr>
                        <td><center>{{ $importador->nombre }}</td>
                        <td><center>{{ $importador->pais->pais }}</td>
                        <td><center>{{ $importador->persona_contacto}}</center></td>
                        <td><center>{{ $importador->telefono }}</center></td>
                        <td><center>{{ $importador->email }}</center></td>
                        <td><center>
                           <a class="btn btn-primary btn-xs" href="{{ route('admin.actualizar-importador', [$importador->id, $importador->nombre]) }}"><i class="fa fa-edit"></i></a>
                           @if ($importador->reclamada == '0')
                              <a class="btn btn-success btn-xs" href="{{ route('admin.enviar-invitacion', ['I', $importador->id]) }}"><i class="fa fa-envelope-o"></i></a>
                           @endif
                        </center></td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>      
      </div>
   </div>
@endsection

@section('pagination')
   {{$importadores->render()}}
@endsection