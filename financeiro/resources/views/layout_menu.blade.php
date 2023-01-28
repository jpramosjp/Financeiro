@extends('layout')
@section('conteudo')
<div class="d-flex">
    <div id= "menu-lateral" class="d-flex flex-column flex-shrink-0 p-3 text-white custom-gradient menu-lateral " style="width: 280px;">
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
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
        
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-dark custom-gradient topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="botao-menu" class="btn btn-link d-md-none rounded-circle mr-3 text-white">
                <i class="fa fa-bars"></i>
            </button>

            

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">


                <!-- Nav Item - Alerts -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <span class="badge badge-danger badge-counter">3+</span>
                    </a>
                </li>

                <!-- Nav Item - Messages -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope fa-fw"></i>
                        <!-- Counter - Messages -->
                        <span class="badge badge-danger badge-counter">7</span>
                    </a>
                </li>


            </ul>

        </nav>
    @yield('dados')
        </div>
        <footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Ramos 2022</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->
    </div>  
</div>
@endsection

@section('links')
<script src="{{ asset('js/sistema.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
@endsection