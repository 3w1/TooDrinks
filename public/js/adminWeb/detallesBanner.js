function cargarDetalles($id){
    //var route = "http://www.toodrinks.com/consulta/cargar-detalles-banner/"+$id+"";
    var route = "http://localhost:8000/consulta/cargar-detalles-banner/"+$id+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("detalles").innerHTML = "<li class='active'><a><strong>URL: </strong>"+ans.url_banner+"</a></li>";
            document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>Descripción: </strong>"+ans.descripcion+"</a></li>";
            if (ans.correcciones != null){
                document.getElementById("detalles").innerHTML += "<li class='active'><a><strong>Correcciones Pendientes: </strong>"+ans.correcciones+"</a></li>";
            }
            $("#detallesModal").modal({
                show: 'true'
            });
        }
    });
}