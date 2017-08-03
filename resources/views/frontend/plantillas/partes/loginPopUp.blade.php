<div id="travelo-login" class="travelo-login-box travelo-box">
    <div class="login-social">
        <a href="#" class="button login-facebook"><i class="soap-icon-facebook"></i>Iniciar con Facebook</a>
        <a href="#" class="button login-googleplus"><i class="soap-icon-googleplus"></i>Iniciar con Google+</a>
    </div>
    <div class="seperator"><label>O</label></div>
    <form action="{{ route('login') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" class="input-text full-width" name="email" placeholder="correo electrónico" required autofocus>
        </div>
        <div class="form-group">
            <input type="password" class="input-text full-width" name="password" placeholder="contraseña" required>
        </div>
        <div class="form-group">
            <a href="#" class="forgot-password pull-right">¿Olvidó su contraseña?</a>
            <div class="checkbox checkbox-inline">
                <label>
                    <input type="checkbox"> ¡Recordarme!
                </label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="full-width btn-medium">Iniciar Sesión</button>
        </div>
    </form>
    <div class="seperator"></div>
    <p>No tiene una cuenta? <a href="#travelo-signup" class="goto-signup soap-popupbox">Registrarse</a></p>
</div>