function consultarDisponibilidad(){
	var pais = document.getElementById("pais").value;
	var semanas = document.getElementById("semanas").value;

    //var route = "http://www.toodrinks.com/consulta/consultar-fechas-banner/"+pais+"/"+semanas;
	var route = "http://localhost:8000/consulta/consultar-fechas-banner/"+pais+"/"+semanas;
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("fechas").innerHTML = "Su banner estará disponible para mostrarse desde el <strong> Lunes "+ans[0]+"</strong> hasta el <strong> Domingo "+ans[1]+"</strong>. Si está de acuerdo presione el botón <strong>Continuar</strong> para concretar la publicación de su banner.";
            document.getElementById("fecha_inicio").value = ans[0];
            document.getElementById("fecha_fin").value = ans[1];
            document.getElementById("precio").value = '50';
        	document.getElementById("fechas").style.display = 'block';
        	document.getElementById("boton").style.display = 'block';
        }
    });
}

function resetTiempo(){
    var select = document.getElementById("semanas");
    for (var j = 0, l = select.length; j < l; j++) {
        if (select[j].value == ''){
            select[j].selected = true;
        }
    }

    document.getElementById("fechas").style.display = 'none';
}