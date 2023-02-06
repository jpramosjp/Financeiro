$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $("#tabela_dinheiro tbody").on("click", ".editar", function(e) {
      e.preventDefault();
      const tr = $(this).closest('tr');
      const inputs = tr.find('input[type="text"]');

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

   
    tr.find('.valor_dinheiro').val(tr.find('.valor_dinheiro_antigo').val());
    inputs.prop('readonly', true);
    inputs.css('pointer-events', 'none');
  
    $(this).css("display", "none");
    const excluirBtn = tr.find('.excluir');
    excluirBtn.css("display", "block");
  
    tr.find('.btn-success').text('Editar');
    tr.find('.btn-success').removeClass('btn-success').addClass('btn-primary').removeClass('salvarEdicoes');
  });



  $(document).on('click', '.salvarEdicoes', function(e) {
    e.preventDefault();
    const tr = $(this).closest('tr');
    const codigo = tr.data("dinheiro-id");
    const inputs = tr.find('input[type="text"]');
    var valor = tr.find(".valor_dinheiro").val();
    
    if(valor == tr.find('.valor_dinheiro_antigo').val()) {
        return true;
    }
    var usuario = $("#codigo_usuario").val();
    

     $.ajax({
        type: 'POST',
        url: $("#url").val(),
        data: {
            "codigo": codigo,
            "valor": valor,
            "usuario": usuario
        },
        success: function (response) {
            $("#alerta").addClass(response.classe);
            $("#alerta").text(response.mensagem);
            alerta();
            if(response.sucesso == 1) {
                tr.find('.valor_dinheiro_antigo').val(valor);
                inputs.prop('readonly', true);
                inputs.css('pointer-events', 'none');
            
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
  
 });
});

