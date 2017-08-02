@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><center>¡<strong>¡Bienvenido!!</strong></center></div>
                <div class="panel-body">
                	<div class="thumbnail">
            			<img src="{{ asset('imagenes/logo.png') }}" >
            		</div>
                    @if (Auth::guest())
                        <div class="alert alert-warning">
                             <center><b>Por favor inicie sesión, o regístrese para acceder a las opciones de TooDrinks.com</b></center>
                        </div>
            		 
                    @else 
                        <div class="alert alert-success">
                             <center><strong>Enhorabuena.. Has sido loggeado con éxito. <a href="{{route('inicio')}}">Click aquí</a> para acceder a tu panel de administración.</strong></center>
                        </div>
                       
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
