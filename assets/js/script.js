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


/* =========================
   Back to Top
========================= */

const backToTop = document.querySelector(".back-to-top");

window.addEventListener("scroll", () => {

    if (window.scrollY > 300) {
        backToTop.classList.add("is-visible");
    } else {
        backToTop.classList.remove("is-visible");
    }

});

backToTop.addEventListener("click", () => {

    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });

});