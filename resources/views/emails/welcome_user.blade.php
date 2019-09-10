@component('emails.message')

<p style="margin-top: 20px;"><strong>Olá <span class="text-primary">{{ $name }}</span>, tudo bem?</strong></p>

<p>Estamos muito satisfeitos com sua chegada!</p>
<p>Parabéns, agora sua loja está conectada à nossa plataforma e vamos fazer o possível para tornar a sua experiência conosco incrível.</p>
<p>Abaixo estão seus dados de acesso:</p>
<p><strong>Login:</strong> {{ $login }}</p>
<p><strong>Senha:</strong> {{ $password }}</p>

@component('mail::button', ['url' => route('login')])
Acessar
@endcomponent

<p>Abraços, <br> Equipe Conecta WhatsApp</p>
@endcomponent