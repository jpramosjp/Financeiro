$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $("#tabela_despesa tbody").on("click", ".editar", function(e) {
      e.preventDefault();
      const tr = $(this).closest('tr');
      const inputs = tr.find('input[type="text"]');
      const select = tr.find('.select_tabela_despesa');

      select .prop('disabled', false);

      inputs.prop('readonly', false);
      inputs.css('pointer-events', 'auto');

      $(this).text('Salvar');
      $(this).removeClass('btn-primary').addClass('btn-success').addClass('salvarEdicoes');

      const excluirBtn = tr.find('.excluir');
      excluirBtn.css("display", "none");

      const cancelarBtn = tr.find(".cancelar");
      cancelarBtn.css("display","block");
   });

   $(document).on('click', '.cancelar', function(e) {
    e.preventDefault();
    const tr = $(this).closest('tr');
    const inputs = tr.find('input[type="text"]');
    const select = tr.find('.select_tabela_despesa');
    const dataVencimento = tr.find(".data_vencimento_tabela")

   
    tr.find('.valor_despesa').val(tr.find('.valor_despesa_antigo').val());
    select.val(tr.find('.tipo_despesa_antigo').val());
    dataVencimento.val(tr.find(".data_vencimento_tabela_antigo").val())
    select.prop('disabled', true);
    inputs.prop('readonly', true);
    inputs.css('pointer-events', 'none');
  
    $(this).css("display", "none");
    const excluirBtn = tr.find('.excluir');
    excluirBtn.css("display", "block");
  
    tr.find('.btn-success').text('Editar');
    tr.find('.btn-success').removeClass('btn-success').addClass('btn-primary').removeClass('salvarEdicoes');
  });

  $(document).on("click", ".excluir", function() {
    var form = $(this).closest("form");
    form.submit();
    });

  $(document).on('click', '.salvarEdicoes', function(e) {
    e.preventDefault();
    const tr = $(this).closest('tr');
    const codigo = tr.data("despesa-id");
    const inputs = tr.find('input[type="text"]');
    var valor = tr.find(".valor_despesa").val();
    var tipoDespesa =  tr.find('.select_tabela_despesa').val();
    var dataVencimento = tr.find(".data_vencimento_tabela").val();
    var nomeDespesa = tr.find(".nome_despesa").val();
    
    if(nomeDespesa == tr.find(".nome_despesa_antigo").val() && valor == tr.find('.valor_despesa_antigo').val() && tipoDespesa == tr.find('.tipo_despesa_antigo').val() && dataVencimento == tr.find(".data_vencimento_tabela_antigo").val() ) {
        return true;
    }
    var usuario = $("#codigo_usuario").val();
    

     $.ajax({
        type: 'POST',
        url: $("#url").val(),
        data: {
            "codigo": codigo,
            "tipoDespesa": tipoDespesa,
            "dataVencimento": dataVencimento,
            "valor": valor,
            "usuario": usuario,
            "nomeDespesa": nomeDespesa
        },
        success: function (response) {
            $("#alerta").addClass(response.classe);
            $("#alerta").text(response.mensagem);
            alerta();
            if(response.sucesso == 1) {
                tr.find('.tipo_despesa_antigo').val(tipoDespesa)
                tr.find('.valor_despesa_antigo').val(valor);
                tr.find(".nome_despesa_antigo").val(nomeDespesa);
                tr.find(".data_vencimento_tabela_antigo").val(dataVencimento);
                inputs.prop('readonly', true);
                inputs.css('pointer-events', 'none');
                tr.find('.select_tabela_despesa').prop('disabled', true);
            
                const excluirBtn = tr.find('.excluir');
                excluirBtn.css("display", "block");
          
                const cancelarBtn = tr.find(".cancelar");
                cancelarBtn.css("display","none");
            
                tr.find('.btn-success').text('Editar');
                tr.find('.btn-success').removeClass('btn-success').addClass('btn-primary').removeClass('salvarEdicoes');
            }
            
        },
        error: function (error) {
          console.log(error);
        }
      });
  
      $(document).on('click', '#pesquisar_tabela', function(e) {
            
      });
 });
});

