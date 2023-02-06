@extends ('layout_menu')

@section('dados')
<div class="container-fluid">
    <input id="url" type="hidden" value="{{route('atualizar_despesa')}}">
    <input id="url_pesquisa" type="hidden" value="{{route('pesquisa_despesa')}}">
    <input id="url_deletar" type="hidden" value="{{route('deletar_despesa', 0)}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Controle de Despesa</h1>
    </div>
    <form method="post" action="{{route('inserir_despesa')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="usuario_despesa">Usuario</label>
            <select name="usuario_despesa" class="form-control" id="usuario" readonly= "true">
                <option value="{{$usuario->codigo}}">{{$usuario->nome}}</option>
            </select>
        </div>
        <div class="form-group" id="form_nome_despesa">
            <label for="nome_despesa">Nome da despesa</label>
            <input type="text" name="nome_despesa" class="form-control" id="nome_despesa">
        </div>
        <div class="form-group">
            <label for="valor_despesa">Valor</label>
            <input type="text" name="valor_despesa" class="form-control" id="valor_despesa" value=" 0,00" onkeyup="return formataValor(this)">
        </div>
        <div class="form-group">
            <label for="select_despesa">Tipo da Receita</label>
            <select name="tipo_despesa" class="form-control" id="select_despesa">
                @foreach($listaDespesa as $despesa) 
                    <option value="{{$despesa->codigo}}">{{$despesa->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="data_vencimento">Vencimento</label>
            <input type="text" name="data_vencimento" id="data_vencimento" size="10" maxlength="10" value="{{ date('d/m/Y', strtotime($periodo)) }}" onkeypress="return mascara_data(this, event)"  class="form-control">
        </div>
        <div class="mt-2">
            <button class="w-100 btn btn-lg btn-success" type="submit" > Salvar</button>
        </div>
    </form>
        <hr>
        <div class="d-flex align-items-center justify-content-center m-3">
            <label for="periodo-datas" class="mr-3 mx-2">Data Vencimento:</label>
            <input type="text" id="incio_vencimento" class="form-control mr-3" value="{{date('d/m/Y', strtotime($periodoMes[0]->inicio))}}" style="width: 120px; height: 40px;" onkeypress="return mascara_data(this, event)">
            <span class="mx-2">A</span>
            <input type="text" id="final_vencimento" class="form-control mr-3" value="{{date('d/m/Y', strtotime($periodoMes[0]->fim))}}" style="width: 120px; height: 40px;" onkeypress="return mascara_data(this, event)">
            <button id="pesquisar_tabela" class="btn btn-primary  mx-2 ml-3" onclick="pesquiarDadosMes()">Pesquisar</button>
        </div>



        <div class="table-responsive d-flex flex-wrap">
            <table class="table table-striped table-bordered" id="tabela_despesa">
                <thead>
                    <tr>
                        <td>Nome</td>
                        <td>tipo Despesa</td>
                        <td>Valor</td>
                        <td>Data Vencimento</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todasDespesa as $chave => $valor)
                    <tr data-despesa-id="{{ $valor->codigo }}">
                        <td>
                            <input type="text" readonly= "true" class="nome_despesa" value="{{$valor->nome_despesa}}"  style="border: none; background-color: transparent; pointer-events: none;">
                            <input type="hidden" class="nome_despesa_antigo" value="{{$valor->nome_despesa}}">
                            
                        </td>
                        <td>
                            <select class="form-select select_tabela_despesa" style="width:auto;" disabled>

                                @foreach($listaDespesa as $despesa) 
                                @php
                                    $select = ($valor->codigo_despesa == $despesa->codigo) ? 'selected' : '';
                                @endphp
                                <option {{$select}} value="{{$despesa->codigo}}">{{$despesa->nome}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" class="tipo_despesa_antigo" value="{{$valor->codigo_despesa}}">
                        </td>
                        <td> 
                            <input type="text" id= "valor_despesa_{{$valor->codigo}}" readonly= "true" class="valor_despesa" value="{{number_format($valor->valor, 2, ',', '.')}}" onkeyup=" return formataValor(this)"  style="border: none; background-color: transparent; pointer-events: none;">
                            <input type="hidden" class="valor_despesa_antigo" readonly= "true" value="{{number_format($valor->valor, 2, ',', '.')}}">
                        </td>
                        <td>
                        <input type="text" class="data_vencimento_tabela" size="10" maxlength="10" value="{{ date('d/m/Y', strtotime($valor->data_vencimento)) }}" onkeypress="return mascara_data(this, event)" style="border: none; background-color: transparent; pointer-events: none;">
                        <input type="hidden" class="data_vencimento_tabela_antigo" readonly= "true" value="{{ date('d/m/Y', strtotime($valor->data_vencimento)) }}">
                        </td>
                        <td>
                        <div class="d-flex">
                            <button class="btn btn-primary mx-3 editar">Editar</button>
                            <form></form>
                                <form  method="post" action="{{ route('deletar_despesa', $valor->codigo)}}">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-danger ml-auto excluir">Excluir</button>
                                </form>
                                <button type="button" class="btn btn-secondary ml-auto cancelar" style="display:none;">Cancelar</button>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</form>
</div>
@endsection

@section('links')
<script src="{{ asset('js/despesa.js') }}"></script>
@endsection