@extends('plantillas.main')
@section('title', 'Usuario '. Auth::user()->name)

@section('items')
	@if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
@endsection

@section('content-left')
	@if (Auth::user()->activado == '1')
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">PANEL DE USUARIO</h3>

				<div class="box-tools">
	                
	            </div>
			</div>

			<div class="box-body table-responsive no-padding">
				
				<center><h1>ESPACIO EN CONSTRUCCIÓN</h1>
			</div>
		</div>
	@else 
		<div class="alert alert-danger">
 		    <strong>¡¡Ya casi estas listo!!</strong> Hemos enviado un mensaje de confirmación a tu correo electrónico. Por favor confirma tu cuenta para accerder a las opciones del sitio web.
        </div>
    @endif
	
@endsection
