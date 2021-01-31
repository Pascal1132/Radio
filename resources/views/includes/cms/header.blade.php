<nav class="navbar navbar-expand-sm color-dark">
    <a class="navbar-brand" href="{{route('cms.home')}}"><i class="fas fa-broadcast-tower text-info"></i> {{config('app.name')}} | <span>CMS</span></a>

        <span class="navbar-nav ml-auto">

                <a class="nav-link text-light" href="">{{ session('user') ?? '' }}</a>

                <a class="nav-link" href="{{route('home')}}">Front-end <i class="fas fa-desktop"></i></a>

        </span>
</nav>
