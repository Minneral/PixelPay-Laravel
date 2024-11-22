<!doctype html>
<html>

<head>
    @include('includes.head')
    @yield('styles')
    @vite([
        'resources/scss/header.scss',
        'resources/scss/footer.scss',
        'resources/scss/dropdown.scss',
        ])
</head>

<body>
    <div class="wrapper">
        <header class="header">
            @include('includes.header')
        </header>

        <div class="main">
            @yield('content')
        </div>

        <footer class="footer">
            @include('includes.footer')
        </footer>
    </div>
    @yield('scripts')
</body>

</html>
