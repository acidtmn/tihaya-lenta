<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Подключает локальные стили и сценарии без внешних CDN.
 */
function tl_theme_enqueue_assets() {
    $theme = wp_get_theme();

    /* Главная таблица стилей загружается после обязательного style.css с метаданными темы. */
    wp_enqueue_style(
        'tl-theme-style',
        get_stylesheet_uri(),
        array(),
        $theme->get( 'Version' )
    );

    wp_enqueue_style(
        'tl-theme-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array( 'tl-theme-style' ),
        $theme->get( 'Version' )
    );

    /* Небольшой локальный сценарий отвечает только за меню, поиск и копирование ссылки. */
    wp_enqueue_script(
        'tl-theme-script',
        get_template_directory_uri() . '/assets/js/theme.js',
        array(),
        $theme->get( 'Version' ),
        true
    );

    /* Живой поиск вынесен отдельно, потому что он отвечает за сетевой запрос и построение выдачи. */
    wp_enqueue_script(
        'tl-theme-live-search',
        get_template_directory_uri() . '/assets/js/live-search.js',
        array(),
        $theme->get( 'Version' ),
        true
    );

    wp_localize_script(
        'tl-theme-script',
        'tlThemeData',
        array(
            'submenuLabel' => __( 'Открыть подменю', 'tihaya-lenta' ),
            'copiedLabel' => __( 'Ссылка скопирована', 'tihaya-lenta' ),
        )
    );

    wp_localize_script(
        'tl-theme-live-search',
        'tlLiveSearchData',
        array(
            'endpoint'     => esc_url_raw( rest_url( 'wp/v2/search' ) ),
            'loadingLabel' => __( 'Ищем материалы…', 'tihaya-lenta' ),
            'emptyLabel'   => __( 'Ничего не найдено. Попробуйте изменить запрос.', 'tihaya-lenta' ),
            'errorLabel'   => __( 'Поиск временно недоступен. Нажмите «Найти» для обычного поиска.', 'tihaya-lenta' ),
            'postLabel'    => __( 'Новость', 'tihaya-lenta' ),
            'pageLabel'    => __( 'Страница', 'tihaya-lenta' ),
        )
    );

    /* Общий контроллер управляет фокусом и закрытием диалоговых окон. */
    wp_enqueue_script(
        'tl-theme-dialogs',
        get_template_directory_uri() . '/assets/js/dialogs.js',
        array(),
        $theme->get( 'Version' ),
        true
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'tl_theme_enqueue_assets' );
