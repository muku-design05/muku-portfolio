<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<header class="header">

    <div class="container header__inner">

        <!-- ロゴ -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
        MUKU ANBO
        </a>

        <!-- ナビゲーション -->
        <nav class="header-nav">
           
            <ul>

                <li>
                    <a href="<?php echo esc_url(home_url('/#top')); ?>">
                        Top
                    </a>
                </li>

                <li>
                    <a href="<?php echo esc_url(home_url('/#works')); ?>">
                        Works
                    </a>
                </li>

                <li>
                    <a href="<?php echo esc_url(home_url('/#about')); ?>">
                        About
                    </a>
                </li>

                <li>
                    <a href="<?php echo esc_url(home_url('/#contact')); ?>">
                        Contact
                    </a>
                </li>
            </ul>

        </nav>

        <!-- ハンバーガーボタン -->
        <button class="hamburger" aria-label="メニューを開く" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>

</header>