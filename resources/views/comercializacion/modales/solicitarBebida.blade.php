<div class="modal fade" id="modalBebida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title" id="myModalLabel">Solicitar Bebida</h4>
		   	</div>

		   	<div class="modal-body">
				{!! Form::open(['route' => 'demanda-producto.bebida-store', 'method' => 'POST']) !!}
					{!! Form::hidden('bebida_id', null, ['id' => 'bebida_id']) !!}
					{!! Form::hidden('pais_id', null, ['id' => 'pais_id']) !!}
					{!! Form::hidden('producto_id', '0') !!}
					{!! Form::hidden('tipo_creador', 'H') !!}
					{!! Form::hidden('creador_id', session('perfilId')) !!}
					{!! Form::hidden('cantidad_visitas', '0') !!}
					{!! Form::hidden('cantidad_contactos', '0') !!}
					{!! Form::hidden('status', '1') !!}
					               
					<div class="form-group">
						{!! Form::label('titulo', 'Título de la Demanda (*)') !!}
						{!! Form::text('titulo', null, ['class' => 'form-control', 'required']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('descripcion', 'Descripción (*)') !!}
						{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'required', 'rows' => '5']) !!}
					</div>
					
					<div class="form-group">
						{!! Form::label('cantidad_minima', 'Cantidad Mínima') !!}
						{!! Form::number('cantidad_minima', null, ['class' => ' form-control'] ) !!}
					</div>
					
					<div class="form-group">
						{!! Form::label('cantidad_maxima', 'Cantidad Máxima') !!}
						{!! Form::number('cantidad_maxima', null, ['class' => ' form-control'] ) !!}
					</div>
			</div>
			
			<div class="modal-footer">
		        {!! Form::submit('Solicitar Producto', ['class' => 'btn btn-primary']) !!}
		    </div>
			{!! Form::close() !!}
		</div>
	</div>
</div>