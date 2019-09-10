@extends('layouts.myapp')

@section('content')

<div class="content">
    <div class="page-inner">
        <h4 class="page-title">Atualizar Senha</h4>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-with-nav">
                    <div class="card-body">
                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Senha Antiga</label>
                                        <input type="password" class="form-control" name="old_password" placeholder="Senha Antiga" required>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Nova Senha</label>
                                        <input type="password" class="form-control" name="password" placeholder="Senha" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Confirme a senha</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirme a senha" required>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3 mb-3">
                                <button class="btn btn-success">Atualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection