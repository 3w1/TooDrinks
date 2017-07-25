@extends('plantillas.main')
@section('title', 'Banners Publicitarios')

{!! Html::script('js/banners/correcciones.js') !!}

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
    
	<span><strong><h3>Mis Publicidades</h3></strong></span>
@endsection

@section('content-left')

   @include('banner.modales.correcciones')

   <div class="row">
      <div class="col-md-12">
         <div class="box">
            <div class="box-header">
               <br>
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
                     <th><center>Banner</center></th>
                     <th><center>País Destino</center></th>
                     <th><center>Fecha de Inicio</center></th>
                     <th><center>Fecha de Fin</center></th>
                     <th><center>Acción</center></th>
                  </thead>
                  <tbody>
                     @foreach ($publicidades as $publicidad) 
                        <tr>
                           <td><center>{{ $publicidad->banner->titulo }}</td>
                           <td><center>{{ $publicidad->pais->pais }}</td>
                           <td><center>{{ date('d-m-Y', strtotime($publicidad->fecha_inicio)) }}</center></td>
                           <td><center>{{ date('d-m-Y', strtotime($publicidad->fecha_fin)) }}</center></td>
                           <td><center>
                              <a href="{{ route('banner-publicitario.detalle-publicacion', $publicidad->id) }}" class="btn btn-primary btn-xs">Ver Más <i class="fa fa-eye"></i></a></td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>      
         </div>
         <center>{{ $publicidades->render() }}</center>
      </div>
   </div>
@endsection