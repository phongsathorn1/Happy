@include('components.head')
<body>
    <div id="app" class="app">
        <nav class="navbar global-nav navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('home') }}">Timeline</a></li>
                        <li><a href="{{ route('discover') }}">Discover</a></li>
                        <li><a href="{{ route('upload') }}">Upload</a></li>
                    </ul>
                    <div class="navbar-left">
                        <div class="dropdown">
                            <form class="navbar-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search" placeholder="Search">
                                </div>
                                <ul id="search-result" class="dropdown-menu search-result">
                                </ul>
                            </form>
                        </div>
                    </div>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('user/' . (is_null(Auth::user()->username) ? Auth::user()->id : Auth::user()->username)) }}">View Profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    <div class="footer">
        <span>Developed by Phongsathron Kittiworapanya</span><br>
        <a href="https://www.facebook.com/Phongsathron.co.th/posts/1606505196079510"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Development note</a>
        <div class="contact-list">
            <a href="mailto:phongsathron@outlook.com"><i class="fa fa-envelope" aria-hidden="true"></i> Email</a>
            <a href="https://www.linkedin.com/in/phongsathron/"><i class="fa fa-linkedin" aria-hidden="true"></i> LinkedIn</a>
            <a href="https://www.facebook.com/Phongsathron.co.th"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
