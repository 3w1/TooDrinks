function cargarDescripcion($id){
    //var route = "http://www.toodrinks.com/consulta/cargar-descripcion-marca/"+$id+"";
    var route = "http://localhost:8000/consulta/cargar-descripcion-marca/"+$id+"";
                    
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