function buscarProducto() {
    document.getElementById("alerta").style.display = 'none';
    
    document.getElementById("productos").innerHTML = "";
        
    var nombre = document.getElementById('busqueda').value+".2";
    var route = "http://localhost:8000/producto/"+nombre+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            var cant = ans.length;
            var disponibles = 0;

            if (cant > 0){
                document.getElementById("productos").innerHTML = "<center><h3>Resultados de la Búsqueda</h3></center>";
                for (var i = 0; i < ans.length; i++ ){
                    if (ans[i].id != '0'){
                        if (ans[i].check == '1'){
                            document.getElementById("productos").innerHTML += "<div class='col-md-4 col-md-6 well'><a href='#' onclick='cargarProducto(this.id);' id='"+ans[i].id+"' class='thumbnail'><img src='http://localhost:8000/imagenes/productos/thumbnails/"+ans[i].imagen+"' class='img-responsive'></a> <div class='caption'><h3><center>"+ans[i].nombre+"</center></h3></div> </div>";
                            disponibles++;
                        }
                    }
                }
            }else{
                document.getElementById("productos").innerHTML = "";
                document.getElementById("alerta").style.display = 'block';
                document.getElementById("mensaje").innerHTML = "<strong>Ups!!</strong> No se han encontrado productos disponibles para su importación en la búsqueda. Intente con otro producto o busque un tipo de bebida específico.";
            }

            if (disponibles == 0){
                document.getElementById("productos").innerHTML = "";
                document.getElementById("alerta").style.display = 'block';
                document.getElementById("mensaje").innerHTML = "<strong>Ups!!</strong> No se han encontrado productos disponibles para su importación en la búsqueda. Intente con otro producto o busque un tipo de bebida específico.";
            }
        }
    });
}

function cargarCategorias(){
    var bebida = document.getElementById("bebida").value;
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

function buscarPorClase(){
    document.getElementById("alerta").style.display = 'none';
    
    document.getElementById("productos").innerHTML = "";
        
    var bebida = document.getElementById('bebida').value;
    var clase = document.getElementById('clase').value;

    var route = "http://localhost:8000/producto/productos-por-clase/"+bebida+"/"+clase;
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            var cant = ans.length;

            if (cant > 0){
                document.getElementById("productos").innerHTML = "<center><h3>Resultados de la Búsqueda</h3></center>";
                for (var i = 0; i < ans.length; i++ ){
                    if (ans[i].id != '0'){
                        if (ans[i].check == '1'){
                            document.getElementById("productos").innerHTML += "<div class='col-md-4 col-md-6 well'><a href='#' onclick='cargarProducto(this.id);' id='"+ans[i].id+"' class='thumbnail'><img src='http://localhost:8000/imagenes/productos/thumbnails/"+ans[i].imagen+"' class='img-responsive'></a> <div class='caption'><h3><center>"+ans[i].nombre+"</center></h3></div> </div>";
                            cant = i;
                        }
                    }
                }
            }else{
                document.getElementById("alerta").style.display = 'block';
                document.getElementById("mensaje").innerHTML = "<strong>Ups!!</strong> No se han encontrado productos disponibles para su importación en la búsqueda. Intente con otro producto o busque un tipo de bebida específico.";
            }
        }
    });
}

function buscarPorPais(){
    document.getElementById("alerta").style.display = 'none';
    
    document.getElementById("productos").innerHTML = "";
        
    var bebida = document.getElementById('tipo_bebida').value;
    var pais = document.getElementById('pais').value;

    var route = "http://localhost:8000/producto/productos-por-pais/"+bebida+"/"+pais;
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            var cant = ans.length;

            if (cant > 0){
                document.getElementById("productos").innerHTML = "<center><h3>Resultados de la Búsqueda</h3></center>";
                for (var i = 0; i < ans.length; i++ ){
                    if (ans[i].id != '0'){
                        if (ans[i].check == '1'){
                            document.getElementById("productos").innerHTML += "<div class='col-md-4 col-md-6 well'><a href='#' onclick='cargarProducto(this.id);' id='"+ans[i].id+"' class='thumbnail'><img src='http://localhost:8000/imagenes/productos/thumbnails/"+ans[i].imagen+"' class='img-responsive'></a> <div class='caption'><h3><center>"+ans[i].nombre+"</center></h3></div> </div>";
                            cant = i;
                        }
                    }
                }
            }else{
                document.getElementById("alerta").style.display = 'block';
                document.getElementById("mensaje").innerHTML = "<strong>Ups!!</strong> No se han encontrado productos disponibles para su importación en la búsqueda. Intente con otro producto o busque un tipo de bebida específico.";
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
        