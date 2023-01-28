
$(document).ready(function() {
    $("#botao-menu").click(function() {
      $("#menu-lateral").toggleClass("menu-visivel");
    });

var labels = [];
var data = [];
var cor = [];
$("#dados_pie input[type='hidden']").each(function() {
    var dados = $(this).val().split(',');
    labels.push(dados[0]);
    data.push(dados[1]);
    cor.push(dados[2]);
});
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: cor,
      hoverBackgroundColor: cor,
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
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



// Pie Chart Example
