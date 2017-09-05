@extends('adminWeb.plantillas.main')
@section('title', 'Créditos')

@section('title-header')
   Agregar / Quitar Créditos
@endsection

{!! Html::script('js/adminWeb/cargarEntidades.js') !!}

@section('content-left')
	@section('alertas')
      	@if (Session::has('msj-success'))
           <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>¡Enhorabuena!</strong> {{Session::get('msj-success')}}.
           </div>
      	@endif
   	@endsection
   	
	{!! Form::open(['route' => 'admin.sumar-restar-creditos', 'method' => 'POST']) !!}
		<div class="form-group">
		    {!! Form::label('tipo', 'Tipo de Entidad')!!}
			{!! Form::select('tipo_entidad', ['P' => 'Productor', 'I' => 'Importador', 'D' => 'Distribuidor'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...', 'required', 'onchange' => 'cargarEntidades();', 'id' => 'tipo_entidad']) !!}
		</div>
		<div class="form-group">
			{!!Form::label('entidad', 'Entidad')!!}
			<select class="form-control" name="entidad_id" id="entidad_id" disabled>
				<option value="">Seleccione una opción</option>
			</select>
		</div>

		<div class="form-group">
			{!! Form::label('creditos', 'Cantidad de Créditos')!!}
			{!! Form::text('cantidad_creditos', null, ['class' => 'form-control', 'required'])!!}
			<div class="alert alert-info">
	            Coloque el signo "-" si desea quitar créditos.
	        </div>
		</div>

		<div class="form-group">
			{!! Form::submit('Agregar / Quitar', ['class' => 'btn btn-primary pull-right']) !!}
		</div>
	{!! Form::close() !!}
	
@endsection