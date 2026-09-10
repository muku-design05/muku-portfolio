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



/* =========================
Work Detail Accordion
========================= */

const accordionTriggers = document.querySelectorAll(
    ".work-detail__accordion-trigger"
);

accordionTriggers.forEach((trigger) => {

    trigger.addEventListener("click", () => {

        if (window.innerWidth > 767) {
            return;
        }

        const content = trigger.nextElementSibling;

        if (!content) {
            return;
        }

        const isOpen = trigger.classList.toggle("is-open");

        trigger.setAttribute(
            "aria-expanded",
            isOpen ? "true" : "false"
        );

        content.classList.toggle("is-open", isOpen);

    });

});


/* =========================
Work Modal Pinch Zoom
========================= */

const modalImage = document.querySelector(
    ".work-detail__modal-image"
);

if (modalImage && workModal) {

    let scale = 1;

    let startScale = 1;
    let startDistance = 0;

    let translateX = 0;
    let translateY = 0;

    let startTranslateX = 0;
    let startTranslateY = 0;

    let startCenterX = 0;
    let startCenterY = 0;

    let isDragging = false;

    let dragStartX = 0;
    let dragStartY = 0;

    let dragStartTranslateX = 0;
    let dragStartTranslateY = 0;


    const getTouchDistance = (touches) => {

        const x =
            touches[0].clientX - touches[1].clientX;

        const y =
            touches[0].clientY - touches[1].clientY;

        return Math.hypot(x, y);

    };


    const getTouchCenter = (touches) => {

        return {
            x:
                (touches[0].clientX +
                    touches[1].clientX) / 2,

            y:
                (touches[0].clientY +
                    touches[1].clientY) / 2
        };

    };


    const updateTransform = () => {

        modalImage.style.transform =
            `translate(${translateX}px, ${translateY}px) scale(${scale})`;

    };


    /*
     * タッチ開始
     * 2本指はモーダル内のどこからでもOK
     */
    workModal.addEventListener(
        "touchstart",
        (e) => {

            /*
             * 拡大中の画像を1本指で移動
             * 画像そのものに触れた場合だけ
             */
            if (
                e.touches.length === 1 &&
                scale > 1 &&
                e.target === modalImage
            ) {

                isDragging = true;

                dragStartX = e.touches[0].clientX;
                dragStartY = e.touches[0].clientY;

                dragStartTranslateX = translateX;
                dragStartTranslateY = translateY;

                return;
            }


            /*
             * 2本指でなければ何もしない
             */
            if (e.touches.length !== 2) {
                return;
            }

            isDragging = false;

            startDistance =
                getTouchDistance(e.touches);

            startScale = scale;

            startTranslateX = translateX;
            startTranslateY = translateY;

            const center =
                getTouchCenter(e.touches);

            startCenterX = center.x;
            startCenterY = center.y;

        },
        { passive: true }
    );


    /*
     * タッチ移動
     */
    workModal.addEventListener(
        "touchmove",
        (e) => {

            /*
             * 1本指ドラッグ
             */
            if (
                e.touches.length === 1 &&
                isDragging &&
                scale > 1
            ) {

                e.preventDefault();

                translateX =
                    dragStartTranslateX +
                    (e.touches[0].clientX - dragStartX);

                translateY =
                    dragStartTranslateY +
                    (e.touches[0].clientY - dragStartY);

                updateTransform();

                return;
            }


            /*
             * 2本指でなければ何もしない
             */
            if (e.touches.length !== 2) {
                return;
            }

            e.preventDefault();


            /* 拡大・縮小 */

            const currentDistance =
                getTouchDistance(e.touches);

            scale =
                startScale *
                (currentDistance / startDistance);

            scale = Math.min(
                Math.max(scale, 1),
                4
            );


            /* 2本指の移動 */

            const center =
                getTouchCenter(e.touches);

            translateX =
                startTranslateX +
                (center.x - startCenterX);

            translateY =
                startTranslateY +
                (center.y - startCenterY);


            /* 最小サイズなら元の位置へ */

            if (scale === 1) {
                translateX = 0;
                translateY = 0;
            }


            updateTransform();

        },
        { passive: false }
    );


    /*
     * 指を離したら1本指ドラッグ終了
     */
    workModal.addEventListener(
        "touchend",
        () => {

            isDragging = false;

        }
    );

}

function updateHeroScale() {
    const width = window.innerWidth;

    if (width >= 769 && width <= 1367) {
        const scale = width / 1920;
        document.documentElement.style.setProperty('--hero-scale', scale);
    } else {
        document.documentElement.style.setProperty('--hero-scale', 1);
    }
}

updateHeroScale();
window.addEventListener('resize', updateHeroScale);

/* =========================
   Works 3D Scroll
========================= */

const worksChrome = document.querySelector(".section-3d--works-chrome");
const worksSection = document.querySelector(".works");


if (worksChrome && worksSection) {

    function updateWorksChrome() {

        const rect = worksSection.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        const startPoint = windowHeight * 0.5;

        const progress =
        (startPoint - rect.top) /
        rect.height;

        const clampedProgress = Math.min(Math.max(progress, 0), 1);

        const rotate = clampedProgress * -180;
        const moveY =
        clampedProgress *
        (worksSection.offsetHeight - worksChrome.offsetHeight);
        

       worksChrome.style.transform =
            `translateY(${moveY}px) rotate(${rotate}deg)`;
        
        
       
    }

    updateWorksChrome();
    window.addEventListener("scroll", updateWorksChrome);
}

/* =========================
   About 3D Scroll
========================= */

const aboutGlass = document.querySelector(".section-3d--about-glass");
const aboutSection = document.querySelector(".about");

if (aboutGlass && aboutSection) {

    function updateAboutGlass() {

        const rect = aboutSection.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        const startPoint = windowHeight * 0.4;

        const progress =
            (startPoint - rect.top) /
            rect.height;

        const clampedProgress = Math.min(Math.max(progress, 0), 1);

        const rotate = clampedProgress * 180;

        const moveY =
            clampedProgress *
            (aboutSection.offsetHeight - aboutGlass.offsetHeight) * 1.1;

        const stopY = 760;

        const limitedMoveY = Math.min(moveY, stopY);

        aboutGlass.style.transform =
        `translateY(${limitedMoveY}px) rotate(${rotate}deg)`;
    }

    updateAboutGlass();
    window.addEventListener("scroll", updateAboutGlass);
}

/* =========================
   Explorations 3D Scroll
========================= */

const explorationsChrome = document.querySelector(".section-3d--explorations-chrome");
const explorationsSection = document.querySelector(".about-block--explorations");

if (explorationsChrome && explorationsSection) {

    function updateExplorationsChrome() {

        const rect = explorationsSection.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        const isSP = window.innerWidth <= 768;

        const startPoint = windowHeight * (isSP ? 0.7 : 0.5);

        const progress =
            (startPoint - rect.top) /
            rect.height;

        const clampedProgress = Math.min(Math.max(progress, 0), 1);

       

        const rotate = Math.max(progress, 0) * (isSP ? -40 : -85);
        const moveY = Math.max(progress, 0) * (isSP ? 300 : 500);
        const stopY = 820;

        const limitedMoveY = Math.min(moveY, stopY);

        explorationsChrome.style.transform =
            `translateY(${limitedMoveY}px) rotate(${rotate}deg)`;
    }

    updateExplorationsChrome();
    window.addEventListener("scroll", updateExplorationsChrome);
}