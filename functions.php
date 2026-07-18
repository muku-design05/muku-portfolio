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