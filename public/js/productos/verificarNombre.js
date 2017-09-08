function verificarNombre(){
    var nombre = document.getElementById('nombre').value
    var id_producto = document.getElementById('id_producto').value

    var route = "http://localhost:8000/consulta/verificar-nombre-producto/"+nombre+"/"+id_producto+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            if (ans.cant == '0'){
                document.getElementById('errorNombre').style.display = 'none';
                document.getElementById("boton").disabled = false;
            }else{
                document.getElementById('errorNombre').style.display = 'block';
                document.getElementById("boton").disabled = true;
            } 
        }

    });
}