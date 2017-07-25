function cargarDetalles($tipo, $id){
    var route = "http://localhost:8000/credito/detalles-gasto/"+$tipo+"/"+$id;
                    
   $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
        	document.getElementById("marca_id").value = $id;
            document.getElementById("descripcion").innerHTML = "<li class='active'><a><strong>Descripción: </strong>"+ans.descripcion+"</a></li>";
            if (ans.website == null){
            	document.getElementById("descripcion").innerHTML += "<li class='active'><a><strong>Sitio Web: </strong> No Posee";
            }else{
            	document.getElementById("descripcion").innerHTML += "<li class='active'><a><strong>Sitio Web: </strong>"+ans.website+"</a></li>";
            }
            $("#descripcionModal").modal({
                show: 'true'
            });
        }
    });
}