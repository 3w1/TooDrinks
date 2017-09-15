<?php 
    $od = DB::table('notificacion_h')->select(DB::raw('count(*) as cant'))
            ->where('horeca_id', '=', session('perfilId'))
            ->where('tipo', '=', 'NO')->where('leida', '=', '0')->first();

    $ofertas = $od->cant;
  	
   ?>

<li class="li"><a href="{{ route('horeca.inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>

<li class="li"><a href="{{route('demanda-producto.index')}}"><i class="fa fa-shopping-bag"></i> Comercialización</a></li>

<li class="li">
	<a href="{{route('oferta.disponibles')}}">
		<i class="fa fa-handshake-o"></i> Ofertas
		<span class="pull-right-container">
			<small class="label pull-right bg-orange">{{$ofertas}}</small>
		</span>
	</a>
</li> 

<li class="header">SORTEOS</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Inscrito</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Nuevos Sorteos</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Historial</a></li>

<li class="header">LISTADOS</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>

      