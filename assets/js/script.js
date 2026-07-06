const hamburger = document.querySelector(".hamburger");
const headerNav = document.querySelector(".header-nav");
const navLinks = document.querySelectorAll(".header-nav a");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("is-active");
    headerNav.classList.toggle("is-active");

    const isOpen = hamburger.classList.contains("is-active");
    hamburger.setAttribute("aria-expanded", isOpen);
});

navLinks.forEach((link) => {
    link.addEventListener("click", () => {
        hamburger.classList.remove("is-active");
        headerNav.classList.remove("is-active");
        hamburger.setAttribute("aria-expanded", "false");
    });
});