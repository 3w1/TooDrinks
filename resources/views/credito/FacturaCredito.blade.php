<center><strong>FACTURA DE COMPRA DE PLAN DE CRÉDITO</strong></center><br>

<b>Fecha de la Compra: </b>{{ date('d-m-Y', strtotime($compra->fecha_compra)) }}<br>
<b>Plan Comprado: </b>{{$compra->plan}}<br>
<b>Cantidad de Créditos: </b>{{$compra->cantidad_creditos}}<br>
<b>Descripción: </b>{{$compra->descripcion}}<br>
<b>Total Pagado: </b>{{$compra->total}} $<br>


