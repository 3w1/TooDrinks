function cargarProvincias() {
	var opcion = document.getElementById("opciones").value;

	if (opcion == "P"){
		document.getElementById("estados").innerHTML = "";
			
		var id = document.getElementById('pais_id').value;
		//var urls = "http://www.toodrinks.com/pais/"+id+"";
		var urls = "http://localhost:8000/pais/"+id+"";
			    
		$.ajax({
	        url:urls,
			type:'GET',
			success:function(ans){
			    for (var i = 0; i < ans.length; i++ ){
					document.getElementById("estados").innerHTML += "<div class='col-md-3'><label class='checkbox-inline'><input type='checkbox' name='provincias[]' value='"+ans[i].id +"'>"+ans[i].provincia+"</label></div>";
		        }
			}
		});
	}else{
		document.getElementById("estados").innerHTML = "";
	}
}