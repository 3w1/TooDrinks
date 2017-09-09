function mostrarDatos($id){
    //var route = "http://www.toodrinks.com/consulta/datos-distribuidor/"+$id+"";
    var route = "http://localhost:8000/consulta/datos-distribuidor/"+$id+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
        	document.getElementById("datosDistribuidor").innerHTML = "<div class='panel-heading'><h4><b>Importador: "+ans.nombre+"</b></h4></div><ul class='list-group'>";
            document.getElementById("datosDistribuidor").innerHTML += "<li class='list-group-item'><b>Nombre SEO: </b>"+ans.nombre_seo+"</li>";
            document.getElementById("datosDistribuidor").innerHTML += "<li class='list-group-item'><b>Descripción: </b>"+ans.descripcion+"</li>";
            document.getElementById("datosDistribuidor").innerHTML += "<li class='list-group-item'><b>Dirección: </b>"+ans.direccion+"</li>";
            document.getElementById("datosDistribuidor").innerHTML += "<li class='list-group-item'><b>Persona de Contacto: </b>"+ans.persona_contacto+"</li>";
            document.getElementById("datosDistribuidor").innerHTML += "</ul>";

            $("#modal").modal({
                show: 'true'
            });
        }
    });
}