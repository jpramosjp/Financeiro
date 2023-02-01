@extends ('layout_menu')

@section('dados')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Controle de Receitas</h1>
    </div>
    <form>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="text" class="form-control" id="valor_receita" value="R$ 0,00" onchange="return formatNumber('#valor_receita', this.value)">
        </div>
        <div class="form-group">
            <label for="select_receita">Tipo da Receita</label>
            <select class="form-control" id="select_receita">
                @foreach($listaReceitas as $receita) 
                    <option value="{{$receita->codigo}}">{{$receita->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" id="form_descricao_receita" style="display: none;">
            <label for="descricao_receita">Descrição</label>
            <input type="text" class="form-control" id="descricao_receita">
        </div>
        <div class="mt-2">
            <button class="w-100 btn btn-lg btn-success" type="submit" > Salvar</button>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Nome</td>
                    <td>Valor</td>
                    <td>Ações</td>
                </tr>
                @foreach($todasReceitas as $chave => $valor)
                <tr data-receita-id="{{ $valor->codigo }}">
                    <td>
                        <input type="text" readonly= "true" class="tipo-receita" value="{{$valor->tipo_receita}}"  style="border: none; background-color: transparent; pointer-events: none;">
                        <input type="hidden" class="tipo_receita_antigo" readonly= "true" value="{{$valor->tipo_receita}}">
                        <input type="hidden" readonly= "true" value="{{$valor->codigo_tipo_receita}}">
                    </td>
                    <td> 
                        <input type="text" id= "valor_receita_{{$valor->codigo}}" readonly= "true" class="valor-receita" value="R$ {{number_format($valor->valor, 2, ',', '.')}}" onchange=" return formatNumber('#valor_receita_{{$valor->codigo}}', this.value)"  style="border: none; background-color: transparent; pointer-events: none;">
                        <input type="hidden" class="valor_antigo" readonly= "true" value="R$ {{number_format($valor->valor, 2, ',', '.')}}">
                    </td>
                    <td>
                    <div class="d-flex">
                        <button class="btn btn-primary mx-3 editar">Editar</button>
                        <button class="btn btn-danger ml-auto excluir">Excluir</button>
                    </div>
                    </td>
                <tr>
                @endforeach
            </table>
        </div>
</form>
</div>
@endsection

@section('links')
<script src="{{ asset('js/controle_receita.js') }}"></script>
@endsection