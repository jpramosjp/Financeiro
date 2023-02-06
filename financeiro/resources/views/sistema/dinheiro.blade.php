@extends ('layout_menu')

@section('dados')
<div class="container-fluid">
    <input id="url" type="hidden" value="{{route('atualizar_dinheiro')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Controle de dinheiro</h1>
    </div>
    <form method="post" action="{{route('inserir_dinheiro')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="usuario_dinheiro">Usuario</label>
            <select name="usuario_dinheiro" class="form-control" id="usuario" readonly= "true">
                <option value="{{$usuario->codigo}}">{{$usuario->nome}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="valor_dinheiro">Valor</label>
            <input type="text" name="valor_dinheiro" class="form-control" id="valor_dinheiro" value=" 0,00" onkeyup="return formataValor(this)">
        </div>
        <div class="mt-2">
            <button class="w-100 btn btn-lg btn-success" type="submit" > Salvar</button>
        </div>
    </form>
        <hr>


        <div class="table-responsive d-flex flex-wrap">
            <table class="table table-striped table-bordered" id="tabela_dinheiro">
                <thead>
                    <tr>
                        <td>Valor</td>
                        <td>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dinheiroGuardado as $chave => $valor)
                    <tr data-dinheiro-id="{{ $valor->codigo }}">   
                        <td> 
                            <input type="text" id= "valor_dinheiro_{{$valor->codigo}}" readonly= "true" class="valor_dinheiro" value="{{number_format($valor->valor, 2, ',', '')}}" onkeyup=" return formataValor(this)"  style="border: none; background-color: transparent; pointer-events: none;">
                            <input type="hidden" class="valor_dinheiro_antigo" readonly= "true" value="{{number_format($valor->valor, 2, ',', '')}}">
                        </td>
                        <td>
                            <div class="d-flex">
                                <button class="btn btn-primary mx-3 editar">Editar</button>
                                <form></form>
                                <form  method="post" action="{{ route('deletar_dinheiro', $valor->codigo)}}">
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
<script src="{{ asset('js/dinheiro.js') }}"></script>
@endsection