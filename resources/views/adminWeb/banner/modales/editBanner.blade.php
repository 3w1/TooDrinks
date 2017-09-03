<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar Banner</h4>
         </div>
         <div class="modal-body">
            {!! Form::open(['route' => 'admin.banner-update', 'method' => 'POST']) !!}
               {!! Form::hidden('id', null, ['class' => 'form-control', 'id' => 'id'])!!}
               <div class="form-group">
                  {!! Form::label('titu', 'Título (*)' ) !!}
                  {!! Form::text('titulo', null, ['class' => 'form-control', 'id' => 'titulo'])!!}
               </div>   
               <div class="form-group">
                  {!! Form::label('desc', 'Descripción (*)' ) !!}
                  {!! Form::text('descripcion', null, ['class' => 'form-control', 'id' => 'descripcion'])!!}
               </div>
               <div class="form-group">
                  {!! Form::label('url', 'URL (*)' ) !!}
                  {!! Form::text('url_banner', null, ['class' => 'form-control', 'id' => 'url'])!!}
               </div>
         </div>
         <div class="modal-footer">
            {!! Form::button('Cerrar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
            {!! Form::submit('Guardar Cambios', ['class' => 'btn btn-primary']) !!}
         </div>
         {!! Form::close()!!}
      </div>
   </div>
</div>

