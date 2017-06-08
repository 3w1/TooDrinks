$(document).ready(function() {

	//Cargar el valor del Select Pais
	var valorPais = $("#pais_hidden").val();

	var selectPais = document.getElementById("pais_id");
  	var cantPaises = selectPais.length;
   	for (i = 0; i < cantPaises; i++) {
    	if (selectPais[i].value == valorPais) {
       		selectPais[i].selected = true;
      	}   
   	}

   //Cargar el valor del Select ProvinciaRegion
   var valorProvincia = $("#provincia_hidden").val();
	
	var selectProvincia = document.getElementById("provincia_id");
  	var cantProvincias = selectProvincia.length;
   	for (i = 0; i < cantProvincias; i++) {
    	if (selectProvincia[i].value == valorProvincia) {
       		selectProvincia[i].selected = true;
      	}   
   	}

   //Cargar el valor del Select ClaseBebida
   var valorClaseBebida = $("#clase_bebida_hidden").val();
	
	var selectClaseBebida = document.getElementById("clase_bebida_id");
  	var cantClasesBebidas = selectClaseBebida.length;
   	for (i = 0; i < cantClasesBebidas; i++) {
    	if (selectClaseBebida[i].value == valorClaseBebida) {
       		selectClaseBebida[i].selected = true;
       	}
    }
});

function cargarProvincias() {

   document.getElementById("provincia_id").innerHTML = "<option value=''>Seleccione una provincia..</option>";
        
   var pais = document.getElementById('pais_id').value;
   var route = "http://localhost:8000/pais/"+pais+"";
                    
   $.ajax({
      url:route,
      type:'GET',
      success:function(ans){
         for (var i = 0; i < ans.length; i++ ){
            document.getElementById("provincia_id").innerHTML += "<option value='"+ans[i].id+"'>"+ans[i].provincia+"</option>";
         }
      }
   });
}