{{-- TOP HORIZONTAL NAVIGATION --}}
<nav class="navbar-top">
    <div class="navbar-container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <h2>Museum Virtual</h2>
        </a>
        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}" class="navbar-link" data-route="home">Home</a></li>
            <li><a href="{{ route('about') }}" class="navbar-link" data-route="about">About Us</a></li>
            <li><a href="{{ route('blogs') }}" class="navbar-link" data-route="blogs">Blogs</a></li>
            <li><a href="{{ route('search') }}" class="navbar-link" data-route="search">Collections</a></li>
            <li><a href="{{ route('contact') }}" class="navbar-link" data-route="contact">Contact</a></li>
        </ul>
    </div>
</nav>

<script>
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
</script>
