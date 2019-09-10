@extends('layouts.myapp')

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Clientes</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">{{ $title }}</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('dashboard.components.filter')
                </div>
            </div>
            @if($items->count())
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped mt-3 text-center table-responsive-sm">
                                    <thead>
                                    {{ $tableHeader  }}
                                    </thead>
                                    <tbody>
                                    {{ $tableBody }}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        {{ $items->appends(request()->query->all())->links() }}
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                Nenhum registro encontrado.
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @include('dashboard.components.modals')
        </div>
    </div>
@endsection