@include('components.head')

<body class="login">
<div class="fullscreen-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 login-page">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>