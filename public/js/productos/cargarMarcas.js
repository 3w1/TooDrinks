function cargarMarcas($id){
	var productor = document.getElementById("productor").value;

	var route = "http://localhost:8000/consulta/cargar-marcas/"+productor+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("producto_id").value = $id;
            document.getElementById("marcas").innerHTML = "<option value=''>Seleccione una marca..</option>";
            for (var i = 0; i < ans.length; i++ ){
                document.getElementById("marcas").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].nombre+"</option>";
            }

            $("#listadoModal").modal({
		        show: 'true'
		    });
        }
    });
}