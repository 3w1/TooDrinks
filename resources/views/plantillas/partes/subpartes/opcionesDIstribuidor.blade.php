<?php 
    $dp = DB::table('notificacion_d')->select(DB::raw('count(*) as cant'))
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DP')->where('leida', '=', '0')->first();

    $db = DB::table('notificacion_d')->select(DB::raw('count(*) as cant'))
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DB')->where('leida', '=', '0')->first();

    $dd = DB::table('notificacion_d')->select(DB::raw('count(*) as cant'))
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DD')->where('leida', '=', '0')->first();
      
    $solicitudes = $dp->cant + $db->cant + $dd->cant;

    $od = DB::table('notificacion_d')->select(DB::raw('count(*) as cant'))
            ->where('distribuidor_id', '=', session('perfilId'))
            ->where('tipo', '=', 'NO')->where('leida', '=', '0')->first();

    $ofertas = $od->cant;
   ?>
?>

<li class="li"><a href="{{ route('distribuidor.inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>

<li class="li"><a href="{{route('marca.index')}}"><i class="fa fa-diamond"></i> Marcas</a></li>

<li class="li"><a href="{{route('producto.index')}}"><i class="fa fa-product-hunt"></i> Productos</a>

<li class="li">
	<a href="{{route('oferta.index')}}">
		<i class="fa fa-handshake-o"></i> Mercado
		<span class="pull-right-container">
			<small class="label pull-right bg-blue">{{$ofertas}}</small>
		</span>
	</a>
</li> 

<li class="li"><a href="{{route('solicitud-distribucion.index')}}"><i class="fa fa-hand-o-up"></i> Distribución</a></li>   

<li class="li">
	<a href="{{route('demanda-producto.demandas-productos-disponibles')}}">
		<i class="fa fa-handshake-o"></i> Solicitudes
		<span class="pull-right-container">
			<small class="label pull-right bg-orange">{{$solicitudes}}</small>
		</span>
	</a>
</li>  

<li class="header">LISTADOS</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Mis Productores</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Mis Importadores</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Mis Horecas</a></li>
      