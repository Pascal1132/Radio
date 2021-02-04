<!doctype html>

<html>

<head>

    @include('includes.cms.head')

</head>

<body>
<header>
    @include('includes.cms.header')
</header>

<div class="container-fluid">

    @if(session('user') !== null)
        <div class="row">
            <div class="col-2 bg-light sidebar pl-2">
                <div class="sidebar-sticky p-lg-1 p-0">
                    <ul class="nav flex-column text-center text-md-left">
                        <li class="nav-item">
                            <a class="nav-link @yield('home_menu')" href="{{route('cms.home')}}" title="Accueil"><i
                                    class="fas fa-home fa-xs"></i>
                                <span class="d-none d-md-inline">Accueil</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link @yield('command_menu')" href="{{route('cms.command')}}"
                               title="Propriété de la commande"><i class="fas fa-terminal fa-xs"></i>
                                <span class="d-none d-md-inline"> Commande </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link @yield('channel_menu')" href="{{route('cms.channels')}}"
                               title="Liste des chaines"><span class="iconify" data-icon="entypo:radio" data-inline="false"></span>
                                <span class="d-none d-md-inline"> Chaînes </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link @yield('range_menu')" href="{{route('cms.range')}}"
                               title="Range des fréquences possibles"><i class="fas fa-exchange-alt"></i>
                                <span class="d-none d-md-inline"> Range </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-10 main">
                <h3 class="page-title">@yield('page_title')</h3>
                <hr>
                @foreach ($errors->all() as $error)
                    <div style="margin-left: -16px; margin-right: -24px;" class="mt-1 ">
                        <div class="main__content notice-flash">
                            <div class="notification red">
                                <b>Erreur : </b>{{ $error }}</div>
                        </div>
                    </div>
                @endforeach
                @if (\Session::has('succes'))
                    <div style="margin-left: -16px; margin-right: -24px;" class="m-1">
                        <div class="main__content notice-flash">
                            <div class="notification green">
                                <b>Note: </b> {!! \Session::get('succes') !!}</div>
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>

        </div>
    @else
        @yield('content')
    @endif


</div>
<footer class="footer">
    @include('includes.cms.footer')
</footer>
</body>

</html>
