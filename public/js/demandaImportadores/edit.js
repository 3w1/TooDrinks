$(document).ready(function() {
   var valorStatus = $("#status_hidden").val();
   if (valorStatus == "1" ){
      $("#status option[value='1']").attr("selected",true);
   }else{
      $("#status option[value='0']").attr("selected",true);
   }
});