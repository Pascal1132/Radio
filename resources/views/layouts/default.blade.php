<!doctype html>

<html>

<head>

    @include('includes.default.head')

</head>

<body antialiased>

<header>
    @include('includes.default.header')
</header>

    <div class="container-fluid">
            @yield('content')
    </div>

<footer class="footer">
    @include('includes.default.footer')
</footer>
</body>

</html>
