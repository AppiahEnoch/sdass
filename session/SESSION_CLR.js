// Clear sessionStorage
sessionStorage.clear();

// Clear localStorage
localStorage.clear();

// Clear all cookies
document.cookie.split(";").forEach(function(c) {
    document.cookie = c.trim().replace(/=.*/, "=;expires=" + new Date(0).toUTCString() + ";path=/");
});
