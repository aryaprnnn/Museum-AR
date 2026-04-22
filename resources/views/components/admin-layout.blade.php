<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} - ARtifact Museum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="sidebar-toggle" onclick="toggleSidebar()" style="margin-right: 10px;"><i class="fas fa-angle-left"></i></button>
            <div style="display:flex;align-items:center;gap:10px;flex:1">
                <i class="fas fa-museum"></i>
                <span>Admin Panel</span>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.blogs.index') }}" class="{{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}"><i class="fas fa-blog"></i> Blogs</a></li>
            <li><a href="{{ route('admin.collections.index') }}" class="{{ request()->routeIs('admin.collections.*') ? 'active' : '' }}"><i class="fas fa-icons"></i> Collections</a></li>
            <li><a href="{{ route('admin.artclasses.index') }}" class="{{ request()->routeIs('admin.artclasses.*') ? 'active' : '' }}"><i class="fas fa-palette"></i> Art Classes</a></li>
            <li><a href="{{ route('admin.educational.index') }}" class="{{ request()->routeIs('admin.educational.*') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Educational Programs</a></li>
            <li><a href="{{ route('admin.exhibitions.index') }}" class="{{ request()->routeIs('admin.exhibitions.*') ? 'active' : '' }}"><i class="fas fa-images"></i> Exhibitions</a></li>
            <li><a href="{{ route('admin.about-contents.index') }}" class="{{ request()->routeIs('admin.about-contents.*') ? 'active' : '' }}"><i class="fas fa-info-circle"></i> About Contents</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Users</a></li>
            <li style="border-top:1px solid #333;margin-top:10px;padding-top:10px">
                <form method="POST" action="{{ route('admin.logout') }}" style="margin:0" onsubmit="return confirm('Are you sure you want to logout?');">
                    @csrf
                    <button type="submit" style="width:100%;background:none;border:none;color:#ccc;text-align:left;padding:12px 20px;cursor:pointer;font:inherit;transition:all 0.2s" onmouseover="this.style.background='#333';this.style.color='#fff'" onmouseout="this.style.background='none';this.style.color='#ccc'">
                        <i class="fas fa-sign-out-alt" style="margin-right:10px;width:20px"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <div class="main-content" id="mainContent">
        <div class="top-bar">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <h1>{{ $title ?? 'Dashboard' }}</h1>
            </div>
            <div class="top-bar-controls">
                <span>Welcome, {{ session('admin')['name'] ?? 'Admin' }}</span>
            </div>
        </div>
        {{ $slot }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>
