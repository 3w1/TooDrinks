@extends('plantillas.main')
@section('title', 'Modificar Usuario'.$usuario->nombre)
@section('content-left')

	{!! Html::script('js/usuarios/edit.js') !!}

	@include('usuario.modales.modalAvatar')
	
	@if (Session::has('status'))
		<div class="alert alert-success alert-dismissable">
	  		<button type="button" class="close" data-dismiss="alert">&times;</button>
	  		<strong>¡Enhorabuena!</strong> {{Session::get('status')}}.
		</div>
	@endif

	{!! Form::open(['route' => ['usuario.update', $usuario->id], 'method' => 'PUT']) !!}
	<div class="panel with-nav-tabs panel-info">
        <div class="panel-heading">
        	<ul class="nav nav-tabs">
                <li class="active"><a href="#tab1default" data-toggle="tab">Datos Personales</a></li>
                <li><a href="#tab2default" data-toggle="tab">Datos de Ubicación</a></li>
                <li><a href="#tab3default" data-toggle="tab">Datos de Contacto</a></li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1default">
                	<div class="row">
                		<div class="col-md-4"></div>
	       				<div class="col-sm-6 col-md-4">
	         				<a href="" class="thumbnail" data-toggle='modal' data-target="#myModal"><img src="{{ asset('imagenes/usuarios/thumbnails') }}/{{ $usuario->avatar }}"></a>
	       				</div>
	       				<div class="col-md-4"></div>
                	</div>
                	
                	<div class="form-group">
						{!! Form::label('name', 'Nombre de Usuario') !!}
						{!! Form::text('name', $usuario->name, ['class' => 'form-control'] ) !!}
					</div>
				
					<div class="form-group">
						{!! Form::label('nombre', 'Nombre') !!}
						{!! Form::text('nombre', $usuario->nombre, ['class' => 'form-control'] ) !!}
					</div>

					<div class="form-group">
						{!! Form::label('apellido', 'Apellido') !!}
						{!! Form::text('apellido', $usuario->apellido, ['class' => 'form-control'] ) !!}
					</div>
                </div>
                <div class="tab-pane fade" id="tab2default">
					<div class="form-group">
						{!! Form::label('direccion', 'Dirección') !!}
						{!! Form::textarea('direccion', $usuario->direccion, ['class' => 'form-control', 'rows' => '5'] ) !!}
					</div>

					<div class="form-group">
						{!! Form::label('codigo_postal', 'Código Postal') !!}
						{!! Form::text('codigo_postal', $usuario->codigo_postal, ['class' => 'form-control'] ) !!}
					</div>
						
					<div class="form-group">
						{!! Form::label ('pais_id','País') !!}
						{!! Form::select('pais_id', $paises, $usuario->pais_id, ['class' => 'form-control', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();']) !!}
					</div>
						
					<div class="form-group">
						{!! Form::label ('provincia','Provincia') !!}
						{!! Form::select('provincia_region_id', $provincias, $usuario->provincia_region_id, ['class' => 'form-control', 'id' => 'provincias']) !!}
					</div>
                </div>
                <div class="tab-pane fade" id="tab3default">
            		
					<div class="form-group">
						{!! Form::label('email', 'Correo Electrónico') !!}
						{!! Form::email('email', $usuario->email, ['class' => 'form-control'] ) !!}
					</div>

					<div class="form-group">
						{!! Form::label('telefono', 'Teléfono') !!}
						{!! Form::text('telefono', $usuario->telefono, ['class' => 'form-control'] ) !!}
					</div>

					<div class="form-group">
						{!! Form::label('telefono_opcional', 'Teléfono') !!}
						{!! Form::text('telefono_opcional', $usuario->telefono_opcional, ['class' => 'form-control'] ) !!}
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
		{!! Form::submit('Actualizar Datos', ['class' => 'btn btn-primary pull-right']) !!}
	</div>

    {!! Form::close() !!}

@endsection