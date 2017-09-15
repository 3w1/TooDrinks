function cargarProvincias(){ 
    document.getElementById("provincias").innerHTML = "<option value=''>Seleccione una provincia..</option>";
     
    var pais = document.getElementById('pais_id').value;
    //var route = "http://www.toodrinks.com/pais/"+pais+"";
	var route = "http://localhost:8000/pais/"+pais+"";
                    
    jQuery.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            for (var i = 0; i < ans.length; i++ ){
                document.getElementById("provincias").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].provincia+"</option>";
            }
        }
    });
}

function validarClave(){
    c1 = document.getElementById("clave1").value;

    if (c1.length < 8){
        document.getElementById("error").innerHTML = "La contraseña debe tener mínimo 8 caracteres.";
        document.getElementById("error").style.display = 'block';
        document.getElementById("boton").disabled = true;
    }
}

function verificarClaves(){
    c1 = document.getElementById("clave1").value;
    c2 = document.getElementById("clave2").value;

    if (c1 != c2){
        document.getElementById("clave1").value = "";
        document.getElementById("clave2").value = "";
        document.getElementById("error").innerHTML = "Las contraseñas que ingresó no coinciden. Por favor, intente de nuevo.";
        document.getElementById("error").style.display = 'block';
        document.getElementById("boton").disabled = true;
    }else{
        document.getElementById("error").style.display = 'none';
        document.getElementById("boton").disabled = false;
    }
}

function verificarCorreo(){ 
    var correo = document.getElementById('email').value;
    
    //var route = "http://www.toodrinks.com/consulta/verificar-correo/"+correo+"";
    var route = "http://localhost:8000/consulta/verificar-correo/"+correo+"";
                    
    jQuery.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            if (ans[0] == '1'){
                document.getElementById("error").innerHTML = "El correo que ingresó ya se encuentra registrado. Por favor, intente con otro correo.";
                document.getElementById("error").style.display = 'block';
                document.getElementById("boton").disabled = true;
            }else{
                document.getElementById("error").style.display = 'none';
                document.getElementById("boton").disabled = false;
            }
        }
    });
}