function cargarOpcion(){
	if (document.getElementById("opcion").value == 'P'){
		document.getElementById("bebidas").style.display = 'none';
		document.getElementById("productos").style.display = 'block';
	}else{
		document.getElementById("productos").style.display = 'none';
		document.getElementById("bebidas").style.display = 'block';
	}
}
