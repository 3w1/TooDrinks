function cargarProvincias() {
	var opcion = document.getElementById("opciones").value;

	if (opcion == "P"){
		document.getElementById("estados").innerHTML = "";
			
		var id = document.getElementById('pais_id').value;
		var urls = "http://localhost:8000/pais/"+id+"";
		var token = document.getElementById('token').value;
			    
		$.ajax({
	        url:urls,
			headers: {'X-CSRF-TOKEN': token},
			type:'GET',
			success:function(ans){
			    for (var i = 0; i < ans.length; i++ ){
					document.getElementById("estados").innerHTML += "<label class='checkbox-inline'><input type='checkbox' name='provincias[]' value='"+ans[i].id +"'>"+ans[i].provincia+"</label>";
		        }
			}
		});
	}else{
		document.getElementById("estados").innerHTML = "";
	}
}