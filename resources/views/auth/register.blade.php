@extends('layouts.app')

@section('content')

    {!! Html::script('js/usuarios/registrarse.js') !!}

    <?php 
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->get();

     ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Registrarse</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            {!! Form::hidden('estado_datos', '1') !!}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nombre de Usuario</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Correo Electrónico</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre'] ) !!}
                                </div>
                                
                            </div>

                            <div class="form-group">
                                {!! Form::label('apellido', 'Apellido', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                     {!! Form::text('apellido', null, ['class' => 'form-control', 'placeholder' => 'Apellido'] ) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('direccion', 'Dirección', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                   {!! Form::textarea('direccion', null, ['class' => 'form-control', 'placeholder' => 'Dirección', 'rows' => '5'] ) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('codigo_postal', 'Código Postal', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('codigo_postal', null, ['class' => 'form-control', 'placeholder' => 'Código Postal'] ) !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                {!! Form::label('país', 'País', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    <select name="pais_id" class="form-control" id="pais_id" onchange="cargarProvincias();">
                                        <option value="">Seleccione un país..</option>
                                        @foreach ($paises as $pais )
                                            <option value="{{ $pais->id }}">{{ $pais->pais }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('provincia', 'Provincia', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    <select name="provincia_region_id" class="form-control" id="provincias">
                                        <option value="">Seleccione una provincia..</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('telefono', 'Teléfono', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                    {!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Teléfono'] ) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('telefono_opcional', 'Teléfono Opcional', ['class' => 'col-md-4 control-label']) !!}
                                <div class="col-md-6">
                                     {!! Form::text('telefono_opcional', null, ['class' => 'form-control', 'placeholder' => 'Teléfono Opcional'] ) !!}
                                </div>
                            </div>

                            {!! Form::hidden('avatar', 'icono-usuario.jpg') !!}

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Registrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
