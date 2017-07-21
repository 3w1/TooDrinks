function cargarDetalles($id){
    var route = "http://localhost:8000/banner-publicitario/detalles/"+$id+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("banner_id").value = $id;
            document.getElementById("detalles").innerHTML = "<li class='active'><a><strong>Título: </strong>"+ans.titulo+"</a></li>";
            document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>Descripción : </strong>"+ans.descripcion+"</a></li>";
            document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>URL Destino: </strong>"+ans.url_banner+"</a></li>";
            document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>Creador: </strong>"+ans.creador+"</a></li>";

            $("#detalleModal").modal({
                show: 'true'
            });
        }
    });
}