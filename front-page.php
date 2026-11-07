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

                <div class="about__grid">
                <!-- About Me -->
                <section class="about-block about-block--profile">
                    <h3 class="about-block__title">
                        About me
                        <span class="about-block__title-ja">自己紹介</span>
                    </h3>

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


            

                <!-- Experience -->
                <section class="about-block">

                    <h3 class="about-block__title">
                        Experience
                        <span class="about-block__title-ja">経歴</span>
                    </h3>

                    <div class="about-block__content">
                        
                    <div class="about__experience">
                        <p class="about__experience-date">2022.04 — 2025.07</p>
                        <p class="about__experience-company">株式会社ADI.G</p>
                        <p>Webデザイナー</p>
                        <p>バナー・販促物・動画制作、Webサイト更新など</p>
                    </div>

                    <div class="about__experience">
                        <p class="about__experience-date">2025.09 — 現在</p>
                        <p class="about__experience-company">株式会社レンサ</p>
                        <p>Webデザイナー</p>
                        <p>Webサイト・アプリのデザイン、バナー制作など</p>
                    </div>



                    </div>
                </section>


                <!-- Tools -->
                <section class="about-block">
                        <h3 class="about-block__title">
                            Tools
                            <span class="about-block__title-ja">使用ツール</span>
                        </h3>

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

                


                <!-- Skill Map -->
                <section class="about-block about-block--skillmap">

                    <h3 class="about-block__title">
                        Skill Map
                        <span class="about-block__title-ja">スキルマップ</span>
                    </h3>

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
            </div><!-- /.about__grid -->

            <!-- My Strengths -->
            <section class="about-block about-block--strengths">
                <h3 class="about-block__title">
                    My Strengths
                    <span class="about-block__title-ja">私の強み</span>
                </h3>

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
                                制作物の目的やターゲットを踏まえ、配色・書体・素材選定からレイアウトまで、
                                主体的に考え制作を進めてきました。媒体に応じた表現方法を検討し、
                                必要に応じて改善提案も行っています。
                                <br><br>
                                販促フライヤーでは、文章量を減らしイラストで伝える方法を提案し、
                                実際に採用されました。また、動画制作では構成検討から素材の準備、
                                撮影・編集まで一貫して担当。幅広い制作経験を活かし、
                                目的に合った表現を考え、形にすることを強みとしています。
                            </p>
                        </div>

                        <div class="about__strength">
                            <h4 class="about__strength-title">03. 課題発見・連携力</h4>
                            <p class="about__strength-text">
                                歯科医院向けの操作説明動画では、初心者が理解しやすい内容にするため、
                                当初の制作指示だけでは説明が不十分になると考え、
                                ディレクターに改善と工数の追加を提案しました。
                                <br><br>
                                制作では実際に製品を操作し、疑問点や分かりにくい箇所を確認。
                                営業担当者と説明内容をすり合わせながら、文章やアニメーション表現を調整し、
                                関係者と連携して制作を進めました。
                            </p>
                        </div>

                        <div class="about__strength">
                            <h4 class="about__strength-title">04. 適応力・学習意欲</h4>
                            <p class="about__strength-text">
                                前職ではグラフィックや動画制作を幅広く経験し、
                                現職ではWebサイトやアプリのデザインを担当しています。
                                制作する媒体や求められる表現が変わっても、必要な知識や
                                技術を学びながら対応してきました。
                                <br><br>
                                現在はWordPressや生成AIを活用したWebサイト制作にも取り組み、
                                自身のポートフォリオサイトをオリジナルテーマで制作しています。
                            </p>
                        </div>


                    </div>
                </div>
            </section>


            <!-- Explorations -->
            <section class="about-block about-block--explorations">
                <h3 class="about-block__title">
                    Explorations
                    <span class="about-block__title-ja">自主制作</span>
                </h3>

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