@extends('layouts.myapp')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Configuração</h4>
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
                    <a href="{{ url()->current() }}">Gateways</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalCadastro">
                    <i class="fa fa-plus"></i> Novo
                </button>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped mt-3 text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">ClienteID</th>
                                    <th colspan="2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->cliente_id }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('gateways.destroy', [$item->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Tem certeza?')" class="btn btn-link"><i class="fa fa-trash fa-2x text-danger" aria-hidden="true"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                {{ $items->appends(request()->query->all())->links() }}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- Modal -->
                <div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus text-success" aria-hidden="true"></i> Gateway</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="formCadastro" action="{{ route('gateways.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="input_type">Tipo</label>
                                                <select name="type" class="form-control" id="input_type">
                                                    @foreach($types as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="input_cliente_id">ClientID</label>
                                                <input class="form-control" type="text" name="cliente_id" id="input_cliente_id"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="input_token">Token (Secret)</label>
                                                <input class="form-control" type="password" name="token" id="input_token"/>
                                            </div>                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button form="formCadastro" class="btn btn-success">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection