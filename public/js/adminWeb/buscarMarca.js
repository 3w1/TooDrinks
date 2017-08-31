function cargarModal($id){
    document.getElementById("producto_id").value = $id;
    $("#asociarModal").modal({
        show: 'true'
    });
}

function buscarMarca() {
    
    document.getElementById("marcas").innerHTML = "";
    var marca = document.getElementById('busqueda').value+"";
    //var route = "http://www.toodrinks.com/consulta/buscar-marca/"+marca+"";;
    var route = "http://localhost:8000/consulta/buscar-marca/"+marca+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            for (var i = 0; i < ans.length; i++ ){
                if (ans[i].id != '0'){   
                    document.getElementById("marcas").innerHTML += "<div class='col-md-4'><div class='input-group input-group-md'><span class='input-group-addon'><input type='radio' name='marca_id' value='"+ans[i].id+"'></span><input type='text' class='form-control' value='"+ans[i].nombre+"' disabled></div></div> ";
                }
            }
        }
    });
}