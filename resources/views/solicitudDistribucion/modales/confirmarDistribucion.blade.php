<div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="myModalLabel">Confirmar Solicitud de Distribución</h4>
         </div>
         <div class="modal-body">
            <div class="panel panel-default panel-success" id="infoProducto">
            
            </div>
         </div>
         <div class="modal-footer">
            {!! Form::open(['route' => 'solicitud-distribucion.store', 'method' => 'POST']) !!}
               {!! Form::hidden('distribuidor_id', session('perfilId') ) !!}
               {!! Form::hidden('producto_id', null, ['id' => 'producto_id']) !!}
               {!! Form::hidden('provincia_region_id', session('perfilProvincia') ) !!}
               {!! Form::hidden('status', '1') !!}
               {!! Form::hidden('cantidad_visitas', '0') !!}
               {!! Form::hidden('cantidad_contactos', '0') !!}
               {!! Form::submit("Confirmar", ['class' => 'btn btn-primary'])!!}
            {!! Form::close() !!}
         </div>
      </div>
   </div>
</div>

