<?php get_header(); ?>

<main class="works-archive">

    <section class="works-archive__hero">
        <div class="container">

            <h1 class="section-title">Works</h1>

            <nav class="works-archive__categories" aria-label="作品カテゴリー">
                <a href="#web">WEB</a>
                <a href="#banner">BANNER</a>
                <a href="#graphic">GRAPHIC</a>
                <a href="#video">VIDEO</a>
            </nav>

        </div>
    </section>


    <section class="works-archive__list">
        <div class="container">

            <?php
            $works_sections = array(
                'web' => 'WEB',
                'banner' => 'BANNER',
                'graphic' => 'GRAPHIC',
                'video' => 'VIDEO',
            );

            foreach ($works_sections as $slug => $label) :

                $works_query = new WP_Query(array(
                    'post_type'      => 'works',
                    'posts_per_page' => -1,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'works_category',
                            'field'    => 'slug',
                            'terms'    => $slug,
                        ),
                    ),
                ));
            ?>

                <section id="<?php echo esc_attr($slug); ?>" class="works-group">

                    <h2 class="works-group__title">
                        <?php echo esc_html($label); ?>
                    </h2>

                    <?php if ($works_query->have_posts()) : ?>

                        <div class="works-archive__grid">

                            <?php while ($works_query->have_posts()) : $works_query->the_post(); ?>

                            <article class="works-item">

                                <a
                                    href="<?php the_permalink(); ?>"
                                    class="works-item__thumbnail-link"
                                    aria-label="<?php echo esc_attr(get_the_title()); ?>の詳細を見る"
                                >
                                    <div class="works-item__thumbnail">

                                        <?php if (has_post_thumbnail()) : ?>

                                            <?php the_post_thumbnail('large'); ?>

                                        <?php else : ?>

                                            <div class="works-item__placeholder">
                                                No Image
                                            </div>

                                        <?php endif; ?>

                                    </div>
                                </a>

                                <div class="works-item__info">

                                    <?php
                                    $year = get_field('year');
                                    $role = get_field('role');
                                    ?>

                                    <?php if ($year) : ?>
                                        <p class="works-item__year">
                                            <?php echo esc_html($year); ?>
                                        </p>
                                    <?php endif; ?>

                                    <h3 class="works-item__title">
                                        <?php the_title(); ?>
                                    </h3>

                                    <?php if ($role) : ?>
                                        <p class="works-item__role">
                                            <?php echo esc_html($role); ?>
                                        </p>
                                    <?php endif; ?>

                                </div>

                            </article>

                            <?php endwhile; ?>

                        </div>

                    <?php else : ?>

                        <p class="works-group__empty">
                            作品はまだありません。
                        </p>

                    <?php endif; ?>

                </section>

            <?php
                wp_reset_postdata();
            endforeach;
            ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>