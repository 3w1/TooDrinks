$(document).ready(function() {

   var valorEnvio = $("#envio_hidden").val();
   
   if (valorEnvio == "1" ){
      $("#envio option[value='1']").attr("selected",true);
   }else{
      $("#envio option[value='0']").attr("selected",true);
   }

   var valorImportador = $("#v_importadores").val();
   
   if (valorImportador == "1" ){
      $("#visible_importadores option[value='1']").attr("selected",true);
   }else{
      $("#visible_importadores option[value='0']").attr("selected",true);
   }

   var valorDistribuidor = $("#v_distribuidores").val();
   
   if (valorDistribuidor == "1" ){
      $("#visible_distribuidores option[value='1']").attr("selected",true);
   }else{
      $("#visible_distribuidores option[value='0']").attr("selected",true);
   }

   var valorHoreca = $("#v_horecas").val();
   
   if (valorHoreca == "1" ){
      $("#visible_horecas option[value='1']").attr("selected",true);
   }else{
      $("#visible_horecas option[value='0']").attr("selected",true);
   }
});