{{-- TOP HORIZONTAL NAVIGATION - LOUVRE STYLE --}}
{{-- External Stylesheet - Moved to top to prevent FOUC --}}
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<nav class="navbar-museum" id="mainNavbar">
    <div class="navbar-top-bar">
        <div class="navbar-left">
            <button class="nav-search-btn" onclick="toggleSearch()">
                <i class="fas fa-search"></i>
                <span>Search</span>
            </button>
        </div>

        <div class="navbar-center">
            <a href="{{ route('home') }}" class="navbar-logo">
                <h1>ARtifact Museum</h1>
            </a>
        </div>

        <div class="navbar-right">
            <a href="{{ route('contact') }}" class="nav-btn nav-btn-outline">
                <i class="fas fa-envelope"></i>
                <span>Contact</span>
            </a>
                @if(session('auth_user'))
                <div class="nav-profile" style="position:relative">
                    <button class="nav-btn nav-btn-primary" onclick="toggleProfileMenu()">
                        <i class="fas fa-user-circle"></i>
                            <span>{{ session('auth_user')['name'] ?? 'Profile' }}</span>
                        <i class="fas fa-chevron-down" style="margin-left:6px;font-size:0.75rem"></i>
                    </button>
                    <ul class="profile-menu" id="profileMenu" style="display:none;position:absolute;right:0;top:100%;margin-top:8px;background:#fff;border:1px solid #ddd;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,0.1);min-width:200px;padding:8px 0;list-style:none;z-index:999">
                        <li style="padding:0"><a href="{{ route('user.dashboard') }}" style="display:block;padding:10px 16px;color:#333;text-decoration:none;transition:background 0.2s"><i class="fas fa-chart-line"></i> My Dashboard</a></li>
                        <li style="padding:0"><a href="{{ route('user.bookings') }}" style="display:block;padding:10px 16px;color:#333;text-decoration:none;transition:background 0.2s"><i class="fas fa-calendar-check"></i> My Bookings</a></li>
                        <li style="padding:0"><a href="{{ route('user.settings') }}" style="display:block;padding:10px 16px;color:#333;text-decoration:none;transition:background 0.2s"><i class="fas fa-cog"></i> Account Settings</a></li>
                        <li style="padding:0;border-top:1px solid #eee;margin-top:4px;padding-top:4px">
                          <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to logout?')" style="margin:0">
                            @csrf
                            <button type="submit" style="display:block;width:100%;padding:10px 16px;color:#d9534f;background:none;border:none;text-align:left;cursor:pointer;font:inherit;transition:background 0.2s"><i class="fas fa-sign-out-alt"></i> Logout</button>
                          </form>
                        </li>
                    </ul>
                </div>
            @else
                <div class="nav-auth">
                    <a href="{{ route('login') }}" class="nav-btn nav-btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="navbar-menu-bar">
        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}" class="navbar-link" data-route="home">HOME</a></li>
            <li><a href="{{ route('about') }}" class="navbar-link" data-route="about">ABOUT US</a></li>
            <li class="navbar-dropdown">
                <a href="#" class="navbar-link">
                    PROGRAMS
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu" style="opacity: 0; visibility: hidden; transform: translateX(-50%) translateY(-10px);">
                    <li><a href="{{ route('artclass') }}" class="dropdown-link">Art Class</a></li>
                    <li><a href="{{ route('exhibitions') }}" class="dropdown-link">Exhibitions</a></li>
                    <li><a href="{{ route('educational-program') }}" class="dropdown-link">Educational Program</a></li>
                </ul>
            </li>
            <li><a href="{{ route('search') }}" class="navbar-link" data-route="search">COLLECTIONS</a></li>
            <li><a href="{{ route('blogs') }}" class="navbar-link" data-route="blogs">BLOGS & ARTICLES</a></li>
        </ul>
    </div>
</nav>

{{-- SEARCH OVERLAY --}}
<div class="search-overlay" id="searchOverlay" style="visibility: hidden; opacity: 0; transform: translateY(100%);">
    <div class="search-container">
        <button class="search-close" onclick="toggleSearch()">
            <i class="fas fa-times"></i>
        </button>
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Search museum collections..." class="search-input" autofocus>
            <button type="submit" class="search-submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

</div>

{{-- External JavaScript --}}
<script src="{{ asset('js/navbar.js') }}"></script>
<script>
function toggleProfileMenu(){
    const m = document.getElementById('profileMenu');
    if(!m) return; m.style.display = (m.style.display==='none'||m.style.display==='') ? 'block' : 'none';
}
</script>
