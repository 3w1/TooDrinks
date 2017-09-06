<div class="modal fade" id="imagenModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Cambiar Imagen</h4>
         </div>
         <div class="modal-body">
            {!! Form::open(['route' => 'admin.imagen-banner-update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
               {!! Form::hidden('id_banner', null, ['class' => 'form-control', 'id' => 'id_banner'])!!}
               
               <div class="form-group">
                  {!! Form::label('imagen', 'Imagen') !!}
                  {!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
               </div>
         </div>
         <div class="modal-footer">
            {!! Form::button('Cancelar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
            {!! Form::submit('Cambiar Imagen', ['class' => 'btn btn-primary']) !!}
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>

