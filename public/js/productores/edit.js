$(document).ready(function() {
    //var route = "http://www.toodrinks.com/pais/paises-destino";
    var route = "http://localhost:8000/pais/paises-destino";
    var checkboxes = document.getElementsByTagName('input');
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            for (var i = 0; i < ans.length; i++ ){
                //obtenemos todos los controles del tipo Input
                for(j = 0; j < checkboxes.length; j++){
                    if(checkboxes[j].type == "checkbox"){
                        if (checkboxes[j].value == ans[i].pais_id) {
                            checkboxes[j].checked = true;
                        } //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
                    }
                }
            }
        }
    });
});

function cargarProvincias() {

    document.getElementById("provincias").innerHTML = "<option value=''>Seleccione una provincia..</option>";
    
    var pais = document.getElementById('pais_id').value;
    //var route = "http://www.toodrinks.com/pais/"+pais+"";
    var route = "http://localhost:8000/pais/"+pais+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            for (var i = 0; i < ans.length; i++ ){
                document.getElementById("provincias").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].provincia+"</option>";
            }
        }
    });
}

