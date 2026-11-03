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
 * OTHER WORKS専用ギャラリー
 */
function muku_add_other_works_meta_box() {

    // 現職のWeb作品だけに表示
    $post = get_post();

    if (!$post || $post->post_name !== 'web2026_01') {
        return;
    }

    add_meta_box(
        'muku-other-works-gallery',
        'Other Works Gallery',
        'muku_render_other_works_meta_box',
        'works',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'muku_add_other_works_meta_box');


/**
 * OTHER WORKSの入力欄
 */
function muku_render_other_works_meta_box($post) {

    wp_nonce_field(
        'muku_save_other_works',
        'muku_other_works_nonce'
    );

        $other_gallery_ids = get_post_meta(
        $post->ID,
        '_muku_other_works_gallery_ids',
        true
    );

    if (!is_array($other_gallery_ids)) {
        $other_gallery_ids = array();
    }

    ?>

    <div class="muku-other-works-gallery">

        <p>
            その他の制作実績として掲載する画像を登録します。
        </p>

        <input
            type="hidden"
            id="muku-other-works-gallery-ids"
            name="muku_other_works_gallery_ids"
            value="<?php echo esc_attr(implode(',', $other_gallery_ids)); ?>"
        >

        <ul id="muku-other-works-gallery-list">
            <?php foreach ($other_gallery_ids as $attachment_id) : ?>
                <?php
                $attachment_id = absint($attachment_id);

                $thumbnail_url = wp_get_attachment_image_url(
                    $attachment_id,
                    'thumbnail'
                );

                if (!$thumbnail_url) {
                    continue;
                }
                ?>

                <li
                    data-attachment-id="<?php echo esc_attr($attachment_id); ?>"
                    style="display: inline-block; margin: 8px; cursor: move;"
                >
                    <img
                        src="<?php echo esc_url($thumbnail_url); ?>"
                        alt=""
                        style="width: 100px; height: 100px; object-fit: cover; display: block;"
                    >

                    <button
                        type="button"
                        class="button"
                    >
                        × 削除
                    </button>
                </li>

            <?php endforeach; ?>
        </ul>

        <button
            type="button"
            id="muku-other-works-gallery-add"
            class="button button-primary"
        >
            ＋ 画像を追加
        </button>

    </div>

    <?php
}


/**
 * OTHER WORKSの画像を保存
 */
function muku_save_other_works_gallery($post_id) {

    // nonceの確認
    if (
        !isset($_POST['muku_other_works_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(wp_unslash($_POST['muku_other_works_nonce'])),
            'muku_save_other_works'
        )
    ) {
        return;
    }

    // 自動保存・リビジョンを除外
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
        wp_is_post_revision($post_id)
    ) {
        return;
    }

    // 編集権限の確認
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // 対象の作品だけ保存
    if (get_post_field('post_name', $post_id) !== 'web2026_01') {
        return;
    }

    // 画像IDを取得して保存
    if (isset($_POST['muku_other_works_gallery_ids'])) {

        $gallery_ids = array_filter(
            array_map(
                'absint',
                explode(
                    ',',
                    sanitize_text_field(
                        wp_unslash($_POST['muku_other_works_gallery_ids'])
                    )
                )
            )
        );

        update_post_meta(
            $post_id,
            '_muku_other_works_gallery_ids',
            array_values($gallery_ids)
        );

    }
}
add_action('save_post_works', 'muku_save_other_works_gallery');


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

// 大きな画像の自動縮小を無効化
add_filter('big_image_size_threshold', '__return_false');


/* =========================
   Top Works Slideshow Settings
========================= */

// 管理画面に「トップWorks設定」を追加
function muku_add_top_works_settings_page() {

    add_menu_page(
        'トップWorks設定',
        'トップWorks設定',
        'manage_options',
        'muku-top-works',
        'muku_render_top_works_settings_page',
        'dashicons-images-alt2',
        25
    );

}
add_action('admin_menu', 'muku_add_top_works_settings_page');


// トップWorks設定画面の表示
function muku_render_top_works_settings_page() {

    if (!current_user_can('manage_options')) {
        return;
    }

    // 画像IDの保存処理
    if (
        isset($_SERVER['REQUEST_METHOD']) &&
        $_SERVER['REQUEST_METHOD'] === 'POST'
    ) {

        check_admin_referer(
            'muku_save_top_works',
            'muku_top_works_nonce'
        );

        $save_categories = array(
            'web',
            'banner',
            'graphic',
            'video',
        );

        foreach ($save_categories as $category) {

            $field_name = 'muku_top_works_' . $category . '_ids';

            $raw_ids = isset($_POST[$field_name])
                ? sanitize_text_field(wp_unslash($_POST[$field_name]))
                : '';

            $ids = array_filter(
                array_map('absint', explode(',', $raw_ids))
            );

            // 重複を除いて保存
            $ids = array_values(array_unique($ids));

            update_option(
                'muku_top_works_' . $category . '_ids',
                $ids
            );
        }

        echo '<div class="notice notice-success is-dismissible"><p>設定を保存しました。</p></div>';
    }

    $categories = array(
        'web'     => 'WEB',
        'banner'  => 'BANNER',
        'graphic' => 'GRAPHIC',
        'video'   => 'VIDEO',
    );

    ?>

    <div class="wrap">
        <h1>トップWorks設定</h1>

        <p>
            トップページのWorksに表示する画像を管理します。<br>
            カテゴリーごとに好きな枚数の画像を登録できます。
        </p>

        <form method="post" id="muku-top-works-form">

            <?php wp_nonce_field(
                'muku_save_top_works',
                'muku_top_works_nonce'
            ); ?>

            <?php foreach ($categories as $key => $label) : ?>

                <?php
                $saved_ids = get_option(
                    'muku_top_works_' . $key . '_ids',
                    array()
                );

                if (!is_array($saved_ids)) {
                    $saved_ids = array();
                }
                ?>

                <div
                    class="muku-top-works-category"
                    data-category="<?php echo esc_attr($key); ?>"
                    style="background: #fff; padding: 24px; margin: 24px 0; border: 1px solid #ddd;"
                >

                    <h2><?php echo esc_html($label); ?></h2>

                    <p>
                        スライドショーに表示する画像を登録します。<br>
                        画像はドラッグ＆ドロップで並び替えられるようにします。
                    </p>

                    <input
                        type="hidden"
                        name="muku_top_works_<?php echo esc_attr($key); ?>_ids"
                        class="muku-top-works-ids"
                        value="<?php echo esc_attr(implode(',', $saved_ids)); ?>"
                    >

                    <ul
                        class="muku-top-works-list"
                        style="display: flex; flex-wrap: wrap; gap: 16px; padding: 0;"
                    >
                        <?php foreach ($saved_ids as $image_id) : ?>

                            <?php
                            $image_url = wp_get_attachment_image_url(
                                $image_id,
                                'thumbnail'
                            );

                            if (!$image_url) {
                                continue;
                            }
                            ?>

                            <li
                                data-id="<?php echo esc_attr($image_id); ?>"
                                style="width: 140px; padding: 8px; border: 1px solid #ddd; background: #f9f9f9; cursor: move; list-style: none;"
                            >
                                <img
                                    src="<?php echo esc_url($image_url); ?>"
                                    alt=""
                                    style="width: 100%; height: 100px; object-fit: contain;"
                                >

                                <button
                                    type="button"
                                    class="button muku-top-works-remove"
                                    style="display: block; margin-top: 8px;"
                                >
                                    削除
                                </button>
                            </li>

                        <?php endforeach; ?>
                    </ul>

                    <button
                        type="button"
                        class="button button-primary muku-top-works-add"
                    >
                        ＋ 画像を追加
                    </button>

                </div>

            <?php endforeach; ?>

            <p class="submit">
                <button
                    type="submit"
                    class="button button-primary"
                >
                    変更を保存
                </button>
            </p>

        </form>
    </div>

    <?php
}


/* =========================
   Top Works Media Library
========================= */

// トップWorks設定画面でメディアライブラリを使用
function muku_top_works_admin_scripts($hook) {

    if ($hook !== 'toplevel_page_muku-top-works') {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script('jquery-ui-sortable');

    wp_add_inline_script(
        'jquery-ui-sortable',
        <<<'JS'
jQuery(function ($) {

    // 画像IDを隠しフィールドに反映
    function updateImageIds($category) {

        const ids = [];

        $category.find('.muku-top-works-list li').each(function () {
            ids.push($(this).data('id'));
        });

        $category.find('.muku-top-works-ids').val(ids.join(','));
    }

    // メディアライブラリを開く
    $('.muku-top-works-add').on('click', function () {

        const $category = $(this).closest('.muku-top-works-category');

        const frame = wp.media({
            title: 'スライドショーの画像を選択',
            button: {
                text: '選択した画像を追加'
            },
            library: {
                type: 'image'
            },
            multiple: true
        });

        frame.on('select', function () {

            const attachments = frame.state().get('selection').toJSON();

            attachments.forEach(function (attachment) {

                // 同じ画像の重複登録を防ぐ
                if (
                    $category.find(
                        '.muku-top-works-list li[data-id="' + attachment.id + '"]'
                    ).length
                ) {
                    return;
                }

                const imageUrl =
                    attachment.sizes?.thumbnail?.url || attachment.url;

                const $item = $('<li>', {
                    'data-id': attachment.id,
                    css: {
                        width: '140px',
                        padding: '8px',
                        border: '1px solid #ddd',
                        background: '#f9f9f9',
                        cursor: 'move',
                        listStyle: 'none'
                    }
                });

                const $image = $('<img>', {
                    src: imageUrl,
                    alt: '',
                    css: {
                        width: '100%',
                        height: '100px',
                        objectFit: 'contain'
                    }
                });

                const $remove = $('<button>', {
                    type: 'button',
                    class: 'button',
                    text: '削除',
                    css: {
                        display: 'block',
                        marginTop: '8px'
                    }
                });

                $remove.on('click', function () {
                    $item.remove();
                    updateImageIds($category);
                });

                $item.append($image, $remove);

                $category.find('.muku-top-works-list').append($item);
            });

            updateImageIds($category);
        });

        frame.open();
    });

    // 保存済み画像の削除
    $('.muku-top-works-list').on(
        'click',
        '.muku-top-works-remove',
        function () {

            const $category = $(this).closest(
                '.muku-top-works-category'
            );

            $(this).closest('li').remove();

            updateImageIds($category);
        }
    );

    // ドラッグ＆ドロップで並び替え
    $('.muku-top-works-list').sortable({
        items: 'li',
        tolerance: 'pointer',
        update: function () {
            updateImageIds(
                $(this).closest('.muku-top-works-category')
            );
        }
    });

});
JS,
        'after'
    );
}
add_action('admin_enqueue_scripts', 'muku_top_works_admin_scripts');


/* =========================
   Top Works Slideshow Script
========================= */

function muku_enqueue_top_works_slideshow() {

    if (!is_front_page()) {
        return;
    }

    wp_enqueue_script(
        'muku-top-works-slideshow',
        get_template_directory_uri() . '/assets/js/top-works-slideshow.js',
        array(),
        filemtime(
            get_template_directory() . '/assets/js/top-works-slideshow.js'
        ),
        true
    );

}
add_action('wp_enqueue_scripts', 'muku_enqueue_top_works_slideshow');