function pesquiarDadosMes() {
    var dataInicio = new Date($("#incio_vencimento").val().split("/").reverse().join("-") + "T00:00:00Z");
    var dataFinal = new Date($("#final_vencimento").val().split("/").reverse().join("-") + "T23:59:59Z");
    if (dataInicio > dataFinal) {
        alert("A data de início não pode ser maior que a data final");
        return false;
    }
    dataInicio = dataInicio.toISOString().substring(0, 10);
    dataFinal = dataFinal.toISOString().substring(0, 10);
    var usuario = $("#codigo_usuario").val();
    $.ajax({
        type: 'POST',
        url: $("#url_pesquisa").val(),
        data: {
            "dataInicio": dataInicio,
            "dataFinal": dataFinal,
            "usuario": usuario
        },
        success: function (response) {
            $("#alerta").addClass(response.classe);
            $("#alerta").text(response.mensagem);
            alerta();
            if(response.sucesso == 1) {
                $("#tabela_despesa tbody").empty();
                for (var item of response.dados) {
                    var html = "<tr data-despesa-id='" + item.codigo + "'>" +
                                    "<td>" +
                                        "<input type='text' readonly= 'true' class='nome_despesa' value='" + item.nome_despesa + "'  style='border: none; background-color: transparent; pointer-events: none;'>" +
                                        "<input type='hidden' class='nome_despesa_antigo' value='" + item.nome_despesa + "'>"  +   
                                    "</td>" +
                                    "<td>" +
                                        "<select class='form-select select_tabela_despesa' style='width:auto;' disabled>";
                    for(var itemLista of response.listaDespesa) {
                        var select = (item.codigo_despesa == itemLista.codigo) ? 'selected' : '';
                        html = html + "<option " + select + " value='" + itemLista.codigo + "'>" + itemLista.nome + "</option>";
                    }
                    html = html + "</select>"
                            + "<input type='hidden' class='tipo_despesa_antigo' value='" + item.codigo_despesa + "'>"
                            + "</td>"
                            + "<td>" +
                                "<input type='text' id= 'valor_despesa_" + item.codigo + "' readonly= 'true' class='valor_despesa' value='" + parseFloat(item.valor).toFixed(2).replace('.', ',') + "' onkeyup=' return formataValor(this)'  style='border: none; background-color: transparent; pointer-events: none;'>"
                            +   "<input type='hidden' class='valor_despesa_antigo' readonly= 'true' value='" +  parseFloat(item.valor).toFixed(2).replace('.', ',') + "'>" 
                            + "</td>" 
                            + "<td>" +
                                "<input type='text' class='data_vencimento_tabela' size='10' maxlength='10' value='" + new Date(item.data_vencimento).toLocaleDateString('pt-BR') + "' onkeypress='return mascara_data(this, event)' style='border: none; background-color: transparent; pointer-events: none;'>"
                            +    "<input type='hidden' class='data_vencimento_tabela_antigo' readonly= 'true' value='" + new Date(item.data_vencimento).toLocaleDateString('pt-BR') + "'>"
                            +  "</td>"
                            +  "<td>" +
                                   "<div class='d-flex'>" 
                            +            "<button class='btn btn-primary mx-3 editar'>Editar</button>"
                            +            "<form  method='post' action='"+ $("#url_deletar").val().replace("/0","/" + item.codigo) + "'>"
                            +               "<input type='hidden' name='_token' value='" + $("meta[name='csrf-token']").attr("content") + "'>"
                            +               "<input type='hidden' name='_method' value='DELETE'>"
                            +               "<button type='submit' class='btn btn-danger ml-auto excluir'>Excluir</button>"
                            +           "</form>"
                            +        "<button type='button' class='btn btn-secondary ml-auto cancelar' style='display:none;'>Cancelar</button>"
                            +      "</div>"
                            +  "</td>"
                            + "</tr>";
                            $("#tabela_despesa tbody").append(html);
                }
                return true;
        
            }
            
        },
        error: function (error) {
          console.log(error);
        }
      });

      return true;


   
}
