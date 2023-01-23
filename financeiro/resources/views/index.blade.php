@extends('layout_login')

@section('mensagem')
    @if(!empty($mensagem))
        <div id="alerta_sucesso" class="fixed-top alert alert-success text-center" role="alert">
            {{$mensagem}}
        </div>
    @endif
@endsection

@section('formulario')
<div class="mb-1">
    <input class="form-control" type="text" placeholder="Nome de Usuario">
</div>
<div class="mb-2">
    <input class="form-control" type="text" placeholder="Senha">
</div>
<div class="mb-2">
    <button class="w-100 btn btn-lg btn-success" type="submit"><i class="fa-solid fa-right-to-bracket mx-1"></i> Entrar</button>
</div>
<div class="mb-2">
    <a class="w-100 btn btn-lg btn-secondary" href="{{ route('form_cadastro_usuario') }}" ><i class="fa-solid fa-user mx-1"></i>Cadastro</a>
</div>
@endsection


@section('links')
    <script src="{{ asset('js/index.js') }}"></script>
@endsection