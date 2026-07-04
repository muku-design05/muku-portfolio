<?php get_header(); ?>

<main id="top">

    <section class="hero">
        <div class="hero__bg"></div>

        <div class="container hero__inner">

            <div class="hero__content">
                <p class="hero__label">PORTFOLIO</p>

                <h1 class="hero__title">
                    Digital<br>
                    Designer
                </h1>

                <p class="hero__text">
                    Web design, visual communication,<br>
                    and thoughtful creative production.
                </p>
            </div>

            <div class="hero__visual">
                <div class="hero__metal"></div>
                <div class="hero__glass"></div>
            </div>

            <a href="#works" class="hero__scroll" aria-label="Worksへ移動">
                <span></span>
            </a>

        </div>
    </section>

    <section id="works" class="works">
        <div class="container">

            <h2 class="section-title">Works</h2>

            <nav class="works-category" aria-label="作品カテゴリー">
                <ul>
                    <li><a href="#works-web">WEB</a></li>
                    <li><a href="#works-banner">BANNER</a></li>
                    <li><a href="#works-graphic">GRAPHIC</a></li>
                    <li><a href="#works-video">VIDEO</a></li>
                </ul>
            </nav>

            <div class="works-pickup">
                <a href="#" class="work-card">
                    <div class="work-card__image">
                        <span>WEB</span>
                    </div>
                </a>

                <a href="#" class="work-card">
                    <div class="work-card__image">
                        <span>BANNER</span>
                    </div>
                </a>

                <a href="#" class="work-card">
                    <div class="work-card__image">
                        <span>GRAPHIC</span>
                    </div>
                </a>

                <a href="#" class="work-card">
                    <div class="work-card__image">
                        <span>VIDEO</span>
                    </div>
                </a>
            </div>

            <div class="works-link">
                <a href="#">View all works →</a>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>