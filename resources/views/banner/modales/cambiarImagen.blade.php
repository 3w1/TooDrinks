<div class="modal fade" id="modalImagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title" id="myModalLabel">Cambiar Imagen del Banner</h4>
		   	</div>

		   	<div class="modal-body">
				
				{!! Form::open(['route' => 'banner-publicitario.updateImagen', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
					{!! Form::hidden('id', $banner->id) !!}
					               
					<div class="form-group">
					    {!! Form::label('imagen', 'Imagen del Banner') !!}
					    {!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
					</div>
			</div>
			<div class="modal-footer">
		        {!! Form::submit('Actualizar ', ['class' => 'btn btn-primary']) !!}
		    </div>
			{!! Form::close() !!}
		</div>
	</div>
</div>