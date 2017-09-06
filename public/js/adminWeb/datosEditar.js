function cargarDatos($id){
    //var route = "http://www.toodrinks.com/consulta/cargar-detalles-banner/"+$id+"";
    var route = "http://localhost:8000/consulta/cargar-detalles-banner/"+$id+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
        	document.getElementById("id").value = ans.id;
        	document.getElementById("titulo").value = ans.titulo;
        	document.getElementById("descripcion").value = ans.descripcion;
        	document.getElementById("url").value = ans.url_banner;
           
            $("#editModal").modal({
                show: 'true'
            });
        }
    });
}

function cargarImagen($id){
    document.getElementById("id_banner").value = $id;
           
    $("#imagenModal").modal({
        show: 'true'
    });
}