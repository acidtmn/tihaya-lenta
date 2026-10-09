<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрирует возможности темы, меню и размеры изображений.
 */
function tl_theme_setup() {
    /* Переводы загружаются из каталога languages, если он появится в будущих версиях. */
    load_theme_textdomain( 'tihaya-lenta', get_template_directory() . '/languages' );

    /* WordPress самостоятельно управляет служебными тегами и заголовком страницы. */
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 160,
            'width'       => 360,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    /* Редактор использует ту же типографическую основу, что и публичная часть сайта. */
    add_editor_style( 'assets/css/editor-style.css' );

    /* Два меню не смешивают основную навигацию с юридическими ссылками в подвале. */
    register_nav_menus(
        array(
            'primary' => __( 'Основное меню', 'tihaya-lenta' ),
            'footer'  => __( 'Меню в подвале', 'tihaya-lenta' ),
        )
    );

    /* Отдельные размеры не заставляют браузер загружать исходники высокого разрешения в карточках. */
    add_image_size( 'nbs-hero', 1120, 720, true );
    add_image_size( 'nbs-card', 720, 440, true );
    add_image_size( 'nbs-related', 480, 300, true );
}
add_action( 'after_setup_theme', 'tl_theme_setup' );



/**
 * Делает автоматические анонсы достаточно короткими для плотной новостной сетки.
 *
 * @param int $length Исходная длина анонса.
 * @return int
 */
function tl_theme_excerpt_length( $length ) {
    if ( is_admin() ) {
        return $length;
    }

    return 24;
}
add_filter( 'excerpt_length', 'tl_theme_excerpt_length', 20 );

/**
 * Использует аккуратное многоточие без технической ссылки WordPress.
 *
 * @param string $more Исходное окончание анонса.
 * @return string
 */
function tl_theme_excerpt_more( $more ) {
    if ( is_admin() ) {
        return $more;
    }

    return '…';
}
add_filter( 'excerpt_more', 'tl_theme_excerpt_more' );
