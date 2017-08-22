@extends('plantillas.main')
@section('title', 'Mi Perfil')

@section('title-header')
   Editar Perfil
@endsection

@section('content-left')
	{!! Html::script('js/distribuidores/edit.js') !!}

	@section('alertas')
      	@if (Session::has('msj'))
           <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
           </div>
      	@endif
   	@endsection

	@include('distribuidor.modales.modalAvatar')

	{!! Form::open(['route' => ['distribuidor.update', $distribuidor->id], 'method' => 'PUT']) !!}
		<div class="panel with-nav-tabs panel-info">
	        <div class="panel-heading">
	        	<ul class="nav nav-tabs">
	                <li class="active"><a href="#tab1default" data-toggle="tab">Datos Personales</a></li>
	                <li><a href="#tab2default" data-toggle="tab">Datos de Ubicación</a></li>
	                <li><a href="#tab3default" data-toggle="tab">Datos de Contacto</a></li>
	                <li><a href="#tab4default" data-toggle="tab">Redes Sociales</a></li> 
	            </ul>
	        </div>
	        <div class="panel-body">
	            <div class="tab-content">
	                <div class="tab-pane fade in active" id="tab1default">
	                	<div class="row">
	                		<div class="col-md-4"></div>
		       				<div class="col-sm-6 col-md-4">
		         				<a href="" class="thumbnail" data-toggle='modal' data-target="#myModal"><img src="{{ asset('imagenes/distribuidores/thumbnails') }}/{{ $distribuidor->logo }}"></a>
		       				</div>
		       				<div class="col-md-4"></div>
	                	</div>
	                	
	                	<div class="form-group">
							{!! Form::label('nombre', 'Nombre') !!}
							{!! Form::text('nombre', $distribuidor->nombre, ['class' => 'form-control'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('nombre_seo', 'Nombre SEO') !!}
							{!! Form::text('nombre_seo', $distribuidor->nombre_seo, ['class' => 'form-control'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('descripcion', 'Descripcion') !!}
							{!! Form::textarea('descripcion', $distribuidor->descripcion, ['class' => 'form-control', 'rows' => '5'] ) !!}
						</div>
	                </div>
	                <div class="tab-pane fade" id="tab2default">
						<div class="form-group">
							{!! Form::label('direccion', 'Dirección') !!}
							{!! Form::textarea('direccion', $distribuidor->direccion, ['class' => 'form-control', 'rows' => '5'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('codigo_postal', 'Código Postal') !!}
							{!! Form::text('codigo_postal', $distribuidor->codigo_postal, ['class' => 'form-control'] ) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('pais', 'País') !!}
							{!! Form::select('pais_id', $paises, $distribuidor->pais_id, ['class' => 'form-control', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();']) !!}
						</div>

						<div class="form-group">
							{!! Form::label('provincias', 'Provincia') !!}
							{!! Form::select('provincia_region_id', $provincias, $distribuidor->provincia_region_id, ['class' => 'form-control', 'id' => 'provincias']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('latitud', 'Latitud') !!}
							{!! Form::text('latitud', $distribuidor->latitud, ['class' => 'form-control', 'placeholder' => 'Latitud'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('longitud', 'Longitud') !!}
							{!! Form::text('longitud', $distribuidor->longitud, ['class' => 'form-control', 'placeholder' => 'Longitud'] ) !!}
						</div>
	                </div>
	                <div class="tab-pane fade" id="tab3default">
	            		<div class="form-group">
							{!! Form::label('persona_contacto', 'Persona de Contacto') !!}
							{!! Form::text('persona_contacto', $distribuidor->persona_contacto, ['class' => 'form-control'] ) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('telefono', 'Teléfono') !!}
							{!! Form::text('telefono', $distribuidor->telefono, ['class' => 'form-control'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('telefono_opcional', 'Teléfono Opcional') !!}
							{!! Form::text('telefono_opcional', $distribuidor->telefono_opcional, ['class' => 'form-control'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('email', 'Correo Electrónico') !!}
							{!! Form::email('email', $distribuidor->email, ['class' => 'form-control'] ) !!}
						</div>    	
	                </div>
	                <div class="tab-pane fade" id="tab4default">
	                	<div class="form-group">
							{!! Form::label('website', 'Website') !!}
							{!! Form::url('website', $distribuidor->website, ['class' => 'form-control'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('facebook', 'Facebook') !!}
							{!! Form::url('facebook', $distribuidor->facebook, ['class' => 'form-control'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('twitter', 'Twitter') !!}
							{!! Form::text('twitter', $distribuidor->twitter, ['class' => 'form-control'] ) !!}
						</div>

						<div class="form-group">
							{!! Form::label('instagram', 'Instagram') !!}
							{!! Form::text('instagram', $distribuidor->instagram, ['class' => 'form-control'] ) !!}
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