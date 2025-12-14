// Blog category filter
function filterByCategory(category) {
    if (category === 'semua') {
        window.location.href = blogsRoute;
    } else {
        window.location.href = blogsRoute + '?category=' + category;
    }
}
