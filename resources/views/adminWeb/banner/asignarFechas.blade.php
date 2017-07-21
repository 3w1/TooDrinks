@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Banners')

<style>
   .checkeable input {
      display: none;
   }
   .checkeable img {
     border: 5px solid transparent;
   }
   .checkeable input {
     display: none;
   }
   .checkeable input:checked  + img {
     border-color: green;
   }
</style>

@section('title-header')
   Asignar Fechas 
@endsection

@section('title-complement')
   (Calendario para {{$solicitud->pais->pais}})
@endsection

@section('content-left')
	<table class="table table-bordered">
		<thead>
			<tr>
				<td colspan="7"><center><b><?php echo strftime( '%B %Y', strtotime( $month ) ); ?></b></center></td>
			</tr>
			<tr>
				<td>Lunes</td>
				<td>Martes</td>			
				<td>Miércoles</td>			
				<td>Jueves</td>			
				<td>Viernes</td>			
				<td>Sábado</td>			
				<td>Domingo</td>				
			</tr>
		</thead>
		<tbody>
			{!! Form::open(['route' => 'admin.guardar-fechas', 'method' => 'POST']) !!}
				{!! Form::hidden('solicitud_id', $solicitud->id) !!}
			@foreach ( $calendar as $days )
				<tr>	
					@for ( $i=1;$i<=7;$i++ )
						<td>
							@if (isset($days[$i]))
								<?php 
									$fecha = explode("-", $days[$i]); 
									$fecha_actual = $days[$i];

									$registro = DB::table('banner_diario')
												->select('fecha')
												->where('pais_id', '=', $solicitud->pais_id)
												->where('fecha', '=', $fecha_actual)
												->first();
								?>
								@if ($registro == null) 
									<label class="checkeable">
                        				<input type="checkbox" name="fechas[]" value="{{$days[$i]}}" />
                        				<img src="{{ asset('imagenes/celda.jpg') }}" class="img-responsive">{{$fecha[2]}}
                    				</label>
                    			@else 
                    				<label>
                    					<img src="{{ asset('imagenes/celdaLock.jpg') }}" class="img-responsive">{{$fecha[2]}}
                    				</label>
                    			@endif
                    		@else 
                    			{{''}}
                    		@endif
						</td>
					<?php endfor; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	{!! Form::submit('Guardar Fechas', ['class' => 'btn btn-primary pull-right'])!!}
	{!! Form::close() !!}
@endsection