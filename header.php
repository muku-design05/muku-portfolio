<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<header class="header">

    <div class="container">

        <!-- ロゴ -->
        <a href="#top" class="logo">
            MUKU ANBO
        </a>

        <!-- ナビゲーション -->
        <nav class="header-nav">

            <ul>

                <li><a href="#top">Top</a></li>

                <li><a href="#works">Works</a></li>

                <li><a href="#about">About</a></li>

                <li><a href="#contact">Contact</a></li>

            </ul>

        </nav>

        <!-- ハンバーガーボタン -->
        <button class="hamburger" aria-label="メニューを開く">

            <span></span>
            <span></span>
            <span></span>

        </button>

    </div>

</header>