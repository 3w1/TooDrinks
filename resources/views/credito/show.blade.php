@extends('plantillas.main')
@section('content-left')

<div class="container">
	<div id="creditos">
		@foreach($credito as $credito)
		<div class="credito white-panel">
			<h3>{{ $credito->plan }}</h3><hr>
			<div class="credito-info panel">
				<p>{{ $credito->cantidad_creditos }}</p>
				<p>{{ $credito->descripcion }}</p>
				<p>Precio: $${{ number_format($credito->precio) }}</p>
				
				<p>
				<a class="btn bt-warnig" href="#">comprar</a> 
				<a class="btn bt-prmary" href="#">contacto</a>
				</p>
				
			</div>
		</div>
		@endforeach

	</div>
</div>
@stop



  
