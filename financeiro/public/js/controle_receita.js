$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#select_receita").change(function(){
        $("#form_descricao_receita").css("display", "none");
       if($(this).val() == 3) {
        $("#form_descricao_receita").css("display", "block");
       }
    });
    

   $('.editar').click(function(e) {
      e.preventDefault();
      const tr = $(this).closest('tr');
      const inputs = tr.find('input[type="text"]');

      inputs.prop('readonly', false);
      inputs.css('pointer-events', 'auto');

      $(this).text('Salvar');
      $(this).removeClass('btn-primary').addClass('btn-success').addClass('salvarEdicoes');

      const excluirBtn = tr.find('.btn-danger');
      excluirBtn.text('Cancelar');
      excluirBtn.removeClass('btn-danger').addClass('btn-secondary').addClass('cancelar').removeClass('excluir');
   });

   $(document).on('click', '.cancelar', function(e) {
    e.preventDefault();
    const tr = $(this).closest('tr');
    const inputs = tr.find('input[type="text"]');
    tr.find('.valor-receita').val(tr.find('.valor_antigo').val());
    tr.find('.tipo-receita').val(tr.find('.tipo_receita_antigo').val());
  
    inputs.prop('readonly', true);
    inputs.css('pointer-events', 'none');
  
    $(this).text('Excluir');
    $(this).removeClass('btn-secondary').addClass('btn-danger');
  
    tr.find('.btn-success').text('Editar');
    tr.find('.btn-success').removeClass('btn-success').addClass('btn-primary').removeClass('salvarEdicoes');
  });

  $(document).on('click', '.salvarEdicoes', function(e) {
    e.preventDefault();
    const tr = $(this).closest('tr');
    const inputs = tr.find('input[type="text"]');
    const codigo = tr.data("receita-id");
     const tipo_receita = inputs.first().val();
     const valor = parseFloat(inputs.last().val().replace("R$ ", "").replace(".", "").replace(",", "."));
     console.log(codigo);
     console.log(tipo_receita);
     console.log(valor);

    $.ajax({
        type: 'POST',
        url: "/atualizar_receitas",
        data: { "valor": tipo_receita},
        success: function(response) {  
            console.log(response.msg);
        }
    });
  

 });
});

