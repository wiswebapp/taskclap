<header class="header header-three">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg header-nav">
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
                    <span class="bar-icon bar-icon-three">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <a href="{{ route('homepage') }}" class="navbar-brand logo">
                    <img src="/assets/img/taskclap-logo.svg" class="img-fluid" alt="Logo">
                </a>
                <a href="{{ route('homepage') }}" class="navbar-brand logo-small">
                    <img src="/assets/img/taskclap-logo.svg" class="img-fluid" alt="Logo">
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="{{ route('homepage') }}" class="menu-logo">
                        <img src="/assets/img/taskclap-logo.svg" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);"> <i class="fas fa-times"></i></a>
                </div>
                <ul class="main-nav">
                    <li><a href="{{ route('homepage') }}">Home</a></li>
                    <li><a href="/category/acappliance">Ac/Appliance</a></li>
                    <li><a href="/category/home-painter">Home Painter</a></li>
                    <li><a href="/category/salon-for-women">Salong For Women</a></li>
                    <li class="login-link">
                        <a href="choose-signup.html">Register As Provider</a>
                    </li>
                    @if (Auth::guest())
                    <li class="login-link">
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('login') }}?type=register">Register</a>
                    </li>
                    @else
                    <li class="login-link">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    @endif
                </ul>
            </div>
            <ul class="nav header-navbar-rht">
                <li class="nav-item">
                    @if (Auth::guest())
                    <div class="cta-btn">
                        <a class="btn" href="{{ route('login') }}?type=register"><i class="feather-users me-2"></i>REGISTER /</a>
                        <a class="btn ms-1" href="{{ route('login') }}">LOGIN</a>
                    </div>
                    @else
                    <div class="cta-btn">
                        <a class="btn" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="feather-log-out me-2"></i> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
</header>
