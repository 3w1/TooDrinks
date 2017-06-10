<div class="modal fade" id="modalImagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cambiar Imagen de Producto</h4>
      </div>
      <div class="modal-body">
      
         <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

            {!! Form::open(['route' => 'producto.updateImagen', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
               {!! Form::hidden('id', $producto->id) !!}
               {!! Form::hidden('nombre', $producto->nombre) !!}
               {!! Form::hidden('who', 'D') !!}
               
               <div class="form-group">
                  {!! Form::label('imagen', 'Logo / Imagen') !!}
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

