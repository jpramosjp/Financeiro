@extends('layout')
@section('conteudo')

    <div id="alerta" class="fixed-top alert {{$classe}} text-center" role="alert" style="display: {{$display}};">
            {{$mensagem}}
    </div>
    <div class="custom-gradient">
        @yield('mensagem')
        <div class="container min-vh-100 d-flex justify-content-center align-items-center">

            <form id= "form" method="post">
                <div class="mb-4 text-center">
                <i class="fa-solid fa-money-bill-trend-up fa-10x"></i>
                </div>
                @yield('formulario')
            </form>
        </div>
    </div>
@endsection

@section('links')
    @yield('links')
@endsection
