
$(document).ready(function() {

    if (window.innerWidth < 768) {
        document.getElementById("menu-lateral").classList.remove("no-data-menu");
        document.getElementById("content-wrapper").classList.remove("no-data");
      }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#selectMes").change(function(){
        var selectedOption = $(this).val();
        $("#mesEscolhido").val(selectedOption);
        $("#formOption").submit();
      });

    if($("#myPieChart").length > 0 && $("#myAreaChart").length > 0) {
        var labels = [];
        var data = [];
        var cor = [];
        $("#dados_pie input[type='hidden']").each(function() {
            var dados = $(this).val().split(',');
            labels.push(dados[0]);
            data.push(dados[1]);
            cor.push(dados[2]);
        });
        if($("#dados_pie input[type='hidden']").length > 0) {
            document.getElementById("menu-lateral").classList.remove("no-data-menu");
            document.getElementById("content-wrapper").classList.remove("no-data");
        }
        
        
        var contador = 0;
        var dados = {};
        $(".card.m-3").each(function(){
            var nomeDespesa = $(this).find(".nome_despesa h6").text();
            var valores = $(this).find(".valores_despesa").each(function() {
                var val = parseFloat($(this).text().replace("R$", "").replace(".", "").replace(",", "."));
                if (!dados[contador]) {
                    dados[contador] = {label: nomeDespesa, valor: val};
                } else {
                    dados[contador].valor += val;
                }
            });
            contador++;
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
        
        
        
        var dadosArray = Object.values(dados);
        
        var ctx = document.getElementById('myAreaChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels:dadosArray.map(function(d) { return d.label; }),
                datasets: [{
                    label: 'Valor total da despesa  ',
                    data: dadosArray.map(function(d) { return d.valor; }),
                    backgroundColor: cor,
                    borderColor: cor,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

    }
  });


function mostarOpcoes() {
    // if($("#seta_usuario").hasClass("show")) {
    //     $("#seta_usuario").removeClass("show");
    //     $("#opcoes_usuario").removeClass("show opcoes-cima");
    //     return true;
    // }
    // $("#seta_usuario").addClass("show");
    // $("#opcoes_usuario").addClass("show opcoes-cima");
    return true;
}


