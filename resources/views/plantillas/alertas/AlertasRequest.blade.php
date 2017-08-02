@if(count($errors)> 0)
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button class="close" type="button" data-dismiss="alert" aria-label="Close"></button>
		<strong>¡¡Upss!! Debes corregir los siguientes campos: </strong>
		<ul>
			@foreach($errors->all() as $error)
				<li>{!!$error!!}</li>
			@endforeach
		</ul>
	</div>
@endif