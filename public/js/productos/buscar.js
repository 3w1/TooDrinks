function buscarProducto() {
    document.getElementById("productos").innerHTML = "";
        
    var nombre = document.getElementById('busqueda').value+".2";
    var route = "http://localhost:8000/producto/"+nombre+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            for (var i = 0; i < ans.length; i++ ){
                if (ans[i].id != '0'){
                    document.getElementById("productos").innerHTML += "<div class='col-md-4 col-md-6 well'><a href='#' onclick='cargarProducto(this.id);' id='"+ans[i].id+"' class='thumbnail'><img src='http://localhost:8000/imagenes/productos/thumbnails/"+ans[i].imagen+"' class='img-responsive'></a> <div class='caption'><h3><center>"+ans[i].nombre+"</center></h3></div> </div>";
                }
            }
        }
    });
}

function cargarProducto($id){

    var route = "http://localhost:8000/producto/verificar-producto/"+$id+"";

    document.getElementById("producto_id").value = $id;

    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            console.log(ans);
            if (ans.check == '1'){
                document.getElementById("infoProducto").innerHTML = "<div class='panel-heading'><h4><b>Producto: "+ans.nombre+"</b></h4></div><ul class='list-group'>";
                document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Nombre SEO: </b>"+ans.nombre_seo+"</li>";
                document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Descripción: </b>"+ans.descripcion+"</li>";
                document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Tipo de Bebida: </b>"+ans.bebida.nombre+"</li>";
                document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Clase de Bebida: </b>"+ans.clase_bebida.clase+"</li>";
                document.getElementById("infoProducto").innerHTML += "<li class='list-group-item'><b>Marca: </b>"+ans.marca.nombre+"</li>";
                document.getElementById("infoProducto").innerHTML += "</ul>";

                $("#modalConfirmar").modal({
                    show: 'true'
                });
            }else{
                document.getElementById("alerta").style.display = 'block';
                document.getElementById("mensaje").innerHTML = "<strong>Ups!!</strong> No puede solicitar la importación del producto "+ans.nombre+" porque el productor no ha marcado su país como posible destino laboral.";
            }
        }
    });
}
        