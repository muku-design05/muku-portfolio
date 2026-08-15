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


/* =========================
   Works Gallery
========================= */

const workGallery = document.querySelector(".work-detail__gallery");

if (workGallery) {
    const mainImage = workGallery.querySelector(".work-detail__main-image-file");
    const thumbnails = workGallery.querySelectorAll(".work-detail__thumbnail");
    const mainArea = workGallery.querySelector(".work-detail__main");
    const originalMainMarkup = mainArea.innerHTML;

    console.log(mainImage);
    console.log(thumbnails);

    thumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener("click", () => {

        /* YouTubeサムネイルをクリックしたとき */
        if (thumbnail.dataset.type === "youtube") {
            const youtubeId = thumbnail.dataset.youtubeId;

            workGallery.classList.add("is-youtube");

            mainArea.innerHTML = `
                <div class="work-detail__youtube-frame">
                    <iframe
                        src="https://www.youtube.com/embed/${youtubeId}"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                    ></iframe>
                </div>
            `;

            return;
        }

        /* 画像サムネイルをクリックしたとき */
        const index = thumbnail.dataset.index;
        const fullImage = thumbnail.dataset.full;

        /* YouTube表示中なら画像表示に戻す */
        if (workGallery.classList.contains("is-youtube")) {
            mainArea.innerHTML = originalMainMarkup;
            workGallery.classList.remove("is-youtube");
        }

        const currentMainImage = mainArea.querySelector(
            ".work-detail__main-image-file"
        );

        currentMainImage.src = fullImage;
        currentMainImage.removeAttribute("srcset");
        currentMainImage.dataset.currentIndex = index;
    });
});

}


/* =========================
   Work Detail Image Modal
========================= */

const workMainImage = document.querySelector(".work-detail__main-image");
const workMainImageFile = document.querySelector(".work-detail__main-image-file");
const workModal = document.querySelector(".work-detail__modal");
const workModalImage = document.querySelector(".work-detail__modal-image");
const workModalClose = document.querySelector(".work-detail__modal-close");

if (
    workMainImage &&
    workMainImageFile &&
    workModal &&
    workModalImage &&
    workModalClose
) {

    document.addEventListener("click", (e) => {

    const imageButton = e.target.closest(".work-detail__main-image");

    if (!imageButton) {
        return;
    }

    const currentMainImageFile = imageButton.querySelector(
        ".work-detail__main-image-file"
    );

    if (!currentMainImageFile) {
        return;
    }

    workModalImage.src = currentMainImageFile.src;

    workModal.classList.add("is-open");
    workModal.setAttribute("aria-hidden", "false");

    document.body.style.overflow = "hidden";
    document.documentElement.style.overflow = "hidden";

    });

    workModalClose.addEventListener("click", () => {

        workModal.classList.remove("is-open");
        workModal.setAttribute("aria-hidden", "true");

        document.body.style.overflow = "";
        document.documentElement.style.overflow = "";

    });


    workModal.addEventListener("click", (e) => {

    if (
        e.target === workModal ||
        e.target.classList.contains("work-detail__modal-inner")
    ) {

        workModal.classList.remove("is-open");
        workModal.setAttribute("aria-hidden", "true");

        document.body.style.overflow = "";
        document.documentElement.style.overflow = "";

    }

    });


    document.addEventListener("keydown", (e) => {

    if (
        e.key === "Escape" &&
        workModal.classList.contains("is-open")
    ) {

        workModal.classList.remove("is-open");
        workModal.setAttribute("aria-hidden", "true");

        document.body.style.overflow = "";
        document.documentElement.style.overflow = "";

    }

    });
}