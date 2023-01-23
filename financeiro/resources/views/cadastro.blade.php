@extends('layout_login')

@section('formulario')
@csrf
<div class="mb-1">
    <input class="form-control" type="text" name="nome_completo" placeholder="Nome Completo">
</div>
<div class="mb-1">
    <input class="form-control" type="text" name="nome_usuario" placeholder="Nome de Usuario">
</div>
<div class="mb-2">
    <input class="form-control" type="text" name="senha_usuario" placeholder="Senha">
</div>
<div  class="input-group mb-2">
    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon3">Data de Nascimento</span>
    </div>
    <input class="form-control" name="data_nascimento_usuario" type="date">
</div>
<div class="mb-2">
    <button class="w-100 btn btn-lg btn-success" type="submit"><i class="fa-solid fa-circle-check mx-1"></i>Cadastrar</button>
</div>
<div class="mb-2">
    <a class="w-100 btn btn-lg btn-secondary" href="{{ route('login') }}">Voltar</a>
</div>
@endsection