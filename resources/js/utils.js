// Debounce function to limit how often a function can be called
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Update URL query parameters without page reload
function updateQueryParams(params) {
    const url = new URL(window.location.href);
    Object.entries(params).forEach(([key, value]) => {
        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }
    });
    window.history.pushState({}, "", url);
}

// Format date to YYYY-MM-DD
function formatDate(date) {
    return date.toISOString().split("T")[0];
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(amount);
}

// Export functions for use in other files
window.debounce = debounce;
window.updateQueryParams = updateQueryParams;
window.formatDate = formatDate;
window.formatCurrency = formatCurrency;
