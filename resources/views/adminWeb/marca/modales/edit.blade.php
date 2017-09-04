<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Modificar Marca</h4>
         </div>
         <div class="modal-body">
            <?php 
               $paises= DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');
            ?>

            {!! Form::open(['route' => ['admin.marca-update', $marca->id], 'method' => 'PUT']) !!}

               <div class="form-group">
                  {!! Form::label ('nombre','Nombre (*)') !!}
                  {!! Form::text ('nombre', $marca->nombre,['class' => 'form-control', 'required']) !!}
               </div>

               <div class="form-group">
                  {!! Form::label ('nombre_seo','Nombre Seo (*)') !!}
                  {!! Form::text ('nombre_seo',$marca->nombre_seo,['class'=>'form-control', 'required']) !!}
               </div>
   
               <div class="form-group">
                  {!! Form::label ('descripcion','Descripción') !!}
                  {!! Form::text ('descripcion',$marca->descripcion,['class'=>'form-control']) !!}
               </div>

               <div class="form-group">
                  {!! Form::label ('pais_id','País (*)') !!}
                  {!! Form::select('pais_id', $paises, $marca->pais_id, ['class' => 'form-control', 'required']) !!}
               </div>

               <div class="form-group">
                  {!! Form::label('website','Website') !!}
                  {!! Form::url('website', $marca->website, ['class'=>'form-control', 'placeholder' => '(http://www.dominio.com)']) !!}
               </div>
         </div>
         <div class="modal-footer">
            {!! Form::submit('Modificar Marca', ['class' => 'btn btn-primary']) !!}
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>