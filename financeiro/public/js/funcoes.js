$(document).ready(function(){
    if ($("#alerta").css("display") === "block") {
         alerta();
    }
    $("#botao-menu").click(function() {
        $("#menu-lateral").toggleClass("menu-visivel");
      });
 });

function alerta() {
    console.log("opa")
    $("#alerta").animate({ opacity: 0 }, 5000, function() {
                   $(this).remove();
               });
}

function formatNumber(obj, num) {
    return $(obj).val(Number(num).toLocaleString("pt-BR", {style: "currency", currency: "BRL"}));
}
