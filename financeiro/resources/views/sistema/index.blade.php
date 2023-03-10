@extends('layout_menu')

@section('dados')
            <!-- Content Wrapper -->
<form id="formOption" method="post">
    <input type="hidden" name="mesEscolhido" id="mesEscolhido">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
<!-- Main Content -->
<div id= "dados_pie" style="visibility: hidden;">
@php
    $contador = 0;
@endphp
@foreach($tipoDespesa as $key => $valor)
    <input type="hidden" value="{{$key}},{{$valor[0]}},{{$valor[1]}}"> 
@endforeach

</div>

    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <select id="selectMes" class="form-select form-control-sm w-100 ">
                    @foreach($mesesSelect as $key => $valor)
                        @php
                            $select = ($valor['mes'] == $mesEscolhido) ? 'selected' : '';
                        @endphp
                        <option {{$select}} value="{{$valor['mes']}}">{{strtoupper($valor['nome'])}}</option>
                    @endforeach
                </select>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-end border-top border-bottom border-4 shadow h-100 py-2" style="border-color: blue;" >
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Receitas </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{$totalReceita}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-end border-top border-bottom border-4 shadow h-100 py-2" style="border-color: red;" >
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: red;">
                                    Despesas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{$totalDespesa}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-cash-register fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-end border-top border-bottom border-4 shadow h-100 py-2" style="border-color: #36b9cc;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rela????o Receita com Despesa
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$porcentagemDespesaReceita}}%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{$porcentagemDespesaReceita}}%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-calculator fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-end border-top border-bottom border-4 shadow h-100 py-2" style="border-color: #1cc88a;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Dinheiro Guardado</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{number_format($totalDinheiroGuardado, 2, ',', '.')}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-piggy-bank fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">Grafico de Gasto por tipo de Despesa</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold ">Total de despesa</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                        @foreach($tipoDespesa as $key => $valor)
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: {{$valor[1]}};"></i> {{$key}}
                            </span>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Descri????o de Despesas</h6>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive d-flex flex-wrap">
                    @foreach($tipoDespesa as $key => $valor)
                      
                        <div class="card m-3 dados_despesa">
                            <div class="card-header nome_despesa" style="background-color: {{$valor[1]}};">
                                <h6>{{$key}}</h6>
                            </div>
                            <div class="card-body cardinho">
                            <table class="table table-striped table-bordered">
                            <tr>
                                <td>Nome</td>
                                <td>Valor</td>
                                <td>Vencimento</td>
                            </tr>
                            @foreach($cadaDespesaUsuario as $dado)
                                @if($dado->nome_tipo_despesa == $key)
                                    <tr>
                                        <td>{{$dado->nome_despesa}}</td>
                                        <td class="valores_despesa">R$ {{number_format($dado->valor, 2, ',', '.')}}</td>
                                        <td>{{$dado->data_vencimento}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </table>
                            </div>
                        </div>
                    @endforeach    
                </div>

                
            </div>
        </div>



<!-- End of Main Content -->

<!-- Footer -->

<!-- End of Content Wrapper -->

@endsection
