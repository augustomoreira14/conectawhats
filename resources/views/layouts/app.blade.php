<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Login</title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/x-icon"/>

        <!-- CSS Files -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body class="login">
        <div class="wrapper wrapper-login">
            <div class="container container-login animated fadeIn">
                <div class="row justify-content-center">
                    <div class="col-5 mb-2">
                        <img src="{{ asset('img/logo-login.png') }}" style="width: 100%"/>
                    </div>
                </div>
                <h2 class="text-center">Conecta WhatsApp</h2>        
                @yield('content')
            </div>
        </div>

        <script src="{{ asset('js/main.js') }}"></script>
    </body>

</html>