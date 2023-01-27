@extends('layout')
@section('conteudo')
<div class="d-flex">
<div id= "menu-lateral" class="d-flex flex-column flex-shrink-0 p-3 text-white custom-gradient vh-100 menu-lateral" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <i class="fa-solid fa-money-bill-trend-up fa-2x p-1"></i>
      <span class="fs-4 mt-auto">Financeiro</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
        @foreach($menu as $valores)
            @php $classe = "text-white"; @endphp
            @if($valores->rota == Route::current()->getName())
                    @php $classe = "active" @endphp
            @endif
            <a href="{{ route("$valores->rota") }}" class="nav-link {{$classe}}" aria-current="page">
                <i class="{{$valores->icone}}"></i>
                {{$valores->nome}}
            </a>    
        </li>
        @endforeach
    </ul>
    <hr>
    <div class="dropup">
      <a id="seta_usuario" href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" onclick="mostarOpcoes()">
      {!! $imagemUsuario !!}
        <strong>{{$nomeAcesso}}</strong>
      </a>
      <ul id="opcoes_usuario" class="dropdown-menu dropdown-menu-dark text-small shadow"  aria-labelledby="dropdownUser1">
        <li><a class="dropdown-item" href="#">Perfil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Logout</a></li>
      </ul>
    </div>
  </div>
  <div class="d-flex align-items-start d-sm-none d-md-block">
        <button id="botao-menu" width='32' height='32' class='rounded-circle me-2 botao-menu' ><i class="fa-solid fa-bars"></i></button>
    </div>
    
</div>
@endsection

@section('links')
<script src="{{ asset('js/sistema.js') }}"></script>
@endsection