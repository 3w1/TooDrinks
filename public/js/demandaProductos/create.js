function cargarOpcion(){
	if (document.getElementById("opcion").value == 'P'){
		document.getElementById("bebidas").style.display = 'none';
		document.getElementById("productos").style.display = 'block';
	}else{
		document.getElementById("productos").style.display = 'none';
		document.getElementById("bebidas").style.display = 'block';
	}
}

function cargarProvincias() {

    var pais = document.getElementById('pais_id').value;
    //var route = "http://www.toodrinks.com/pais/"+pais+"";
	var route = "http://localhost:8000/pais/"+pais+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("provincias").innerHTML = "<option value=''>Seleccione una provincia..</option>";
            document.getElementById("provincias").disabled = false;
            for (var i = 0; i < ans.length; i++ ){
                document.getElementById("provincias").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].provincia+"</option>";
            }
        }
    });
}