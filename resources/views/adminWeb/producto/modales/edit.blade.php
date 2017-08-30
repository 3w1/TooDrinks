<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Modificar Producto</h4>
         </div>
         <div class="modal-body">

            {!! Html::script('js/productos/edit.js') !!}

            <?php 
               $paises = DB::table('pais')
                          ->orderBy('pais', 'ASC')
                          ->pluck('pais', 'id');

               $bebidas = DB::table('bebida')
                           ->orderBy('nombre')
                           ->pluck('nombre', 'id');
                 
               $clases_bebidas = DB::table('clase_bebida')
                           ->where('bebida_id', '=', $producto->bebida_id)
                           ->orderBy('clase')
                           ->pluck('clase', 'id');
            ?>

            {!! Form::open(['route' => ['admin.producto-update', $producto->id], 'method' => 'PUT']) !!}
     
               {!! Form::hidden('id', $producto->id) !!}
               {!! Form::hidden('marca_id', $producto->marca_id, ['id' => 'marca_hidden']) !!}

               <div class="form-group">
                  {!! Form::label('nombre', 'Nombre (*)') !!}
                  {!! Form::text('nombre', $producto->nombre, ['class' => 'form-control', 'required'] ) !!}
               </div>

               <div class="form-group">
                  {!! Form::label('nombre_seo', 'Nombre Seo') !!}
                  {!! Form::text('nombre_seo', $producto->nombre_seo, ['class' => 'form-control'] ) !!}
               </div>

               <div class="form-group">
                  {!! Form::label('descripcion', 'Descripción') !!}
                  {!! Form::text('descripcion', $producto->descripcion, ['class' => 'form-control'] ) !!}
               </div>

               <div class="form-group">
                  {!! Form::label('pais', 'País (*)') !!}
                  {!! Form::select('pais_id', $paises, $producto->pais_id, ['class' => 'form-control', 'onchange' => 'cargarProvincias();', 'id' => 'pais_id', 'required']) !!}
               </div>

               <div class="form-group">
                  {!! Form::label('bebida', 'Tipo de Bebida (*)') !!}
                  {!! Form::select('bebida_id', $bebidas, $producto->bebida_id, ['class' => 'form-control', 'onchange' => 'cargarClases();', 'id' => 'bebida_id', 'required']) !!}
               </div>

               <div class="form-group">
                  {!! Form::label('clase_bebida', 'Clase de Bebida (*)') !!}
                  {!! Form::select('clase_bebida_id', $clases_bebidas, $producto->clase_bebida_id, ['class' => 'form-control', 'id' => 'clases_bebidas', 'required']) !!}
               </div>
         
               <div class="form-group">
                  {!! Form::label('ano_produccion', 'Año de Producción') !!}
                  {!! Form::text('ano_produccion', $producto->ano_produccion, ['class' => 'form-control'] ) !!}
               </div>      
         </div>
         <div class="modal-footer">
            {!! Form::submit('Modificar Producto', ['class' => 'btn btn-primary']) !!}
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>