@extends('layouts.app')

@section('content')

<div class="login-form">
    @if ($errors->getMessages())
        <div class="alert-danger mb-2">
            Usuário/senha inválido
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">  
        @csrf
        <div class="form-group form-floating-label">
            <input id="username" name="email" value="{{ old('email') }}" type="text" class="form-control input-border-bottom" required>
            <label for="username" class="placeholder">Domínio</label>
        </div>
        <div class="form-group form-floating-label">
            <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
            <label for="password" class="placeholder">Senha</label>
            <div class="show-password">
                <i class="icon-eye"></i>
            </div>
        </div>
        <div class="row form-sub m-0">
            <div class="custom-control custom-checkbox">
                <input name="remember" type="checkbox" class="custom-control-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">Lembrar-me</label>
            </div>

<!--            <a href="#" class="link float-right">Esqueceu a senha?</a>-->
        </div>
        <div class="form-action mb-3">
            <button class="btn btn-primary btn-rounded btn-login">Entrar</button>
        </div>
        <div class="login-account">
            <span class="msg">Não tem conta ainda?</span>
            <a href="{{ route('install.start') }}" id="show-signup" class="link">Inscrever-se agora</a>
        </div>
    </form>
</div>
@endsection
