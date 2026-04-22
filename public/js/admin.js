document.addEventListener('DOMContentLoaded', () => {
    document.body.style.opacity = '1';
});

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    if (window.innerWidth <= 992) {
        sidebar.classList.toggle('mobile-open');

        // Handle overlay if we decide to add one dynamically or toggle a class on body
    } else {
        sidebar.classList.toggle('collapsed');
    }
}

function filterBookings() {
    const searchInput = document.getElementById('bookingSearch');
    if (!searchInput) return;
    const term = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('.booking-row');
    rows.forEach(row => {
        const searchData = row.getAttribute('data-search') || '';
        row.style.display = searchData.includes(term) ? '' : 'none';
    });
}
