function modificarComentario(){
	document.getElementById("info").style.display = 'none';
	document.getElementById("comentarioPerfil").disabled = false;
	document.getElementById("comentarioPerfil").focus();
	document.getElementById("valoracionOculta").style.display = 'block';
	document.getElementById("btnOculto").style.display = 'block';

	var valor = document.getElementById("valoracion2").value;

	if ( valor == '1'){
		document.getElementById("1.u").style.color = 'orange';
		document.getElementById("2.u").style.color = 'black';
		document.getElementById("3.u").style.color = 'black';
		document.getElementById("4.u").style.color = 'black';
		document.getElementById("5.u").style.color = 'black';
	}else{
		if (valor == '2'){
			document.getElementById("1.u").style.color = 'orange';
			document.getElementById("2.u").style.color = 'orange';
			document.getElementById("3.u").style.color = 'black';
			document.getElementById("4.u").style.color = 'black';
			document.getElementById("5.u").style.color = 'black';
		}else{
			if (valor == '3'){
				document.getElementById("1.u").style.color = 'orange';
				document.getElementById("2.u").style.color = 'orange';
				document.getElementById("3.u").style.color = 'orange';
				document.getElementById("4.u").style.color = 'black';
				document.getElementById("5.u").style.color = 'black';
			}else{
				if (valor == '4'){
					document.getElementById("1.u").style.color = 'orange';
					document.getElementById("2.u").style.color = 'orange';
					document.getElementById("3.u").style.color = 'orange';
					document.getElementById("4.u").style.color = 'orange';
					document.getElementById("5.u").style.color = 'black';
				}else{
					if (valor == '5'){
						document.getElementById("1.u").style.color = 'orange';
						document.getElementById("2.u").style.color = 'orange';
						document.getElementById("3.u").style.color = 'orange';
						document.getElementById("4.u").style.color = 'orange';
						document.getElementById("5.u").style.color = 'orange';
					}
				}
			}
		}
	}
}

function modificarValoracion($id){
	var id = $id.split(".");

	var valor = id[0];

	if ( valor == '1'){
		document.getElementById("1.u").style.color = 'orange';
		document.getElementById("2.u").style.color = 'black';
		document.getElementById("3.u").style.color = 'black';
		document.getElementById("4.u").style.color = 'black';
		document.getElementById("5.u").style.color = 'black';
	}else{
		if (valor == '2'){
			document.getElementById("1.u").style.color = 'orange';
			document.getElementById("2.u").style.color = 'orange';
			document.getElementById("3.u").style.color = 'black';
			document.getElementById("4.u").style.color = 'black';
			document.getElementById("5.u").style.color = 'black';
		}else{
			if (valor == '3'){
				document.getElementById("1.u").style.color = 'orange';
				document.getElementById("2.u").style.color = 'orange';
				document.getElementById("3.u").style.color = 'orange';
				document.getElementById("4.u").style.color = 'black';
				document.getElementById("5.u").style.color = 'black';
			}else{
				if (valor == '4'){
					document.getElementById("1.u").style.color = 'orange';
					document.getElementById("2.u").style.color = 'orange';
					document.getElementById("3.u").style.color = 'orange';
					document.getElementById("4.u").style.color = 'orange';
					document.getElementById("5.u").style.color = 'black';
				}else{
					if (valor == '5'){
						document.getElementById("1.u").style.color = 'orange';
						document.getElementById("2.u").style.color = 'orange';
						document.getElementById("3.u").style.color = 'orange';
						document.getElementById("4.u").style.color = 'orange';
						document.getElementById("5.u").style.color = 'orange';
					}
				}
			}
		}
	}

	document.getElementById("valoracion2").value = valor;
	document.getElementById("comentarioPerfil").focus();
}

function valorar($id){
	var valor = $id;

	if ( valor == '1'){
		document.getElementById("1").style.color = 'orange';
		document.getElementById("2").style.color = 'black';
		document.getElementById("3").style.color = 'black';
		document.getElementById("4").style.color = 'black';
		document.getElementById("5").style.color = 'black';
	}else{
		if (valor == '2'){
			document.getElementById("1").style.color = 'orange';
			document.getElementById("2").style.color = 'orange';
			document.getElementById("3").style.color = 'black';
			document.getElementById("4").style.color = 'black';
			document.getElementById("5").style.color = 'black';
		}else{
			if (valor == '3'){
				document.getElementById("1").style.color = 'orange';
				document.getElementById("2").style.color = 'orange';
				document.getElementById("3").style.color = 'orange';
				document.getElementById("4").style.color = 'black';
				document.getElementById("5").style.color = 'black';
			}else{
				if (valor == '4'){
					document.getElementById("1").style.color = 'orange';
					document.getElementById("2").style.color = 'orange';
					document.getElementById("3").style.color = 'orange';
					document.getElementById("4").style.color = 'orange';
					document.getElementById("5").style.color = 'black';
				}else{
					if (valor == '5'){
						document.getElementById("1").style.color = 'orange';
						document.getElementById("2").style.color = 'orange';
						document.getElementById("3").style.color = 'orange';
						document.getElementById("4").style.color = 'orange';
						document.getElementById("5").style.color = 'orange';
					}
				}
			}
		}
	}
	document.getElementById("valoracion1").value = valor;
}