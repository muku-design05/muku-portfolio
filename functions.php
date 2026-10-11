<?php

function mukuportfolio_enqueue_styles() {
    wp_enqueue_style(
    'google-fonts',
    'https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap',
    array(),
    null
    );

    wp_enqueue_style(
        'reset',
        get_template_directory_uri() . '/assets/css/reset.css'
    );

    wp_enqueue_style(
        'style',
        get_template_directory_uri() . '/assets/css/style.css',
        array('reset')
    );

    wp_enqueue_style(
        'responsive',
        get_template_directory_uri() . '/assets/css/responsive.css',
        array('style')
    );
}

add_action('wp_enqueue_scripts', 'mukuportfolio_enqueue_styles');

function mukuportfolio_enqueue_scripts() {
    wp_enqueue_script(
        'muku-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array(),
        '1.0.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'mukuportfolio_enqueue_scripts');

/* =========================
   Theme Support
========================= */

function mukuportfolio_theme_setup() {
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'mukuportfolio_theme_setup');


/* =========================
   Custom Post Type
========================= */

function register_works_post_type() {

    register_post_type('works', array(

        'labels' => array(
            'name'          => 'Works',
            'singular_name' => 'Work',
        ),

        'public' => true,

        'has_archive' => true,

        'rewrite' => array(
            'slug' => 'works',
        ),

        'menu_position' => 5,

        'menu_icon' => 'dashicons-portfolio',

        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),

        'show_in_rest' => true,

    ));

}

add_action('init', 'register_works_post_type');


/* =========================
   Works Taxonomy
========================= */

function register_works_category_taxonomy() {

    register_taxonomy(
        'works_category',
        array('works'),
        array(
            'labels' => array(
                'name'          => 'Works Categories',
                'singular_name' => 'Works Category',
                'menu_name'     => 'Categories',
                'all_items'     => 'All Categories',
                'edit_item'     => 'Edit Category',
                'add_new_item'  => 'Add New Category',
            ),

            'public' => true,

            'hierarchical' => true,

            'show_in_rest' => true,

            'rewrite' => array(
                'slug' => 'works-category',
            ),
        )
    );
}

add_action('init', 'register_works_category_taxonomy');

/**
 * Works詳細用ギャラリー
 */
function muku_add_works_gallery_meta_box() {
    add_meta_box(
        'muku-works-gallery',
        'Work Gallery',
        'muku_render_works_gallery_meta_box',
        'works',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'muku_add_works_gallery_meta_box');


/**
 * ギャラリー入力欄を表示
 */
function muku_render_works_gallery_meta_box($post) {
    wp_nonce_field(
        'muku_save_works_gallery',
        'muku_works_gallery_nonce'
    );

    $gallery_ids = get_post_meta(
        $post->ID,
        '_works_gallery_ids',
        true
    );

    $gallery_positions = get_post_meta(
    $post->ID,
    '_works_gallery_positions',
    true
    );

    if (!is_array($gallery_positions)) {
        $gallery_positions = array();
    }

    if (!is_array($gallery_ids)) {
        $gallery_ids = array_filter(
            array_map(
                'absint',
                explode(',', (string) $gallery_ids)
            )
        );
    }

    $youtube_url = get_post_meta(
    $post->ID,
    '_works_youtube_url',
    true
    );


    ?>

    <div class="muku-works-gallery">

        <p class="muku-works-gallery__description">
            Works詳細ページに表示する画像を追加してください。
            ドラッグで順番を変更できます。
        </p>

        <input
            type="hidden"
            id="muku-works-gallery-ids"
            name="muku_works_gallery_ids"
            value="<?php echo esc_attr(implode(',', $gallery_ids)); ?>"
        >

        <input
            type="hidden"
            id="muku-works-gallery-positions"
            name="muku_works_gallery_positions"
            value=""
        >

        <ul
            id="muku-works-gallery-list"
            class="muku-works-gallery__list"
        >
            <?php foreach ($gallery_ids as $attachment_id) : ?>
                <?php
                $thumbnail_url = wp_get_attachment_image_url(
                    $attachment_id,
                    'thumbnail'
                );

                if (!$thumbnail_url) {
                    continue;
                }
                ?>

                <li
                    class="muku-works-gallery__item"
                    data-attachment-id="<?php echo esc_attr($attachment_id); ?>"
                >
                    <div class="muku-works-gallery__image">
                        <?php echo wp_get_attachment_image(
                            $attachment_id,
                            'thumbnail'
                        ); ?>
                    </div>

                    <label class="muku-works-gallery__position-label">
                        サムネイル位置

                        <?php
$current_position = $gallery_positions[$attachment_id] ?? 'center';
?>

                    <select
                        class="muku-works-gallery__position"
                        data-attachment-id="<?php echo esc_attr($attachment_id); ?>"
                    >
                        <option
                            value="center"
                            <?php selected($current_position, 'center'); ?>
                        >
                            中央
                        </option>

                        <option
                            value="top"
                            <?php selected($current_position, 'top'); ?>
                        >
                            上
                        </option>

                        <option
                            value="bottom"
                            <?php selected($current_position, 'bottom'); ?>
                        >
                            下
                        </option>

                        <option
                            value="left"
                            <?php selected($current_position, 'left'); ?>
                        >
                            左
                        </option>

                        <option
                            value="right"
                            <?php selected($current_position, 'right'); ?>
                        >
                            右
                        </option>
                    </select>
                    
                    </label>

                    <button
                        type="button"
                        class="muku-works-gallery__remove"
                        aria-label="画像を削除"
                    >
                        ×
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <button
            type="button"
            id="muku-works-gallery-add"
            class="button button-primary"
        >
            ＋ 画像を追加
        </button>


        <hr style="margin: 24px 0;">

        <p>
            <label for="muku-works-youtube-url">
                <strong>YouTube URL</strong>
            </label>
        </p>

        <input
            type="url"
            id="muku-works-youtube-url"
            name="muku_works_youtube_url"
            value="<?php echo esc_url($youtube_url); ?>"
            placeholder="https://www.youtube.com/watch?v=..."
            style="width: 100%;"
        >

    </div>

    <?php
}


/**
 * ギャラリー画像を保存
 */
function muku_save_works_gallery($post_id) {
    if (
        !isset($_POST['muku_works_gallery_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash($_POST['muku_works_gallery_nonce'])
            ),
            'muku_save_works_gallery'
        )
    ) {
        return;
    }

    if (
        defined('DOING_AUTOSAVE') &&
        DOING_AUTOSAVE
    ) {
        return;
    }

    if (
        get_post_type($post_id) !== 'works' ||
        !current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    if (isset($_POST['muku_works_gallery_ids'])) {
        $gallery_ids = array_filter(
            array_map(
                'absint',
                explode(
                    ',',
                    sanitize_text_field(
                        wp_unslash($_POST['muku_works_gallery_ids'])
                    )
                )
            )
        );

        update_post_meta(
            $post_id,
            '_works_gallery_ids',
            $gallery_ids
        );
    } else {
        delete_post_meta(
            $post_id,
            '_works_gallery_ids'
        );
    }


    /* サムネイル位置を保存 */
if (isset($_POST['muku_works_gallery_positions'])) {

    $positions_json = wp_unslash(
        $_POST['muku_works_gallery_positions']
    );

    $positions = json_decode(
        $positions_json,
        true
    );

    if (is_array($positions)) {

        $allowed_positions = array(
            'center',
            'top',
            'bottom',
            'left',
            'right'
        );

        $clean_positions = array();

        foreach ($positions as $attachment_id => $position) {

            $attachment_id = absint($attachment_id);
            $position = sanitize_key($position);

            if (
                $attachment_id &&
                in_array($position, $allowed_positions, true)
            ) {
                $clean_positions[$attachment_id] = $position;
            }
        }

        update_post_meta(
            $post_id,
            '_works_gallery_positions',
            $clean_positions
        );
    }
}
    
        if (isset($_POST['muku_works_youtube_url'])) {

        $youtube_url = esc_url_raw(
            wp_unslash($_POST['muku_works_youtube_url'])
        );

        if ($youtube_url) {
            update_post_meta(
                $post_id,
                '_works_youtube_url',
                $youtube_url
            );
        } else {
            delete_post_meta(
                $post_id,
                '_works_youtube_url'
            );
        }

    }
}
add_action('save_post_works', 'muku_save_works_gallery');


/**
 * Works投稿画面だけで管理画面用CSS・JSを読み込む
 */
function muku_enqueue_works_gallery_admin_assets($hook_suffix) {
    if (
        $hook_suffix !== 'post.php' &&
        $hook_suffix !== 'post-new.php'
    ) {
        return;
    }

    $screen = get_current_screen();

    if (
        !$screen ||
        $screen->post_type !== 'works'
    ) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-sortable');

    wp_enqueue_style(
        'muku-works-gallery-admin',
        get_template_directory_uri() .
        '/assets/css/admin-works-gallery.css',
        array(),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script(
        'muku-works-gallery-admin',
        get_template_directory_uri() .
        '/assets/js/admin-works-gallery.js',
        array('jquery', 'jquery-ui-sortable'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action(
    'admin_enqueue_scripts',
    'muku_enqueue_works_gallery_admin_assets'
);

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'kosugi-font',
        'https://fonts.googleapis.com/css2?family=Kosugi&display=swap',
        array(),
        null
    );
});