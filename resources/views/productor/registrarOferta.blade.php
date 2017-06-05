@extends('plantillas.productor.mainProductor')
@section('title', 'Crear Oferta')

@section('items')

@endsection

@section('content-left')
	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
	<script>
	
		function estados() {

			var opcion = document.getElementById("opciones").value;

			if (opcion == "P"){
				document.getElementById("estados").innerHTML = "";
			
				var id = document.getElementById('pais_id').value;
			    var urls = "http://localhost:8000/pais/"+id+"";
			    var token = document.getElementById('token').value;
			    
			    
			    $.ajax({
			        url:urls,
			        headers: {'X-CSRF-TOKEN': token},
			        type:'GET',
			        success:function(ans){
			        	for (var i = 0; i < ans.length; i++ ){
							document.getElementById("estados").innerHTML += "<label class='checkbox-inline'><input type='checkbox' name='provincias[]' value='"+ans[i].id +"'>"+ans[i].provincia+"</label>";
			        	}
			         },
			        error:function(jqXHR, exception){
			           var msg = '';
				        if (jqXHR.status === 0) {
				            msg = 'Not connect.\n Verify Network.';
				        } else if (jqXHR.status == 404) {
				            msg = 'Requested page not found. [404]';
				        } else if (jqXHR.status == 500) {
				            msg = 'Internal Server Error [500].';
				        } else if (exception === 'parsererror') {
				            msg = 'Requested JSON parse failed.';
				        } else if (exception === 'timeout') {
				            msg = 'Time out error.';
				        } else if (exception === 'abort') {
				            msg = 'Ajax request aborted.';
				        } else {
				            msg = 'Uncaught Error.\n' + jqXHR.responseText;
				        }
				        alert(msg);
					}
			    });
			}else{
				document.getElementById("estados").innerHTML = "";
			}
		}
	</script>

	@section('title-header')
		<h3><b>Crear Oferta  del Producto {{ $producto }}</b></h3>
	@endsection
	
	{!! Form::open(['route' => 'oferta.store', 'method' => 'POST']) !!}
		
		{!! Form::hidden('who', 'P') !!}

		{!! Form::hidden('tipo_creador', 'P') !!}
		{!! Form::hidden('creador_id', session('productorId')) !!}
		{!! Form::hidden('producto_id', $id) !!}

			@include('oferta.formularios.createForm')
		
		{!! Form::close() !!}

@endsection