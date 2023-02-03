$(document).ready(function(){
    if ($("#alerta").css("display") === "block") {
         alerta();
    }
    $("#botao-menu").click(function() {
        $("#menu-lateral").toggleClass("menu-visivel");
      });
 });

function alerta() {
    $("#alerta").css("display", "block");
    $("#alerta").css("opacity", 1);
    $("#alerta").animate({ opacity: 0 }, 5000, function() {
        $(this).css("display", "none");
        $(this).removeClass("alert-success");
    });

    return true;

}

function formataValor(campo) {
    valor = campo.value;
    valor = valor.replace(/[^0-9]/gm, "");
    if (!valor.length) {
        campo.value = "";
        return true;
    }
    valor = valor.toString();
    contador = valor.length;
    if (contador > 2) {
        valor = valor.substring(0, (contador - 2)) + "," + valor.substr(-2);
    }
    campo.value = valor;
    return true;
};
