document.addEventListener('DOMContentLoaded', function () {

    const cards = document.querySelectorAll('.works-pickup .work-card');

    cards.forEach(function (card, cardIndex) {

        const slides = card.querySelectorAll('.work-card__slide');

        // 画像が1枚以下なら切り替えない
        if (slides.length <= 1) {
            return;
        }

        let currentIndex = 0;

        // カードごとに開始タイミングをずらす
        const startDelay = cardIndex * 900;

        setTimeout(function () {

            setInterval(function () {

                slides[currentIndex].classList.remove('is-active');

                currentIndex = (currentIndex + 1) % slides.length;

                slides[currentIndex].classList.add('is-active');

            }, 4500);

        }, startDelay);

    });

});