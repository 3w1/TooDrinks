function cargarEntidades(){
	var tipo = document.getElementById('tipo_entidad').value;
	var route = "http://localhost:8000/consulta/cargar-entidades/"+tipo+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
        	document.getElementById("entidad_id").innerHTML = "<option value=''>Seleccione una opción...</option>";
        	document.getElementById('entidad_id').disabled = false;
        	for (var i = 0; i < ans.length; i++ ){
                document.getElementById("entidad_id").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].nombre+"</option>";
            }    
        }
    });
}