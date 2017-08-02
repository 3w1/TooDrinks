function activarCosto(){
	var opc = document.getElementById("envio").value;

	if (opc == '0'){
		document.getElementById("costo").disabled = true;
	}else{
		document.getElementById("costo").disabled = false;
	}
}