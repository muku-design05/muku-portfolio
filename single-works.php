<?php get_header(); ?>

<main class="work-detail">

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <?php
            $role         = get_field('role');
            $tools        = get_field('tools');
            $year         = get_field('year');
            $period       = get_field('period');
            $project_type = get_field('project_type');
            $overview     = get_field('overview');
            $challenge    = get_field('challenge');
            $design_point = get_field('design_point');
            $main_image   = get_field('main_image');
            $live_url     = get_field('live_url');

            $gallery_ids = get_post_meta(
                get_the_ID(),
                '_works_gallery_ids',
                true
            );

            $gallery_positions = get_post_meta(
                get_the_ID(),
                '_works_gallery_positions',
                true
            );

            if (!is_array($gallery_positions)) {
                $gallery_positions = array();
            }

            $youtube_url = get_post_meta(
                get_the_ID(),
                '_works_youtube_url',
                true
            );


            $youtube_id = '';

            if ($youtube_url) {

                $youtube_parts = wp_parse_url($youtube_url);

                if (
                    isset($youtube_parts['host']) &&
                    strpos($youtube_parts['host'], 'youtu.be') !== false
                ) {

                    $youtube_id = isset($youtube_parts['path'])
                        ? trim($youtube_parts['path'], '/')
                        : '';

                } elseif (
                    isset($youtube_parts['query'])
                ) {

                    parse_str(
                        $youtube_parts['query'],
                        $youtube_query
                    );

                    $youtube_id = $youtube_query['v'] ?? '';

                }

            }

            if (!is_array($gallery_ids)) {
                $gallery_ids = array_filter(
                array_map(
                'absint',
                explode(',', (string) $gallery_ids)
                    )
                );
            }

            $terms = get_the_terms(get_the_ID(), 'works_category');
            ?>

            <article class="work-detail__article">
                
                <nav class="work-detail__breadcrumb" aria-label="パンくずリスト">
                    <div class="container">
                        <a href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">
                            Works
                        </a>

                        <span aria-hidden="true">/</span>

                        <span aria-current="page">
                            <?php the_title(); ?>
                        </span>
                    </div>
                </nav>
                <!-- Works Title / Category Navigation -->
                <section class="work-detail__header">
                    <div class="container">

                        <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                            <p class="work-detail__category">
                                ✦ <?php echo esc_html($terms[0]->name); ?> ✦
                            </p>
                        <?php endif; ?>

                        <h2 class="work-detail__title">
                            <?php the_title(); ?>
                        </h2>

                    </div>
                </section>


                <!-- Main Image -->
                <section class="work-detail__visual">
                    <div class="container">

                        <?php if (!empty($gallery_ids)) : ?>

                            <div class="work-detail__gallery">

                                <div class="work-detail__slider">

                                    

                                    <div class="work-detail__main">

                                    

                                    <button
                                        type="button"
                                        class="work-detail__main-image"
                                    >

                                        <?php
                                        echo wp_get_attachment_image(
                                            $gallery_ids[0],
                                            'full',
                                            false,
                                            array(
                                                'class' => 'work-detail__main-image-file',
                                                'data-current-index' => '0'
                                            )
                                        );
                                        ?>

                                        <span class="work-detail__expand-icon">
                                            ⤢
                                        </span>

                                    </button>

                                    

                                </div>

                               
                                    
                            </div><!-- /.work-detail__slider -->
                                

                                <div class="work-detail__thumbnails">

                                    <?php foreach ($gallery_ids as $index => $image_id) : ?>

                                        <button
                                                class="work-detail__thumbnail"
                                                type="button"
                                                data-index="<?php echo esc_attr($index); ?>"
                                                data-full="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>"
                                            >

                                                <?php
                                                $thumbnail_position = $gallery_positions[$image_id] ?? 'center';

                                                $position_map = array(
                                                    'center' => 'center center',
                                                    'top'    => 'center top',
                                                    'bottom' => 'center bottom',
                                                    'left'   => 'left center',
                                                    'right'  => 'right center',
                                                );

                                                $object_position = $position_map[$thumbnail_position] ?? 'center center';

                                                echo wp_get_attachment_image(
                                                    $image_id,
                                                    'medium',
                                                    false,
                                                    array(
                                                        'style' => 'object-position: ' . esc_attr($object_position) . ';'
                                                    )
                                                );
                                                ?>

                                            </button>

                                    <?php endforeach; ?>

                                    <?php if ($youtube_id) : ?>

                                    <button
                                        class="work-detail__thumbnail work-detail__thumbnail--youtube"
                                        type="button"
                                        data-type="youtube"
                                        data-youtube-id="<?php echo esc_attr($youtube_id); ?>"
                                    >
                                        <img
                                            src="https://img.youtube.com/vi/<?php echo esc_attr($youtube_id); ?>/hqdefault.jpg"
                                            alt="YouTube動画"
                                        >

                                        <span class="work-detail__youtube-play">
                                            ▶
                                        </span>
                                    </button>

                                <?php endif; ?>

                                </div>

                            </div>

                        <?php endif; ?>

                    </div>
                </section>


                <!-- Image Modal -->
                <div class="work-detail__modal" aria-hidden="true">

                    <button
                        type="button"
                        class="work-detail__modal-close"
                        aria-label="画像を閉じる"
                    >
                        ×
                    </button>

                    <div class="work-detail__modal-inner">

                        <img
                            class="work-detail__modal-image"
                            src=""
                            alt=""
                        >

                    </div>

                </div>


                <!-- Basic Information -->
                <section class="work-detail__info">
                    <div class="container">

                        <div class="work-detail__info-grid">

                            <?php if ($role) : ?>
                                <section class="work-detail__info-card">

                                    <button
                                        type="button"
                                        class="work-detail__accordion-trigger"
                                        aria-expanded="false"
                                    >
                                        <span class="work-detail__info-title">
                                            ✦ Role <span>対応範囲</span>
                                        </span>

                                        <span class="work-detail__accordion-icon">
                                            ﹀
                                        </span>
                                    </button>

                                    <div class="work-detail__accordion-content">
                                        <p class="work-detail__info-text">
                                            <?php echo nl2br(esc_html($role)); ?>
                                        </p>
                                    </div>

                                </section>
                            <?php endif; ?>

                            <?php if ($tools) : ?>
                                <section class="work-detail__info-card">

                                    <button
                                        type="button"
                                        class="work-detail__accordion-trigger"
                                        aria-expanded="false"
                                    >
                                        <span class="work-detail__info-title">
                                            ✦ Tools <span>使用ツール</span>
                                        </span>

                                        <span class="work-detail__accordion-icon">
                                            ﹀
                                        </span>
                                    </button>

                                    <div class="work-detail__accordion-content">
                                        <p class="work-detail__info-text">
                                            <?php echo nl2br(esc_html($tools)); ?>
                                        </p>
                                    </div>

                                </section>
                            <?php endif; ?>

                            <?php if ($period || $year) : ?>
                                <section class="work-detail__info-card">

                                    <button
                                        type="button"
                                        class="work-detail__accordion-trigger"
                                        aria-expanded="false"
                                    >
                                        <span class="work-detail__info-title">
                                            ✦ Period <span>制作期間</span>
                                        </span>

                                        <span class="work-detail__accordion-icon">
                                            ﹀
                                        </span>
                                    </button>

                                    <div class="work-detail__accordion-content">
                                        <p class="work-detail__info-text">
                                            <?php if ($period) : ?>
                                                <?php echo nl2br(esc_html($period)); ?>
                                            <?php elseif ($year) : ?>
                                                <?php echo esc_html($year); ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                </section>
                            <?php endif; ?>

                            <?php if ($project_type) : ?>
                                <section class="work-detail__info-card">

                                    <button
                                        type="button"
                                        class="work-detail__accordion-trigger"
                                        aria-expanded="false"
                                    >
                                        <span class="work-detail__info-title">
                                            ✦ Project Type <span>プロジェクト種別</span>
                                        </span>

                                        <span class="work-detail__accordion-icon">
                                            ﹀
                                        </span>
                                    </button>

                                    <div class="work-detail__accordion-content">
                                        <p class="work-detail__info-text">
                                            <?php echo nl2br(esc_html($project_type)); ?>
                                        </p>
                                    </div>

                                </section>
                            <?php endif; ?>

                        </div>

                    </div>
                </section>


                <!-- Description -->
                <section class="work-detail__description">
                    <div class="container">

                        <?php if ($overview) : ?>
                            <section class="work-detail__text-block">

                                <button
                                    type="button"
                                    class="work-detail__accordion-trigger"
                                    aria-expanded="false"
                                >
                                    <span class="work-detail__text-title">
                                        ✦ Overview <span>概要</span>
                                    </span>

                                    <span class="work-detail__accordion-icon">
                                        ﹀
                                    </span>
                                </button>

                                <div class="work-detail__accordion-content">
                                    <p class="work-detail__text">
                                        <?php echo nl2br(esc_html($overview)); ?>
                                    </p>
                                </div>

                            </section>
                        <?php endif; ?>

                       <?php if ($challenge) : ?>
                            <section class="work-detail__text-block">

                                <button
                                    type="button"
                                    class="work-detail__accordion-trigger"
                                    aria-expanded="false"
                                >
                                    <span class="work-detail__text-title">
                                        ✦ Challenge <span>課題</span>
                                    </span>

                                    <span class="work-detail__accordion-icon">
                                        ﹀
                                    </span>
                                </button>

                                <div class="work-detail__accordion-content">
                                    <p class="work-detail__text">
                                        <?php echo nl2br(esc_html($challenge)); ?>
                                    </p>
                                </div>

                            </section>
                        <?php endif; ?>

                        <?php if ($design_point) : ?>
                            <section class="work-detail__text-block">

                                <button
                                    type="button"
                                    class="work-detail__accordion-trigger"
                                    aria-expanded="false"
                                >
                                    <span class="work-detail__text-title">
                                        ✦ Design Point <span>工夫点</span>
                                    </span>

                                    <span class="work-detail__accordion-icon">
                                        ﹀
                                    </span>
                                </button>

                                <div class="work-detail__accordion-content">
                                    <p class="work-detail__text">
                                        <?php echo nl2br(esc_html($design_point)); ?>
                                    </p>
                                </div>

                            </section>
                        <?php endif; ?>

                        <?php if ($live_url) : ?>
                            <div class="work-detail__live">
                                <a
                                    href="<?php echo esc_url($live_url); ?>"
                                    class="work-detail__live-link"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    View Site ↗
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </section>

            </article>

        <?php endwhile; ?>
    <?php endif; ?>

</main>

<?php get_footer(); ?>