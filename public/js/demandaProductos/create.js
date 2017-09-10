function cargarModalProducto($id){
	document.getElementById("producto_id").value= $id;

	$("#modalProducto").modal({
        show: 'true'
    });
}

function cargarModalBebida($bebida_id, $pais_id){
	document.getElementById("bebida_id").value = $bebida_id;

	if ($pais_id != '0'){
		document.getElementById("pais_id").value = $pais_id;
	}

	$("#modalBebida").modal({
        show: 'true'
    });
}
