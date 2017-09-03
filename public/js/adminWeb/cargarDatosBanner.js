function cargarDatosBanner($id){
    //var route = "http://www.toodrinks.com/consulta/cargar-datos-banner/"+$id"";
    var route = "http://localhost:8000/consulta/cargar-datos-banner/"+$id+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("banner_id").value = $id;
            document.getElementById("tipo_creador").value = ans.tipo_creador;
            document.getElementById("creador_id").value = ans.creador_id;
           
            $("#publicarModal").modal({
                show: 'true'
            });
        }
    });
}