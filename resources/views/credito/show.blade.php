@extends('plantillas.main')
@section('items')
	@if (Session::has('msj-error'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Ups!</strong> {{Session::get('msj-error')}}.
        </div>
    @endif
@endsection
@section('content-left')

	
	<div id="creditos">
		@foreach($credito as $credito)
		<div class="credito white-panel">
			<h3>{{ $credito->plan }}</h3><hr>
			<div class="credito-info panel">
				<p>{{ $credito->cantidad_creditos }}</p>
				<p>{{ $credito->descripcion }}</p>
				<p>Precio: $${{ number_format($credito->precio) }}</p>
				
				<p>
				<a class="btn bt-warnig" href="{{ route('payment') }}"><i class="fa fa-cart-plus"></i>comprar</a> 
				<a class="btn bt-prmary" href="#"><i class="fa fa-chevron-circle-right"></i>Leer mas</a>
				</p>
				
			</div>
		</div>
		@endforeach

	</div>

@stop
