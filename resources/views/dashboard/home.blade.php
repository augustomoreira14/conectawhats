@extends('layouts.myapp')

@section('content')
<div class="content">
    <div class="panel-header bg-secondary-gradient">
        <div class="page-inner pt-5 pb-5">
            <h2 class="text-white pb-2">Bem vindo {{ Auth::user()->name }}, bom vê-lo por aqui!</h2>
            <!--            <h5 class="text-white op-7 mb-2">Yesterday I was clever, so I wanted to change the world. Today I am wise, so I am changing myself.</h5>-->
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row row-card-no-pd mt--2">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fa fa-clock-o text-danger" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Aguardando</p>
                                    <h4 class="card-title">{{ $totalPendings }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i style="color: #28a745;" class="fa fa-whatsapp" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Contactados</p>
                                    <h4 class="card-title">{{ $totalContacteds }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fa fa-retweet text-warning" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Follow Up</p>
                                    <h4 class="card-title">{{ $totalFollowups }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fa fa-handshake-o text-success" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Convertidos</p>
                                    <h4 class="card-title">{{ $totalConverteds }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Convertido nos últimos 7 dias</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="lineChart" data-statistics='@json($statistics)'></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-secondary">
                    <div class="card-header">
                        <div class="card-title">Convertidos no mês</div>
                        <div class="card-category">Início do mês até {{ now()->format('d/m/Y') }}</div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="mb-4 mt-2">
                            <h1>R$ {{ number_format($totalConvertedsMonth, 2, ',', '.') }}</h1>
                        </div>
                        <!--                        <div class="pull-in">
                                                    <canvas id="dailySalesChart"></canvas>
                                                </div>-->
                    </div>
                </div>
                <div class="card card-primary bg-primary-gradient">
                    <div class="card-body">
                        <h4 class="mb-1 fw-bold">Taxa de convertidos nos últimos 7 dias</h4>
                        <div id="task-complete" class="chart-circle mt-4 mb-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/home.js') }}"></script>
@endsection