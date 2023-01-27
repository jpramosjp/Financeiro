
$(document).ready(function() {
    $("#botao-menu").click(function() {
      $("#menu-lateral").toggleClass("menu-visivel");
    });
  });


function mostarOpcoes() {
    if($("#seta_usuario").hasClass("show")) {
        $("#seta_usuario").removeClass("show");
        $("#opcoes_usuario").removeClass("show opcoes-cima");
        return true;
    }
    $("#seta_usuario").addClass("show");
    $("#opcoes_usuario").addClass("show opcoes-cima");
    return true;
}
