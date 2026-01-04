// Hide/Show navbar on scroll
let lastScrollTop = 0;
const navbar = document.getElementById('mainNavbar');
const scrollThreshold = 100;

function toggleMobileMenu() {
    const menu = document.querySelector('.navbar-menu-bar');
    const icon = document.querySelector('.nav-toggle-btn i');

    menu.classList.toggle('active');
    document.body.classList.toggle('menu-open');

    // Toggle icon class
    if (menu.classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
        icon.style.transform = 'rotate(90deg)';
    } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Mobile Dropdown Toggle
document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.navbar-dropdown > .navbar-link');
    dropdowns.forEach(link => {
        link.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                this.parentElement.classList.toggle('active');
            }
        });
    });
});

window.addEventListener('scroll', function () {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > scrollThreshold) {
        if (scrollTop > lastScrollTop) {
            // Scrolling down
            navbar.classList.add('navbar-hidden');
        } else {
            // Scrolling up
            navbar.classList.remove('navbar-hidden');
        }
    } else {
        // At the top of the page
        navbar.classList.remove('navbar-hidden');
    }

    lastScrollTop = scrollTop;
});

// Set active link on page load
window.addEventListener('load', () => {
    // Determine primary route segment: '/blogs/123' -> 'blogs'
    const pathSegments = window.location.pathname.split('/').filter(Boolean);
    const primaryRoute = pathSegments.length > 0 ? pathSegments[0] : 'home';

    // Map empty path to 'home'
    const routeKey = primaryRoute === '' ? 'home' : primaryRoute;

    // Set active based on data-route attribute
    document.querySelectorAll('.navbar-link').forEach(link => {
        const linkRoute = link.getAttribute('data-route');
        if (linkRoute === routeKey) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
});

// Add active class on click
document.querySelectorAll('.navbar-link').forEach(link => {
    link.addEventListener('click', function () {
        document.querySelectorAll('.navbar-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    });
});

// Toggle search overlay
function toggleSearch() {
    const searchOverlay = document.getElementById('searchOverlay');
    searchOverlay.classList.toggle('active');

    if (searchOverlay.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// Toggle language menu
function toggleLanguageMenu() {
    const languageMenu = document.getElementById('languageMenu');
    const languageSwitcher = document.querySelector('.language-switcher');
    languageMenu.classList.toggle('active');
    languageSwitcher.classList.toggle('active');
}

// Switch language
function switchLanguage(locale) {
    document.getElementById('localeInput').value = locale;
    document.querySelector('.language-form').submit();
}

// Close language menu when clicking outside
document.addEventListener('click', function (e) {
    const languageSwitcher = document.querySelector('.language-switcher');
    const languageMenu = document.getElementById('languageMenu');

    if (languageSwitcher && !languageSwitcher.contains(e.target)) {
        languageMenu.classList.remove('active');
        languageSwitcher.classList.remove('active');
    }
});

// Close search on ESC key
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const searchOverlay = document.getElementById('searchOverlay');
        if (searchOverlay.classList.contains('active')) {
            toggleSearch();
        }

        const languageMenu = document.getElementById('languageMenu');
        const languageSwitcher = document.querySelector('.language-switcher');
        if (languageMenu.classList.contains('active')) {
            languageMenu.classList.remove('active');
            languageSwitcher.classList.remove('active');
        }
    }
});
