$(document).ready(function() { 
   if( $("#alerta_sucesso").length > 0) {
       $("#alerta_sucesso").animate({ opacity: 0 }, 3000, function() {
           $(this).remove();
       }); 
   }
});

