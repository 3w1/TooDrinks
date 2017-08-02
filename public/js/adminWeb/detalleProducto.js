function cargarDetalles($id){
    //var route = "http://www.toodrinks.com/producto/detalle-de-producto/"+$id+"";
    var route = "http://localhost:8000/producto/detalle-de-producto/"+$id+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("nombre").innerHTML = "<strong>"+ans.nombre+"</strong>";
        	document.getElementById("producto_id").value = $id;
            document.getElementById("detalles").innerHTML = "<li class='active'><a><strong>Nombre SEO: </strong>"+ans.nombre_seo+"</a></li>";
            document.getElementById("detalles").innerHTML = "<li class='active'><a><strong>Bebida : </strong>"+ans.bebida.nombre+" ("+ans.clase_bebida.clase+")</a></li>";
            document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>Origen: </strong>"+ans.pais.pais+" ("+ans.provincia_region.provincia+") </a></li>";
            document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>Marca: </strong>"+ans.marca.nombre+"</a></li>";
            document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>Año de Producción: </strong>"+ans.ano_produccion+"</a></li>";
            document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>Descripción: </strong>"+ans.descripcion+"</a></li>";

            $("#detalleModal").modal({
                show: 'true'
            });
        }
    });
}