<?php 
	$paises = DB::table('pais')
	     	->orderBy('pais', 'ASC')
	        ->pluck('pais', 'id');
?>

@extends('frontend.plantillas.main')

{!! Html::script('js/usuarios/registrarse.js') !!}

@section('content')
    
    @include('frontend.plantillas.partes.terminos')
    
	<div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">REGISTRO</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="#">INICIO</a></li>
                <li class="active">REGISTRO</li>
            </ul>
        </div>
    </div>

	<br />

    <section>
    	<div class="container">
            <div id="main">
                <div class="col-md-9 no-float no-padding center-block">
                    <div class="intro text-center block">
                        <h2>Crear Cuenta TooDrinks</h2>
                    </div>
                    <form action="{{ route('register') }}" method="POST">
                    	<div class="alert small-box" style="display: none;"></div>

                    	{{ csrf_field() }}
            			<input type="hidden" name="_token" value="{{ csrf_token() }}">

                        {!! Form::hidden('estado_datos', '0') !!}
			            {!! Form::hidden('id_entidad', '0') !!}

                        <div class="row form-group">
                            <div class="col-xs-6">
                                <label><strong>Nombre</strong></label>
                                <input type="text" class="input-text full-width" name="nombre" required>
                            </div>
                            <div class="col-xs-6">
                                <label><strong>Apellido</strong></label>
                                <input type="text" class="input-text full-width" name="apellido" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-6">
                                <label><strong>Correo Electrónico</strong></label>
                                <input type="text" class="input-text full-width" name="email" required>
                            </div>
                            <div class="col-xs-6">
                                <label><strong>Nombre de Usuario</strong></label>
                                <input type="text" class="input-text full-width" name="name" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-6">
                                <label><strong>Contraseña</strong></label>
                                <input type="text" class="input-text full-width" id="clave1" name="password" required>
                            </div>
                            <div class="col-xs-6">
                                <label><strong>Confirme su Contraseña</strong></label>
                                <input type="text" class="input-text full-width" id="clave2" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-6">
                                <label><strong>País</strong></label>
                                {!! Form::select('pais_id', $paises, null, ['class' => 'input-select full-width', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();', 'required']) !!}
                            </div>
                            <div class="col-xs-6">
                                <label><strong>Provincia / Estado</strong></label>
                                <select name="provincia_region_id" class="input-select full-width" id="provincias" required>
				                    <option value="">Seleccione una provincia..</option>
				                </select>
                            </div>
                        </div>
						<div class="row form-group">
							<div class="col-xs-6">
								<label><strong>Perfil</strong></label>
								{!! Form::select('tipo', ['U' => 'Usuario', 'P' => 'Productor', 'I' => 'Importador', 'D' => 'Distribuidor', 'H' => 'Horeca' ], null, ['class' => 'input-select full-width', 'placeholder' => 'Seleccione una opción..', 'id' => 'entidad', 'onchange' => 'tipoHoreca();', 'required']) !!}
							</div>
							<div class="col-xs-6" id="tipo_horeca" style="display: none;">
								<label><strong>Tipo de Horeca</strong></label>
								{!! Form::select('tipo_horeca', ['H' => 'Hotel', 'R' => 'Restaurante', 'C' => 'Cafetería'], null, ['class' => 'input-select full-width', 'placeholder' => 'Seleccione una opción..']) !!}
							</div>
            			</div>
                        <div class="form-group">
                          	<center><p>Al registrarme, acepto las <a href="#terminos" class="soap-popupbox">Condiciones de servicio y Políticas de privacidad</a> de TooDrinks.com</p></center>
                        </div>
                        <button type="submit" class="btn-large full-width">REGISTRARME</button> 
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection