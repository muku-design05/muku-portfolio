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

   
    <section id="about" class="about">
    <div class="container">

        <h2 class="section-title">About</h2>

        <div class="about__body">

            <!-- About Me -->
            <section class="about-block about-block--profile">
                <h3 class="about-block__title">About me</h3>

                <div class="about-block__content about__profile-text">
                    <p class="about__name">
                        安保　椋 <span>Muku Anbo</span>
                    </p>

                    <p class="about__text">
                        Webデザインを中心に、バナー、販促物、動画制作など幅広い制作を行っています。<br>
                        限られたスペースの中でも情報が伝わることを意識し、見やすさと使いやすさを大切にしたデザインを心がけています。
                    </p>
                </div>
            </section>


            <!-- Experience / Strength / Tools -->
            <div class="about__grid">

                <!-- Experience -->
                <section class="about-block">
                    <h3 class="about-block__title">Experience</h3>

                    <div class="about-block__content">
                        <div class="about__experience">
                            <p>2022 — 2025</p>
                            <p>In-house Designer</p>
                            <p>Web / Banner / Graphic</p>
                            <p>/ Video</p>
                        </div>

                        <div class="about__experience">
                            <p>2025 — Present</p>
                            <p>Digital Designer</p>
                            <p>Web / App / Creative</p>
                        </div>
                    </div>
                </section>


                <!-- Strength / Tools -->
                <div class="about__side">

                    <!-- Strength -->
                    <section class="about-block">
                        <h3 class="about-block__title">Strength</h3>

                        <div class="about-block__content">
                            <ul class="about-list">
                                <li>Information Design</li>
                                <li>Visual Communication</li>
                                <li>Multi-format Creative</li>
                            </ul>
                        </div>
                    </section>


                    <!-- Tools -->
                    <section class="about-block">
                        <h3 class="about-block__title">Tools</h3>

                        <div class="about-block__content">
                            <ul class="about-tools">
                                <li>Photoshop</li>
                                <li>Figma</li>
                                <li>Illustrator</li>
                                <li>HTML / CSS</li>
                                <li>Premiere Pro</li>
                                <li>WordPress</li>
                                <li>After Effects</li>
                            </ul>
                        </div>
                    </section>

                </div>

            </div>


            <!-- Explorations -->
            <section class="about-block about-block--explorations">
                <h3 class="about-block__title">Explorations</h3>

                <div class="about-block__content">
                    <div class="explorations">

                        <a href="#" class="exploration-card">
                            <div class="exploration-card__image"></div>
                            <p>illust</p>
                        </a>

                        <a href="#" class="exploration-card">
                            <div class="exploration-card__image"></div>
                            <p>logo</p>
                        </a>

                    </div>
                </div>
            </section>

        </div>

    </div>
</section>

<section id="contact" class="contact">
    <div class="container">

        <h2 class="section-title">Contact</h2>

        <p class="contact__text">Let's work together.</p>

        <a href="mailto:anbo.muku@gmail.com" class="contact__mail">
            <span class="contact__icon">✉</span>
            <span>anbo.muku@gmail.com</span>
        </a>

    </div>
</section>




</main>

<?php get_footer(); ?>