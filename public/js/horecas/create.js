function cargarProvincias() {

    document.getElementById("provincias").innerHTML = "<option value=''>Seleccione una provincia..</option>";
        
    var pais = document.getElementById('pais_id').value;
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