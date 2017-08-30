function buscarMarca() {
    document.getElementById("alerta").style.display = 'none';
    
    document.getElementById("marcas").innerHTML = "";
        
    var nombre = document.getElementById('busqueda').value;
    //var route = "http://www.toodrinks.com/marca/buscar-por-nombre/"+nombre+"";
    var route = "http://localhost:8000/buscar-marca-por-nombre/"+nombre+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            var cant = ans.length;

            if (cant > 0){
                document.getElementById("marcas").innerHTML = "<center><h3>Resultados de la Búsqueda</h3></center>";
                for (var i = 0; i < ans.length; i++ ){
                    if (ans[i].id != '0'){
                        document.getElementById("marcas").innerHTML += "<div class='col-md-4 col-md-6 well'><a class='thumbnail'><img src='http://localhost:8000/imagenes/marcas/thumbnails/"+ans[i].logo+"' class='img-responsive'></a> <div class='caption'><h3><center>"+ans[i].nombre+"</center></h3> <center><a class='btn btn-success btn-xs' onclick='cargarMarca(this.id);' id='"+ans[i].id+"'>Ver Detalles</a></center></div> </div>";
                    }
                }
            }else{
                document.getElementById("alerta").style.display = 'block';
                document.getElementById("mensaje").innerHTML = "<strong>Ups!!</strong> No se han encontrado resultados en la búsqueda con el filtro especificado.";
            }
        }
    });
}

function buscarPorProductor() {
    document.getElementById("alerta").style.display = 'none';
    
    document.getElementById("marcas").innerHTML = "";
        
    var productor = document.getElementById('productor').value;
    //var route = "http://www.toodrinks.com/marca/buscar-por-productos/"+productor+"";
    var route = "http://localhost:8000/buscar-marca-por-productor/"+productor;
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            var cant = ans.length;

            if (cant > 0){
                document.getElementById("marcas").innerHTML = "<center><h3>Resultados de la Búsqueda</h3></center>";
                for (var i = 0; i < ans.length; i++ ){
                    if (ans[i].id != '0'){
                        document.getElementById("marcas").innerHTML += "<div class='col-md-4 col-md-6 well'><a class='thumbnail'><img src='http://localhost:8000/imagenes/marcas/thumbnails/"+ans[i].logo+"' class='img-responsive'></a> <div class='caption'><h3><center>"+ans[i].nombre+"</center></h3> <center><a class='btn btn-success btn-xs' onclick='cargarMarca(this.id);' id='"+ans[i].id+"'>Ver Detalles</a></center></div></div> ";
                    }
                }
            }else{
                document.getElementById("alerta").style.display = 'block';
                document.getElementById("mensaje").innerHTML = "<strong>Ups!!</strong> No se han encontrado resultados en la búsqueda. Intente con otro nombre o utilice los filtros para la búsqueda específica.";
            }
        }
    });
}

function buscarPorPais() {
    document.getElementById("alerta").style.display = 'none';
    
    document.getElementById("marcas").innerHTML = "";
        
    var pais = document.getElementById('pais').value;
    //var route = "http://www.toodrinks.com/marca/buscar-por-pais/"+pais+"";
    var route = "http://localhost:8000/buscar-marca-por-pais/"+pais;
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            var cant = ans.length;

            if (cant > 0){
                document.getElementById("marcas").innerHTML = "<center><h3>Resultados de la Búsqueda</h3></center>";
                for (var i = 0; i < ans.length; i++ ){
                    if (ans[i].id != '0'){
                        document.getElementById("marcas").innerHTML += "<div class='col-md-4 col-md-6 well'><a class='thumbnail'><img src='http://localhost:8000/imagenes/marcas/thumbnails/"+ans[i].logo+"' class='img-responsive'></a> <div class='caption'><h3><center>"+ans[i].nombre+"</center></h3> <center><a class='btn btn-success btn-xs' onclick='cargarMarca(this.id);' id='"+ans[i].id+"'>Ver Detalles</a></center></div></div> ";
                    }
                }
            }else{
                document.getElementById("alerta").style.display = 'block';
                document.getElementById("mensaje").innerHTML = "<strong>Ups!!</strong> No se han encontrado resultados en la búsqueda. Intente con otro nombre o utilice los filtros para la búsqueda específica.";
            }
        }
    });
}

function cargarMarca($id){
    //var route = "http://www.toodrinks.com/marca/detalles-marca/"+$id+"";
    var route = "http://localhost:8000/detalles-marca/"+$id;

    document.getElementById("marca_id").value = $id;

    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            document.getElementById("alerta").style.display = 'none';
            document.getElementById("alert").style.display = 'none';

            document.getElementById("infoMarca").innerHTML = "<div class='panel-heading'><h4><b>Marca: "+ans.nombre+"</b></h4></div><ul class='list-group'>";
            document.getElementById("infoMarca").innerHTML += "<li class='list-group-item'><b>Nombre SEO: </b>"+ans.nombre_seo+"</li>";
            document.getElementById("infoMarca").innerHTML += "<li class='list-group-item'><b>Descripción: </b>"+ans.descripcion+"</li>";
            document.getElementById("infoMarca").innerHTML += "<li class='list-group-item'><b>Productor: </b>"+ans.productor.nombre+"</li>";
            document.getElementById("infoMarca").innerHTML += "<li class='list-group-item'><b>País: </b>"+ans.pais.pais+"</li>";
            document.getElementById("infoMarca").innerHTML += "</ul>";

            /*if (ans.relacion == 1){
                document.getElementById("asociar").style.display = 'none';
                document.getElementById("solicitar").style.display = 'none';
                document.getElementById("alert").innerHTML = "Ya te encuentras asociado con esta marca. Dirígete a la sección *Mis Marcas* para más detalles.";
                document.getElementById("alert").style.display = 'block';
            }else{
                if (ans.check == 1){
                    document.getElementById("asociar").style.display = 'block';
                    document.getElementById("solicitar").style.display = 'block';
                }else{
                    document.getElementById("asociar").style.display = 'none';
                    document.getElementById("solicitar").style.display = 'none';
                    document.getElementById("alert").innerHTML = "El productor de la marca no ha marcado tu país como posible destino laboral, por lo tanto, no existen opciones disponibles para esta marca.";
                    document.getElementById("alert").style.display = 'block';
                }
            }*/

            $("#modalDetalles").modal({
                show: 'true'
            });
        }
    });
}