function cargarModal($id){
    document.getElementById("marca_id").value = $id;
    $("#asociarModal").modal({
            show: 'true'
    });
}

function buscarProductor() {
    
    document.getElementById("productores").innerHTML = "";
    var productor = document.getElementById('busqueda').value+"";
    //var route = "http://www.toodrinks.com/productor/"+productor+"";;
    var route = "http://localhost:8000/productor/"+productor+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            for (var i = 0; i < ans.length; i++ ){
                if (ans[i].id != '0'){   
                    document.getElementById("productores").innerHTML += "<div class='col-md-4'><div class='input-group input-group-md'><span class='input-group-addon'><input type='radio' name='productor_id' value='"+ans[i].id+"'></span><input type='text' class='form-control' value='"+ans[i].nombre+"' disabled></div></div> ";
                }
            }
        }
    });
}