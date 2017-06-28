function buscarProducto() {
    alert("Emtro");
    //document.getElementById("productos").innerHTML = "<option value=''>Seleccione una provincia..</option>";
        
    var producto = document.getElementById('producto').value;
	var route = "http://localhost:8000/demanda-importador/16";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            //for (var i = 0; i < ans.length; i++ ){
            document.getElementById("productos").innerHTML += "<p>"+ans.id+" - "+ans.nombre+"</p>";
            //}
        }
    });
}