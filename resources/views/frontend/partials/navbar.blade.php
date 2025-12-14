{{-- TOP HORIZONTAL NAVIGATION - LOUVRE STYLE --}}
<nav class="navbar-museum" id="mainNavbar">
    <div class="navbar-top-bar">
        <div class="navbar-left">
            <button class="nav-search-btn" onclick="toggleSearch()">
                <i class="fas fa-search"></i>
                <span>{{ __('nav.search') }}</span>
            </button>
            
            {{-- Language Switcher --}}
            <div class="language-switcher">
                <button class="language-btn" onclick="toggleLanguageMenu()">
                    <i class="fas fa-globe"></i>
                    <span id="currentLanguage">{{ app()->getLocale() == 'id' ? 'Indonesia' : 'English' }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="language-menu" id="languageMenu">
                    <form method="POST" action="{{ route('language.switch') }}" class="language-form">
                        @csrf
                        <input type="hidden" name="locale" id="localeInput">
                        <button type="button" onclick="switchLanguage('en')" class="language-option {{ app()->getLocale() == 'en' ? 'active' : '' }}">
                            English
                        </button>
                        <button type="button" onclick="switchLanguage('id')" class="language-option {{ app()->getLocale() == 'id' ? 'active' : '' }}">
                            Indonesia
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="navbar-center">
            <a href="{{ route('home') }}" class="navbar-logo">
                <h1>ARtifact Museum</h1>
            </a>
        </div>

        <div class="navbar-right">
            <a href="{{ route('contact') }}" class="nav-btn nav-btn-outline">
                <i class="fas fa-envelope"></i>
                <span>{{ __('nav.contact') }}</span>
            </a>
            <a href="#" class="nav-btn nav-btn-primary">
                <i class="fas fa-user"></i>
                <span>Login / Register</span>
            </a>
        </div>
    </div>

    <div class="navbar-menu-bar">
        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}" class="navbar-link" data-route="home">{{ strtoupper(__('nav.home')) }}</a></li>
            <li><a href="{{ route('about') }}" class="navbar-link" data-route="about">{{ strtoupper(__('nav.about')) }}</a></li>
            <li><a href="{{ route('blogs') }}" class="navbar-link" data-route="blogs">{{ strtoupper(__('nav.blogs')) }}</a></li>
            <li><a href="{{ route('search') }}" class="navbar-link" data-route="search">{{ strtoupper(__('nav.collections')) }}</a></li>
        </ul>
    </div>
</nav>

{{-- SEARCH OVERLAY --}}
<div class="search-overlay" id="searchOverlay">
    <div class="search-container">
        <button class="search-close" onclick="toggleSearch()">
            <i class="fas fa-times"></i>
        </button>
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <input type="text" name="q" placeholder="{{ __('nav.search_placeholder') }}" class="search-input" autofocus>
            <button type="submit" class="search-submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

{{-- External Stylesheet --}}
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

{{-- External JavaScript --}}
<script src="{{ asset('js/navbar.js') }}"></script>
