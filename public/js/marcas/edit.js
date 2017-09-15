function verificarNombre(){
	var nombre = document.getElementById('nombre').value
	var id_marca = document.getElementById('id_marca').value

	//var route = "http://www.toodrinks.com/consulta/verificar-nombre-marca/"+nombre+"/"+id_marca+"";
    var route = "http://localhost:8000/consulta/verificar-nombre-marca/"+nombre+"/"+id_marca+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
        	if (ans.cant == '0'){
        		document.getElementById('errorNombre').style.display = 'none';
        		document.editForm.submit();
        	}else{
        		document.getElementById('errorNombre').style.display = 'block';
        	} 
        }

    });
}