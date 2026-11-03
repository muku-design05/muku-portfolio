<?php get_header(); ?>

<main id="top">

    <section class="hero">
        <div class="hero__scale-wrap">
            <div class="hero__bg"></div>

            <div class="container hero__inner">

                <div class="hero__main">

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

                </div>

                <a href="#works" class="hero__scroll" aria-label="Worksへ移動">
                    <span></span>
                </a>
            </div>
        </div>
    </section>

    <section id="works" class="works">
        <div class="section-3d section-3d--works-chrome" aria-hidden="true"></div>
        
            <div class="container">

                <h2 class="section-title">Works</h2>

                <nav class="works-category" aria-label="作品カテゴリー">
                    <ul>
                        <li>
                            <a href="<?php echo esc_url(home_url('/works/#works-web')); ?>">
                                WEB
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo esc_url(home_url('/works/#works-banner')); ?>">
                                BANNER
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo esc_url(home_url('/works/#works-graphic')); ?>">
                                GRAPHIC
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo esc_url(home_url('/works/#works-video')); ?>">
                                VIDEO
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="works-pickup">

                    <?php
                    $works_categories = array(
                        'web' => array(
                            'label' => 'WEB',
                            'alt'   => 'Web制作実績',
                        ),
                        'banner' => array(
                            'label' => 'BANNER',
                            'alt'   => 'バナー制作実績',
                        ),
                        'graphic' => array(
                            'label' => 'GRAPHIC',
                            'alt'   => 'グラフィック制作実績',
                        ),
                        'video' => array(
                            'label' => 'VIDEO',
                            'alt'   => '動画制作実績',
                        ),
                    );

                    foreach ($works_categories as $key => $category) :

                        $image_ids = get_option(
                            'muku_top_works_' . $key . '_ids',
                            array()
                        );

                        if (!is_array($image_ids)) {
                            $image_ids = array();
                        }

                    ?>

                        <a
                            href="<?php echo esc_url(home_url('/works/#' . $key)); ?>"
                            class="work-card"
                        >
                            <div class="work-card__image">

                                <?php if (!empty($image_ids)) : ?>

                                    <div class="work-card__slides">

                                        <?php foreach ($image_ids as $index => $image_id) : ?>

                                            <?php
                                            $image_html = wp_get_attachment_image(
                                                absint($image_id),
                                                'large',
                                                false,
                                                array(
                                                    'alt'   => $category['alt'],
                                                    'class' => 'work-card__slide-image',
                                                )
                                            );

                                            if (!$image_html) {
                                                continue;
                                            }
                                            ?>

                                            <div class="work-card__slide<?php echo $index === 0 ? ' is-active' : ''; ?>">
                                                <?php echo $image_html; ?>
                                            </div>

                                        <?php endforeach; ?>

                                    </div>

                                <?php else : ?>

                                    <img
                                        src="<?php echo esc_url(
                                            get_template_directory_uri() .
                                            '/assets/images/works-' . $key . '.jpg'
                                        ); ?>"
                                        alt="<?php echo esc_attr($category['alt']); ?>"
                                        class="work-card__slide-image"
                                    >

                                <?php endif; ?>

                                <span><?php echo esc_html($category['label']); ?></span>

                            </div>
                        </a>

                    <?php endforeach; ?>

                </div>

                <div class="works-link">
                    <a href="<?php echo esc_url(home_url('/works/')); ?>">
                        View all works →
                    </a>
                </div>

            </div>
        </section>

    <div class="about-contact-wrap">

    <div class="section-3d section-3d--explorations-chrome" aria-hidden="true"></div>
    <section id="about" class="about">
        
        <div class="section-3d section-3d--about-glass" aria-hidden="true"></div>
        
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
                            <p>2022.04 — 2025.07</p>
                            <p>Webデザイナー</p>
                            <p>Webサイト・バナー・販促物・動画制作など</p>
                        </div>

                        <div class="about__experience">
                            <p>2025.09 — 現在</p>
                            <p>Webデザイナー</p>
                            <p>Webサイト・アプリ・バナー制作など</p>
                        </div>
                    </div>
                </section>


                <!-- Strength / Tools -->
                <div class="about__side">



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

            <!-- Skill Map / My Strengths -->
            <div class="about__skills-grid">

                <!-- Skill Map -->
                <section class="about-block about-block--skillmap">

                    <h3 class="about-block__title">Skill Map</h3>

                    <div class="about-block__content">

                        <button
                            type="button"
                            class="about__skillmap"
                            aria-label="スキルマップを拡大表示"
                            aria-haspopup="dialog"
                        >
                            <?php
                            echo wp_get_attachment_image(
                                130,
                                'full',
                                false,
                                array(
                                    'class' => 'about__skillmap-image',
                                    'alt'   => '制作経験と今後広げたい領域を示したスキルマップ',
                                )
                            );
                            ?>
                        </button>

                    </div>

                </section>

                <!-- Skill Map Modal -->
                <div
                    class="skillmap-modal"
                    role="dialog"
                    aria-modal="true"
                    aria-label="スキルマップの拡大表示"
                    aria-hidden="true"
                    hidden
                >
                    <button
                        type="button"
                        class="skillmap-modal__close"
                        aria-label="閉じる"
                    >
                        ×
                    </button>

                    <div class="skillmap-modal__inner">
                        <?php
                        echo wp_get_attachment_image(
                            130,
                            'full',
                            false,
                            array(
                                'class' => 'skillmap-modal__image',
                                'alt'   => '制作経験と今後広げたい領域を示したスキルマップ',
                            )
                        );
                        ?>
                    </div>
                </div>

            <!-- My Strengths -->
            <section class="about-block about-block--strengths">
                <h3 class="about-block__title">My Strengths</h3>

                <div class="about-block__content">
                    <div class="about__strengths">

                        <div class="about__strength">
                            <h4 class="about__strength-title">01. 情報設計・伝達力</h4>
                            <p class="about__strength-text">
                                Webサイトやバナー、販促物、動画など、さまざまな媒体の制作に携わってきました。
                                制作では、伝えたい情報を整理し、何を優先して見せるべきかを考えることを大切に
                                しています。文字量やレイアウト、表現方法を工夫し、見る人にとって分かりやすい
                                デザインを心がけています。
                            </p>
                        </div>

                        <div class="about__strength">
                            <h4 class="about__strength-title">02. 表現設計・提案力</h4>
                            <p class="about__strength-text">
                                制作物の目的やターゲットに合わせて、配色や書体、素材などを選んできました。
                                販促フライヤーでは、情報を詰め込むのではなく、文章を減らしてイラストで
                                伝える方法を提案。実際に採用され、制作に反映されました。
                            </p>
                        </div>

                        <div class="about__strength">
                            <h4 class="about__strength-title">03. 適応力・学習意欲</h4>
                            <p class="about__strength-text">
                                前職ではグラフィックや動画制作を幅広く経験し、
                                現職ではWebサイトやアプリのデザインを担当しています。
                                制作する媒体や求められる表現が変わっても、必要な知識や
                                技術を学びながら対応してきました。現在はWordPressを学び、
                                自身のポートフォリオサイトも制作しています。
                            </p>
                        </div>

                    </div>
                </div>
            </section>

        </div><!-- /.about__skills-grid -->

            <!-- Explorations -->
            <section class="about-block about-block--explorations">
                <h3 class="about-block__title">Explorations</h3>

                <div class="about-block__content">
                    <div class="explorations">

                        <div class="exploration-card">
                            <div class="exploration-card__image">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/exploration-sculpture.jpg'); ?>" alt="彫刻作品">
                            </div>
                            <p>Sculpture</p>
                        </div>

                        <div class="exploration-card">
                            <div class="exploration-card__image">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/exploration-3dcg.jpg'); ?>" alt="Mayaで制作した3DCG作品">
                            </div>
                            <p>3DCG</p>
                        </div>

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

        <a href="mailto:anbmk0525@gmail.com" class="contact__mail">
            <span class="contact__icon">✉</span>
            <span>anbmk0525@gmail.com</span>
        </a>

    </div>
</section>

</div>


</main>

<?php get_footer(); ?>