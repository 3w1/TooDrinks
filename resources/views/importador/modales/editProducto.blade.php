<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modificar Producto</h4>
      </div>
      <div class="modal-body">
      
      	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
         {!! Form::open(['route' => ['producto.update', $producto->id], 'method' => 'PUT']) !!}
            {!! Form::hidden('who', 'I') !!}

            @include('producto.formularios.editForm')       
         
      </div>
      <div class="modal-footer">
         {!! Form::submit('Modificar Producto', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>