@extends('plantillas.adminWeb.mainAdmin')

@section('title', 'Planes de Crédito')

@section('title-header')
  Enviar Correo de Invitación
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
	
	<div class="panel panel-primary">
 
  		<div class="panel-heading"><strong><h4>Listado de Productores sin Registrarse</h4></strong></div>
  		<div class="panel-body">
    		<p>Seleccione los productores a los que desea enviarles el correo de invitación...</p>
  		</div>
 
  		<table class="table table-responsive table-hover table-striped">
			<thead>
				<th></th>
				<th>Productor</th>
				<th>Persona de Contacto</th>
				<th>Ubicación</th>
				<th>Teléfono</th>
				<th>Correo</th>
			</thead>		
			<tbody>
				{!! Form::open(['route' => 'mails.invitacion', 'method' => 'POST']) !!}
				@foreach ($productores as $productor)
					@if($productor->id != '0')
						<tr>
							<td><input type="checkbox" name="productores[]" value="{{$productor->id}}"></td>
							<td>{{$productor->nombre}}</td>
							<td>{{$productor->persona_contacto}}</td>
							<td>{{$productor->pais->pais}} ({{$productor->provincia_region->provincia}})</td>
							<td>{{$productor->telefono}}</td>
							<td>{{$productor->email}}</td>
						</tr>
					@endif
				@endforeach
				<tr>
					<td colspan="6"><input type="submit" class="btn btn-success pull-right" value="Enviar Correos"/></td>
				</tr>
				{!! Form::close()!!}
			</tbody>
  		</table>
	</div>
@endsection