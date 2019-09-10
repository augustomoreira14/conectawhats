<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/x-icon"/>
    <title>Conecta WhatsApp</title>
    <link rel="stylesheet" type="text/css" href="{{asset("theme-login/css/bootstrap.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("theme-login/css/fontawesome-all.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("theme-login/css/iofrm-style.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("theme-login/css/iofrm-theme9.css")}}">
</head>
<body>
    <div class="form-body">
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <h3>Nossa plataforma conecta você aos seus clientes através do WhatsApp.</h3>
                    <p>Use o WhatsApp para recuperar carrinhos abandonados e converter pedidos pendentes de maneira fácil e objetiva. </p>
                    <img src="{{ asset('img/graphic5.svg') }}" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <div class="website-logo-inside">
                            <a href="{{ url()->current() }}">
                                <div class="logo">
                                    <img src="{{ asset('img/logo4.png') }}" alt="">
                                </div>
                            </a>
                        </div>
                        @if($errors->getMessages())
                        <div class="alert alert-danger">
                            Insira um domínio válido.
                        </div>
                        @endif
                        <form action="{{ route('install.start') }}" method="POST">
                            @csrf
                            <label>Domínio Shopify</label>
                            <input class="form-control" type="text" name="shop" placeholder="sualoja.myshopify.com" required>
                            <div class="form-button">
                                <button onclick="cadastro()" id="submit" type="submit" class="ibtn mybutton" >Instalar Agora</button>
                                <legend class="text-white mt-1" style="font-size: 0.8rem;">15 dias grátis - Após o período gratuito $7,00/mês. Você não será cobrado caso queira cancelar durante o período gratuito.</legend>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('theme-login/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme-login/js/popper.min.js') }}"></script>
<script src="{{ asset('theme-login/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme-login/js/main.js') }}"></script>
<script>
    function cadastro(){
        //fbq('track', 'Lead');
    }
</script>
</body>

</html>