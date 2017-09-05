function consultarFechasBanner(){
	var pais = document.getElementById("pais").value;
	var semanas = document.getElementById("semanas").value;

    //var route = "http://www.toodrinks.com/consulta/consultar-fechas-banner/"+pais+"/"+semanas;
	var route = "http://localhost:8000/consulta/consultar-fechas-banner/"+pais+"/"+semanas;
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("fechas").innerHTML = "El banner estará disponible para mostrarse desde el <strong> Lunes "+ans[0]+"</strong> hasta el <strong> Domingo "+ans[1]+"</strong>.";
            document.getElementById("fecha_inicio").value = ans[0];
            document.getElementById("fecha_fin").value = ans[1];
            document.getElementById("precio").style.display = 'block';
        	document.getElementById("fechas").style.display = 'block';
        }
    });
}