function refrescarCreditos(){
	//var route = "http://www.toodrinks.com/consulta/refrescar-creditos";
    var route = "http://localhost:8000/consulta/refrescar-creditos";
                    
   $.ajax({
        url:route,
        type:'GET',
        success:function(ans){
        	document.getElementById("creditos").innerHTML = "<strong>"+ans.saldo+"</strong>";
        }
    });
}