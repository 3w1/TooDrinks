function cambiar($id){
	var datos = $id.split("-");

    if (datos[0] == 'on'){
        document.getElementById("status").value = "1";
    }else{
        document.getElementById("status").value = "0";
    }

    document.getElementById("id").value = datos[1];

    document.forms['formStatus'].submit();
}