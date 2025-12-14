// Hide/Show navbar on scroll
let lastScrollTop = 0;
const navbar = document.getElementById('mainNavbar');
const scrollThreshold = 100;

window.addEventListener('scroll', function() {
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
    const currentRoute = window.location.pathname.split('/').pop() || 'home';
    const navLinks = document.querySelectorAll('.navbar-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href.includes(currentRoute) || (currentRoute === '' && href.includes('home'))) {
            link.classList.add('active');
        }
    });
});

// Add active class on click
document.querySelectorAll('.navbar-link').forEach(link => {
    link.addEventListener('click', function() {
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
document.addEventListener('click', function(e) {
    const languageSwitcher = document.querySelector('.language-switcher');
    const languageMenu = document.getElementById('languageMenu');
    
    if (languageSwitcher && !languageSwitcher.contains(e.target)) {
        languageMenu.classList.remove('active');
        languageSwitcher.classList.remove('active');
    }
});

// Close search on ESC key
document.addEventListener('keydown', function(e) {
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
