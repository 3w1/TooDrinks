function cargarProvincias() {
	var opcion = document.getElementById("opciones").value;

	if (opcion == "P"){
		document.getElementById("estados").innerHTML = "";
			
		var id = document.getElementById('pais_id').value;
		//var urls = "http://www.toodrinks.com/consulta/cargar-provincias/"+id+"";
		var urls = "http://localhost:8000/consulta/cargar-provincias/"+id+"";
			    
		$.ajax({
	        url:urls,
			type:'GET',
			success:function(ans){
			    for (var i = 0; i < ans.length; i++ ){
					document.getElementById("estados").innerHTML += "<div class='col-md-3'><label class='checkbox-inline'><input type='checkbox' name='provincias[]' value='"+ans[i].id +"'>"+ans[i].provincia+"</label></div>";
		        }
			}
		});
	}else{
		document.getElementById("estados").innerHTML = "";
	}
}

function cargarProductos() {

    var marca = document.getElementById('marca').value+".1";
    //var route = "http://www.toodrinks.com/producto/"+marca+"";
	var route = "http://localhost:8000/producto/"+marca+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
        	document.getElementById("productos").innerHTML = "<option value=''>Seleccione un producto..</option>";
     		document.getElementById("productos").disabled = false;
        	console.log(ans[0]);
            for (var i = 0; i < ans.length; i++ ){

                document.getElementById("productos").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].nombre+"</option>";
            }
        }
    });
}

function activarCosto(){
	var opc = document.getElementById("envio").value;

	if (opc == '0'){
		document.getElementById("costo").disabled = true;
	}else{
		document.getElementById("costo").disabled = false;
	}
}