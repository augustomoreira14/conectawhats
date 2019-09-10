<li class="nav-item {{ url(request()->getPathInfo()) == route('dashboard') ?  'active' : ''}}">
    <a href="{{ route('dashboard') }}">
        <i class="fa fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>
<li :class="['nav-item', {'submenu':isMenuConfig}]">
    <a data-toggle="collapse" href="#messages-app-nav" :class="{'collapsed':!isMenuConfig}" :aria-expanded="isMenuConfig">
        <i class="fa fa-cog"></i>
        <p>Configurações</p>
        <span class="caret"></span>
    </a>
    <div :class="['collapse', {'show':isMenuConfig}]" id="messages-app-nav" style="">
        <ul class="nav nav-collapse">
            <li :class="{'active':(pathName === '/messages')}">
                <a href="{{ route('messages.index') }}">
                    <span class="sub-item">Mensagens</span>
                </a>
            </li>
            <li :class="{'active':(pathName === '/gateways')}">
                <a href="{{ route('gateways.index') }}">
                    <span class="sub-item">Gateways</span>
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-section">
    <span class="sidebar-mini-icon">
        <i class="fa fa-ellipsis-h"></i>
    </span>
    <h4 class="text-section">Clientes</h4>
</li>

<li class="nav-item {{ url(request()->getPathInfo()) == route('pendings') ?  'active' : ''}}">
    <a href="{{ route('pendings') }}">
        <i class="fa fa-clock-o" aria-hidden="true"></i>
        <p>Aguardando Contato</p>
        <span class="badge badge-count">{{ \App\ConectaWhats\SideDish\Application\CustomerService::totalPendings() }}</span>
    </a>
</li>
<li class="nav-item {{ url(request()->getPathInfo()) == route('contacteds') ?  'active' : ''}}">
    <a href="{{ route('contacteds') }}">
        <i class="fa fa-whatsapp" aria-hidden="true"></i>
        <p>Contactados</p>
        <span class="badge badge-count">{{ \App\ConectaWhats\SideDish\Application\CustomerService::totalContacteds() }}</span>
    </a>
</li>
<li class="nav-item {{ url(request()->getPathInfo()) == route('followup') ?  'active' : ''}}">
    <a href="{{ route('followup') }}">
        <i class="fa fa-retweet" aria-hidden="true"></i>
        <p>Follow Up</p>
        <span class="badge badge-count">{{ \App\ConectaWhats\SideDish\Application\CustomerService::totalFollowup() }}</span>
    </a>
</li>
<li class="nav-item {{ url(request()->getPathInfo()) == route('converteds') ?  'active' : ''}}">
    <a href="{{ route('converteds') }}">
        <i class="fa fa-handshake-o" aria-hidden="true"></i>
        <p>Convertidos</p>
        <span class="badge badge-count">{{ \App\ConectaWhats\SideDish\Application\CustomerService::totalConverteds() }}</span>
    </a>
</li>
<li class="nav-section">
    <span class="sidebar-mini-icon">
        <i class="fa fa-ellipsis-h"></i>
    </span>
    <h4 class="text-section">Dúvidas?</h4>
</li>
<li class="nav-item">
    <a href="http://m.me/conectawhatsapp" target="_blank">
        <i class="fa fa-life-ring" aria-hidden="true"></i>
        <p>Suporte</p>
    </a>
</li>
