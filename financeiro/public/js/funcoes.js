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

var filtra_entrada = function (evento, filtro, elemento) {
    var tecla;
    var caractertecla;
    if (window.event) {
        tecla = window.event.keyCode;
    } else {
        if (evento) {
            tecla = evento.which;
        } else {
            return true;
        }
    }
    caractertecla = String.fromCharCode(tecla);
    return ((tecla == null) || (tecla == 0) || (tecla == 8) || (tecla == 9) || (tecla == 13) || (tecla == 27) || ((filtro.indexOf(caractertecla) > -1)));
}


var mascara_data = function (elemento, evento) {
    if (!filtra_entrada(evento, "0123456789")) {
        return false;
    }
    if (((elemento.value.length == 2) || (elemento.value.length == 5)) && (!filtra_entrada(evento, String.fromCharCode(8)))) {
        elemento.value = elemento.value + "/";
    }



    return true;
}
