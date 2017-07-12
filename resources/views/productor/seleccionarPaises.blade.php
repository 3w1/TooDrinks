@extends('plantillas.main')
@section('title', 'Seleccionar Países')

@section('content-left')
	
	@section('title-header')
		<span><h3>Países Destino</h3></span>
	@endsection

	<div class="row">
		<div class="col-md-12">
			<h4><strong>Los países que seleccione serán los que recibirán sus ofertas y demandas. Igualmente solo le llegarán solicitudes y demandas de esos países.</strong></h4>
		</div><hr>
		{!! Form::open(['route' => 'productor.guardar-paises', 'method' => 'POST']) !!}
		@foreach ($paises as $pais)
			<div class="col-md-3">
				<h4><input type="checkbox" name="paises[]" value="{{$pais->id}}"> {{$pais->pais}}</h4>
			</div>
		@endforeach
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4 ">
			{!! Form::submit('Guardar', ['class' => 'form-control btn btn-success']) !!}
		</div>
		<div class="col-md-4"></div>
	</div>
		{!! Form::close()!!}
@endsection