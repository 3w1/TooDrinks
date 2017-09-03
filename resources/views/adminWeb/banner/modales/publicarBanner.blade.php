<?php 
   $paises = DB::table('pais')
            ->orderBy('pais', 'ASC')
            ->pluck('pais', 'id');
 ?>

<div class="modal fade" id="publicarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Publicar Banner</h4>
         </div>
         <div class="modal-body">
            {!! Form::open(['route' => 'admin.guardar-publicacion', 'method' => 'POST']) !!}
               {!! Form::hidden('banner_id', null, ['class' => 'form-control', 'id' => 'banner_id'])!!}
               {!! Form::hidden('tipo_creador', null, ['class' => 'form-control', 'id' => 'tipo_creador'])!!}
               {!! Form::hidden('creador_id', null, ['class' => 'form-control', 'id' => 'creador_id'])!!}
               {!! Form::hidden('fecha_inicio', null, ['class' => 'form-control', 'id' => 'fecha_inicio'])!!}
               {!! Form::hidden('fecha_fin', null, ['class' => 'form-control', 'id' => 'fecha_fin'])!!}

               <div class="form-group">   
                  {!! Form::label('pais', 'País Destino')!!}
                  {!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una país...', 'id' => 'pais']) !!}
               </div>      

               <div class="form-group">   
                  {!! Form::label('tiempo', 'Tiempo de Publicación (Semanas)')!!}
                  {!! Form::select('tiempo_publicacion', ['1' => '1 Semana', '2' => '2 Semanas', '3' => '3 Semanas', '4' => '4 Semanas'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción..', 'id' => 'semanas', 'onchange' => 'consultarFechasBanner();']) !!}
               </div>

               <div class="alert alert-success" id="fechas" style="display: none;"></div>

               <div class="form-group" id="precio" style="display: none;">   
                  {!! Form::label('precio', 'Costo en Créditos')!!}
                  {!! Form::number('precio', null, ['class' => 'form-control']) !!}
               </div>
         </div>
         <div class="modal-footer">
            {!! Form::button('Cerrar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
            {!! Form::submit('Publicar', ['class' => 'btn btn-primary']) !!}
         </div>
         {!! Form::close()!!}
      </div>
   </div>
</div>

