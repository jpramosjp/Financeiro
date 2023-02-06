@extends ('layout_menu')

@section('dados')
<div class="container-fluid">
    <input id="url" type="hidden" value="{{route('atualizar_receitas')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Controle de Receitas</h1>
    </div>
    <form method="post" action="{{route('inserir_receita')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="usuario_receita">Usuario</label>
            <select name="usuario_receita" class="form-control" id="usuario" readonly= "true">
                <option value="{{$usuario->codigo}}">{{$usuario->nome}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="text" name="valor_receita" class="form-control" id="valor_receita" value=" 0,00" onkeyup="return formataValor(this)">
        </div>
        <div class="form-group">
            <label for="select_receita">Tipo da Receita</label>
            <select name="tipo_receita" class="form-control" id="select_receita">
                @foreach($listaReceitas as $receita) 
                    <option value="{{$receita->codigo}}">{{$receita->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" id="form_descricao_receita" style="display: none;">
            <label for="descricao_receita">Descrição</label>
            <input type="text" name="descricao_receita" class="form-control" id="descricao_receita">
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
                    <td>Data inserido</td>
                    <td>Ações</td>
                </tr>
                
                @foreach($todasReceitas as $chave => $valor)
                <tr data-receita-id="{{ $valor->codigo }}">
                    <td>
                        <input type="text" readonly= "true" class="tipo-receita" value="{{$valor->tipo_receita}}"  style="border: none; background-color: transparent; pointer-events: none;">
                        <input type="hidden" class="tipo_receita_antigo" value="{{$valor->tipo_receita}}">
                        <input type="hidden" class="codigo_tipo_receita" value="{{$valor->codigo_tipo_receita}}">
                    </td>
                    <td> 
                        <input type="text" id= "valor_receita_{{$valor->codigo}}" readonly= "true" class="valor-receita" value="{{number_format($valor->valor, 2, ',', '')}}" onkeyup=" return formataValor(this)"  style="border: none; background-color: transparent; pointer-events: none;">
                        <input type="hidden" class="valor_antigo" readonly= "true" value="{{number_format($valor->valor, 2, ',', '')}}">
                    </td>
                    <td>
                        {{date("d/m/Y", strtotime($valor->data_inserido))}}
                    </td>
                    <td>
                    <div class="d-flex">
                        <button class="btn btn-primary mx-3 editar">Editar</button>
                        <form id= "form_excluir"></form>
                            <form  method="post" action="{{ route('deletar', $valor->codigo)}}">
                                @csrf
                                {{method_field('DELETE')}}
                                <button type="submit" class="btn btn-danger ml-auto excluir" style="display:block;">Excluir</button>
                        </form>
                        <button type="button" class="btn btn-secondary ml-auto cancelar" style="display:none;">Cancelar</button>
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