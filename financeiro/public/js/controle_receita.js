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

      const excluirBtn = tr.find('.excluir');
      excluirBtn.css("display", "none");

      const cancelarBtn = tr.find(".cancelar");
      cancelarBtn.css("display","block");
   });

   $(document).on('click', '.cancelar', function(e) {
    e.preventDefault();
    const tr = $(this).closest('tr');
    const inputs = tr.find('input[type="text"]');
    tr.find('.valor-receita').val(tr.find('.valor_antigo').val());
    tr.find('.tipo-receita').val(tr.find('.tipo_receita_antigo').val());
  
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
    const inputs = tr.find('input[type="text"]');
    const codigoReceita = tr.find(".codigo_tipo_receita").val();
    const codigo = tr.data("receita-id");
    const tipoReceita = inputs.first().val();
    var valor = inputs.last().val()
    
    
    var usuario = $("#codigo_usuario").val();
    valor = parseFloat(valor.replace("R$ ", "").replace(".", "").replace(",", "."));
    if((tr.find('.tipo_receita_antigo').val() == tipoReceita) && (valor == parseFloat(tr.find('.valor_antigo').val().replace("R$ ", "").replace(".", "").replace(",", ".")))) {
        return true;
    }

     $.ajax({
        type: 'POST',
        url: $("#url").val(),
        data: {
            "codigo": codigo,
            "codigoReceita": codigoReceita,
            "tipoReceita": tipoReceita,
            "valor": valor,
            "usuario": usuario
        },
        success: function (response) {
            $("#alerta").addClass(response.classe);
            $("#alerta").text(response.mensagem);
            alerta();
            if(response.sucesso == 1) {
                tr.find('.tipo_receita_antigo').val(tipoReceita)
                tr.find('.valor_antigo').val(tr.find('.valor-receita').val());
                inputs.prop('readonly', true);
                inputs.css('pointer-events', 'none');
            
                const excluirBtn = tr.find('.excluir');
                excluirBtn.css("display", "block");
          
                const cancelarBtn = tr.find(".cancelar");
                cancelarBtn.css("display","none");
            
                tr.find('.btn-success').text('Editar');
                tr.find('.btn-success').removeClass('btn-success').addClass('btn-primary').removeClass('salvarEdicoes');
                return true;
            }
            
        },
        error: function (error) {
          console.log(error);
        }
      });
  
      return true;
 });
});

function layoutNormal(inputs) {
   
}
