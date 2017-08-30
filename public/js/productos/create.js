function cargarClases() {
        
    var bebida = document.getElementById('bebida_id').value;
    //var route = "http://www.toodrinks.com/consulta/cargar-clases-bebida/"+bebida+"";
    var route = "http://localhost:8000/consulta/cargar-clases-bebida/"+bebida+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("clases_bebidas").disabled = false;
            document.getElementById("clases_bebidas").innerHTML = "<option value=''>Seleccione una clase..</option>";
            for (var i = 0; i < ans.length; i++ ){
                document.getElementById("clases_bebidas").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].clase+"</option>";
            }
        }
    });
}