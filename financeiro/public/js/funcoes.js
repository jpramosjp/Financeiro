$(document).ready(function(){
    if ($("#alerta").css("display") === "block") {
         alerta();
    }
 });

function alerta() {
    console.log("opa")
    $("#alerta").animate({ opacity: 0 }, 5000, function() {
                   $(this).remove();
               });
}
