<div class="modal fade" id="listadoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Mis Marcas</h4>
      </div>
      <div class="modal-body">
         {!! Form::open(['route' => 'productor.asociar-producto', 'method' => 'POST']) !!}
            {!! Form::hidden('producto_id', null, ['id' => 'producto_id']) !!}
            <div class="form-group">
               {!! Form::label('marca', 'Marca') !!}
               <select name="marca_id" id="marcas" class="form-control"></select>
            </div>
      </div>
      <div class="modal-footer">
         {!! Form::submit('Agregar', ['class' => 'btn btn-primary']) !!}
      </div>
         {!! Form::close() !!}
    </div>
  </div>
</div>

