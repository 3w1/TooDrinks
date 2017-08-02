function cargarProvincias() {

   document.getElementById("provincias").innerHTML = "<option value=''>Seleccione una provincia..</option>";
        
   var pais = document.getElementById('pais_id').value;
   //var route = "http://www.toodrinks.com/pais/"+pais+"";
   var route = "http://localhost:8000/pais/"+pais+"";
                    
   $.ajax({
      url:route,
      type:'GET',
      success:function(ans){
         for (var i = 0; i < ans.length; i++ ){
            document.getElementById("provincias").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].provincia+"</option>";
         }
      }
   });
}

function cargarClases() {

    document.getElementById("clases_bebidas").innerHTML = "<option value=''>Seleccione una clase..</option>";
        
    var bebida = document.getElementById('bebida_id').value;
    //var route = "http://www.toodrinks.com/bebida/"+bebida+"";
    var route = "http://localhost:8000/bebida/"+bebida+"";
                    
    $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
            for (var i = 0; i < ans.length; i++ ){
                document.getElementById("clases_bebidas").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].clase+"</option>";
            }
        }
    });
}