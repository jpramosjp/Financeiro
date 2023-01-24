@extends('layout_login')


@section('formulario')
@csrf
<div class="mb-1">
    <input id="nome_acesso" class="form-control" type="text" name="nome_acesso" placeholder="Nome de Usuario">
</div>
<div class="mb-2">
    <input id="senha_acesso" class="form-control" type="password" name="senha" placeholder="Senha">
</div>
<div class="mb-2">
    <button class="w-100 btn btn-lg btn-success" type="submit" onclick="validaPesquisa()"><i class="fa-solid fa-right-to-bracket mx-1"></i> Entrar</button>
</div>
<div class="mb-2">
    <a class="w-100 btn btn-lg btn-secondary" href="{{ route('form_cadastro_usuario') }}" ><i class="fa-solid fa-user mx-1"></i>Cadastro</a>
</div>
@endsection


@section('links')
    <script src="{{ asset('js/index.js') }}"></script>
@endsection