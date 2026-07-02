<?php

function mukuportfolio_enqueue_styles() {

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