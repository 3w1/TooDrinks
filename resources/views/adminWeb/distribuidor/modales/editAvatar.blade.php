<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Actualizar Avatar</h4>
         </div>
         <div class="modal-body">
            {!! Form::open(['route' => 'admin.distribuidor-update-avatar', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
               {!! Form::hidden('id', $distribuidor->id) !!}
               
               <div class="form-group">
                  {!! Form::label('logo', 'Imagen / Avatar') !!}
                  {!! Form::file('logo', ['class' => 'form-control', 'required'] ) !!}
               </div>
         </div>
         <div class="modal-footer">
            {!! Form::submit('Actualizar Avatar', ['class' => 'btn btn-primary']) !!}
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>

