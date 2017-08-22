<?php 
    $paises = DB::table('pais')
        ->orderBy('pais', 'ASC')
        ->pluck('pais', 'id');
 ?>

{!! Html::script('js/usuarios/registrarse.js') !!}

<div id="travelo-signup" class="travelo-signup-box travelo-box">
    <div class="login-social">
        <a href="#" class="button login-facebook"><i class="soap-icon-facebook"></i>Registro con Facebook</a>
        <a href="#" class="button login-googleplus"><i class="soap-icon-googleplus"></i>Registro con Google+</a>
    </div>
    <div class="seperator"><label>O</label></div>
    <div class="simple-signup">
        <div class="text-center signup-email-section">
            <a href="#" class="signup-email"><i class="soap-icon-letter"></i>Registrarse con Email</a>
        </div>
        <p class="description">Al registrarme, acepto las Condiciones de servicio de TooDrinks y sus Políticas de privacidad.</p>
    </div>
    <div class="email-signup">
        <form action="{{ route('register') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            {!! Form::hidden('estado_datos', '0') !!}
            {!! Form::hidden('id_entidad', '0') !!}
            {!! Form::hidden('tipo_entidad', 'U') !!}

            <div class="form-group">
                <input type="text" class="input-text full-width" name="nombre" placeholder="Nombre">
            </div>
            <div class="form-group">
                <input type="text" class="input-text full-width" name="apellido" placeholder="Apellido">
            </div>
            <div class="form-group">
                <input type="text" class="input-text full-width" name="email" placeholder="Correo Electrónico">
            </div>
            <div class="form-group">
                <input type="text" class="input-text full-width" name="name" placeholder="Nombre de Usuario">
            </div>
            <div class="form-group">
                <input type="password" class="input-text full-width" name="password" placeholder="Contraseña">
            </div>
            <div class="form-group">
                <input type="password" class="input-text full-width" placeholder="Confirme su contraseña">
            </div>
            <div class="form-group">
                {!! Form::select('pais_id', $paises, null, ['class' => 'input-select full-width', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();']) !!}
            </div>
            <div class="form-group">
                <select name="provincia_region_id" class="input-select full-width" id="provincias">
                    <option value="">Seleccione una provincia..</option>
                </select>
            </div>
            <div class="form-group">
                {!! Form::select('tipo', ['U' => 'Usuario', 'P' => 'Productor', 'I' => 'Importador', 'D' => 'Distribuidor', 'H' => 'Horeca' ], null, ['class' => 'input-select full-width', 'placeholder' => 'Seleccione una opción..', 'id' => 'entidad', 'onchange' => 'tipoHoreca();']) !!}
            </div>
            <div class="form-group" id="tipo_horeca" style="display: none;">
                {!! Form::select('tipo_horeca', ['H' => 'Hotel', 'R' => 'Restaurante', 'C' => 'Cafetería'], null, ['class' => 'input-select full-width', 'placeholder' => 'Seleccione una opción..']) !!}
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Recibir noticias TooDrinks
                    </label>
                </div>
            </div>
            <div class="form-group">
                <p class="description">Al inscribirme, acepto las Condiciones de servicio de TooDrinks y sus Políticas de privacidad.</p>
            </div>
            <button type="submit" class="full-width btn-medium">Registrarme</button>
        </form>
    </div>
    <div class="seperator"></div>
    <p>¿Ya eres miembro TooDrinks? <a href="#travelo-login" class="goto-login soap-popupbox">Iniciar Sesión</a></p>
</div>