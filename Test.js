window.addEventListener("scroll", function() {
    var navbar = document.getElementById("navbar");
    if (window.pageYOffset > 0) {
        navbar.classList.add("solid-box-scroll");
    } else {
        navbar.classList.remove("solid-box-scroll");
    }
});