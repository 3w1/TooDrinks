<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="myModalLabel">Detalles de la Marca</h4>
         </div>
         <div class="modal-body">
            <div class="panel panel-default panel-success" id="infoMarca">
            
            </div>
            <span class="alert alert-warning" id="alert" style="display: none;"></span>
         </div>
         <div class="modal-footer">
            <div class="col-md-6" id="asociar">
               @if (session('perfilTipo') == 'I')
                  {!! Form::open(['route' => ['importador.asociar-marca', 0], 'method' => 'GET']) !!}
                     {!! Form::hidden('marca_id2', null, ['id' => 'marca_id2']) !!}
                     {!! Form::submit("¡La Importo!", ['class' => 'btn btn-primary pull-right'])!!}
                  {!! Form::close() !!}
               @elseif (session('perfilTipo') == 'D')
                  {!! Form::open(['route' => ['distribuidor.asociar-marca', 0], 'method' => 'GET']) !!}
                     {!! Form::hidden('marca_id2', null, ['id' => 'marca_id2']) !!}
                     {!! Form::submit("¡La Distribuyo!", ['class' => 'btn btn-primary pull-right'])!!}
                  {!! Form::close() !!}
               @endif
            </div>
            <div class="col-md-6" id="solicitar">
               @if (session('perfilTipo') == 'I')
                  {!! Form::open(['route' => 'solicitud-importacion.store', 'method' => 'POST']) !!}
                     {!! Form::hidden('importador_id', session('perfilId') ) !!}
                     {!! Form::hidden('producto_id', 0, ['id' => 'producto_id']) !!}
                     {!! Form::hidden('marca_id', null, ['id' => 'marca_id']) !!}
                     {!! Form::hidden('pais_id', session('perfilPais') ) !!}
                     {!! Form::hidden('status', '1') !!}
                     {!! Form::hidden('cantidad_visitas', '0') !!}
                     {!! Form::hidden('cantidad_contactos', '0') !!}
                     {!! Form::submit("¡Quiero Importarla!", ['class' => 'btn btn-success pull-left'])!!}
                  {!! Form::close() !!}
               @elseif (session('perfilTipo') == 'D')
                  {!! Form::open(['route' => 'solicitud-distribucion.store', 'method' => 'POST']) !!}
                     {!! Form::hidden('distribuidor_id', session('perfilId') ) !!}
                     {!! Form::hidden('producto_id', 0, ['id' => 'producto_id']) !!}
                     {!! Form::hidden('marca_id', null, ['id' => 'marca_id']) !!}
                     {!! Form::hidden('provincia_region_id', session('perfilProvincia') ) !!}
                     {!! Form::hidden('status', '1') !!}
                     {!! Form::hidden('cantidad_visitas', '0') !!}
                     {!! Form::hidden('cantidad_contactos', '0') !!}
                     {!! Form::submit("¡Quiero Distribuirla!", ['class' => 'btn btn-success pull-left'])!!}
                  {!! Form::close() !!}
               @endif
                  
            </div>
         </div>
      </div>
   </div>
</div>

