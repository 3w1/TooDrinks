function cargarCategorias(){
    var bebida = document.getElementById("bebida").value;
    //var route = "http://www.toodrinks.com/bebida/clases/"+bebida+"";
    var route = "http://localhost:8000/bebida/clases/"+bebida;

    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            for (var i = 0; i < ans.length; i++ ){
                document.getElementById("clase").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].clase+"</option>";
            }
        }
    });
}

function cargarProducto($id){

    //var route = "http://www.toodrinks.com/producto/verificar-producto/"+$id+"";
    var route = "http://localhost:8000/producto/verificar-producto/"+$id+"";

    document.getElementById("producto_id").value = $id;

    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("alerta").style.display = 'none';

            document.getElementById("marca_id").value = ans.marca_id;

            document.getElementById("infoProducto").innerHTML = "<div class='panel-heading'><h4><b>Producto: "+ans.nombre+"</b></h4></div><ul class='list-group'>";
            document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Nombre SEO: </b>"+ans.nombre_seo+"</li>";
            document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Descripción: </b>"+ans.descripcion+"</li>";
            document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Tipo de Bebida: </b>"+ans.bebida.nombre+"</li>";
            document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Clase de Bebida: </b>"+ans.clase_bebida.clase+"</li>";
            document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Marca: </b>"+ans.marca.nombre+"</li>";
            document.getElementById("infoProducto").innerHTML += "</ul>";

            if (ans.relacion == '0'){
            	document.getElementById("boton").disabled = false;
            	document.getElementById("alert").style.display = 'none';
            }else{
            	document.getElementById("boton").disabled = true;
            	document.getElementById("alert").innerHTML = "Ya te encuentras asociado con este producto. Para más detalles dirígete a la sección *Mis Productos*.";
            	document.getElementById("alert").style.display = 'block';
            }

            $("#modal").modal({
                show: 'true'
            });
        }
    });
}
        