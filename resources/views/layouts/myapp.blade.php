<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>Conecta WhatsApp</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport'/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/x-icon"/>
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div :class="['wrapper', {sidebar_minimize: menuToggled}]" id="app">
    <div class="main-header">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="purple">

            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('img/logo-white.svg') }}" width="90%" alt="navbar brand" class="navbar-brand">
            </a>
            <!--                    <span class="text-white" style="font-size: 1.08rem;">Conecta WhatsApp</span>-->
            <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <i class="fa fa-navicon"></i>
                        </span>
            </button>
            <button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
            <div class="nav-toggle">
                <button @click.prevent="toggleMenu" :class="['btn btn-toggle', {toggled: menuToggled}]">
                    <i v-if="menuToggled" class="fa fa-ellipsis-v"></i>
                    <i v-else class="fa fa-navicon"></i>
                </button>
            </div>
        </div>
        <!-- End Logo Header -->

        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-expand-lg" data-background-color="purple2">

            <div class="container-fluid">
                <!--                        <div class="collapse" id="search-nav">
                                            <form class="navbar-left navbar-form nav-search mr-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="submit" class="btn btn-search pr-1">
                                                            <i class="fa fa-search search-icon"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" placeholder="Search ..." class="form-control">
                                                </div>
                                            </form>
                                        </div>-->
                <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                    <!--                            <li class="nav-item toggle-nav-search hidden-caret">
                                                    <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                </li>-->
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="helpDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-question-circle"></i>
                            <!--                                    <span class="notification">4</span>-->
                        </a>
                        <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="helpDropdown">
                            <li>
                                <div class="dropdown-title">Tutoriais</div>
                            </li>
                            <li>
                                @php
                                    $tutorials = [
                                        [
                                            'title' => 'Configurando mensagens',
                                            'link' => 'https://www.youtube.com/embed/FEduWGWKO0o',
                                            'icon' => 'envelope',
                                            'color' => 'primary'
                                        ],
                                        [
                                            'title' => 'Adicionando gateway',
                                            'link' => 'https://www.youtube.com/embed/_ZPbsx7FSCs',
                                            'icon' => 'credit-card-alt',
                                            'color' => 'success'
                                        ]
                                    ];
                                @endphp
                                <div class="notif-scroll scrollbar-outer">
                                    <div class="notif-center">
                                        @foreach($tutorials as $tutorial)
                                            <a href="#" @click.prevent="openTutorial({{ json_encode($tutorial) }})">
                                                <div class="notif-icon notif-{{ $tutorial['color'] }}"><i
                                                            class="fa fa-{{ $tutorial['icon'] }}"></i>
                                                </div>
                                                <div class="notif-content">
                                                        <span class="block">
                                                            {{ $tutorial['title'] }}
                                                        </span>
                                                    <span class="time">Assistir agora</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            {{--<span class="notification">4</span>--}}
                        </a>
                        {{--<ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">--}}
                        {{--<li>--}}
                        {{--<div class="dropdown-title">You have 4 new notification</div>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<div class="notif-scroll scrollbar-outer">--}}
                        {{--<div class="notif-center">--}}
                        {{--<a href="#">--}}
                        {{--<div class="notif-icon notif-primary"><i class="fa fa-user-plus"></i></div>--}}
                        {{--<div class="notif-content">--}}
                        {{--<span class="block">--}}
                        {{--New user registered--}}
                        {{--</span>--}}
                        {{--<span class="time">5 minutes ago</span>--}}
                        {{--</div>--}}
                        {{--</a>--}}
                        {{--<a href="#">--}}
                        {{--<div class="notif-icon notif-success"><i class="fa fa-comment"></i></div>--}}
                        {{--<div class="notif-content">--}}
                        {{--<span class="block">--}}
                        {{--Rahmad commented on Admin--}}
                        {{--</span>--}}
                        {{--<span class="time">12 minutes ago</span>--}}
                        {{--</div>--}}
                        {{--</a>--}}
                        {{--<a href="#">--}}
                        {{--<div class="notif-img">--}}
                        {{--<img src="{{ asset('img/profile2.jpg') }}" alt="Img Profile">--}}
                        {{--</div>--}}
                        {{--<div class="notif-content">--}}
                        {{--<span class="block">--}}
                        {{--Reza send messages to you--}}
                        {{--</span>--}}
                        {{--<span class="time">12 minutes ago</span>--}}
                        {{--</div>--}}
                        {{--</a>--}}
                        {{--<a href="#">--}}
                        {{--<div class="notif-icon notif-danger"><i class="fa fa-heart"></i></div>--}}
                        {{--<div class="notif-content">--}}
                        {{--<span class="block">--}}
                        {{--Farrah liked Admin--}}
                        {{--</span>--}}
                        {{--<span class="time">17 minutes ago</span>--}}
                        {{--</div>--}}
                        {{--</a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a class="see-all" href="javascript:void(0);">See all notifications<i--}}
                        {{--class="fa fa-angle-right"></i> </a>--}}
                        {{--</li>--}}
                        {{--</ul>--}}
                    </li>
                    <li class="nav-item dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="avatar-sm">
                                <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('img/profile.jpg') }}"
                                     alt="..." class="avatar-img rounded-circle">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg"><img
                                                    src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('img/profile.jpg') }}"
                                                    alt="image profile" class="avatar-img rounded"></div>
                                        <div class="u-text">
                                            <h4>{{ Auth::user()->name }}</h4>
                                            <p class="text-muted">{{ Auth::user()->email }}</p><a
                                                    href="{{ route('profile.index') }}"
                                                    class="btn btn-xs btn-secondary btn-sm">Meu Perfil</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('profile.password') }}">Alterar senha</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button style="cursor: pointer;" class="btn-link dropdown-item">Logout</button>
                                    </form>

                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="avatar-sm float-left mr-2">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('img/profile.jpg') }}"
                             alt="..." class="avatar-img rounded-circle">
                    </div>
                    <div class="info">
                        <a>
                                    <span class="pt-2">
                                        <strong>{{ Auth::user()->name }}</strong>
                                    </span>
                        </a>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <ul class="nav nav-secondary">
                    @include('layouts.menu')
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">

        @yield('content')
        <div class="modal fade" id="modalTutorial" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div v-if="itemTutorial !== null" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">
                            <i :class="['fa', 'fa-' + itemTutorial.icon, 'text-' + itemTutorial.color]"></i> @{{ itemTutorial.title }}
                        </h5>
                        <button type="button" class="close" @click.prevent="closeTutorial">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <iframe width="100%" height="315" :src="itemTutorial.link" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!--   Core JS Files   -->
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>

    @if(session('message'))
    $.notify({
        icon: 'fa fa-check',
        title: 'Sucesso',
        message: '{{ session('message') }}',
    }, {
        type: 'success',
        placement: {
            from: "bottom",
            align: "right"
        },
        time: 1000
    });
    @elseif(session('error'))
    $.notify({
        icon: 'fa fa-exclamation-triangle',
        title: 'Aviso',
        message: '{{ session('error') }}',
    }, {
        type: 'danger',
        placement: {
            from: "bottom",
            align: "right"
        },
        time: 1000
    });
    @endif


    @foreach($errors->all() as $error)
    $.notify({
        icon: 'fa fa-exclamation-triangle',
        title: 'Aviso',
        message: '{{ $error }}',
    }, {
        type: 'danger',
        placement: {
            from: "bottom",
            align: "right"
        },
        time: 1000
    });
    @endforeach
</script>
@yield('javascript')
</body>

</html>