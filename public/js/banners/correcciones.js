function cargarCorrecciones($id) {
    //var route = "http://www.toodrinks.com/banner-publicitario/cargar-correcciones/"+$id+"";
    var route = "http://localhost:8000/banner-publicitario/cargar-correcciones/"+$id+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("correcciones").innerHTML = ans.correcciones;
            document.getElementById("enlace").href = ans.banner_id;

            $("#myModal").modal({
                show: 'true'
            });
        }
    });
}