<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Возвращает запрос для ведущей сетки, не изменяя основной цикл WordPress.
 *
 * @param int $count Количество материалов в сетке.
 * @return WP_Query
 */
function tl_theme_hero_query( $count = 5 ) {
    return new WP_Query(
        array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => absint( $count ),
            'ignore_sticky_posts' => true,
            'cat'                 => absint( get_theme_mod( 'tl_theme_hero_category', 0 ) ),
            'no_found_rows'       => true,
        )
    );
}

/**
 * Возвращает независимый список свежих материалов для статической главной страницы.
 *
 * @param int $count Количество карточек.
 * @return WP_Query
 */
function tl_theme_latest_query( $count = 8 ) {
    return new WP_Query(
        array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => absint( $count ),
            'ignore_sticky_posts' => true,
            'paged'               => tl_theme_news_page(),
        )
    );
}

/**
 * Получает короткую ленту заголовков для строки «Сейчас».
 *
 * @param int $count Количество заголовков.
 * @return WP_Post[]
 */
function tl_theme_get_ticker_posts( $count = 8 ) {
    return get_posts(
        array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => absint( $count ),
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        )
    );
}

/**
 * Возвращает материалы для боковой колонки.
 *
 * @param int $count Количество записей.
 * @return WP_Post[]
 */
function tl_theme_get_sidebar_posts( $count = 5 ) {
    return get_posts(
        array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => absint( $count ),
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
            'orderby'             => array(
                'comment_count' => 'DESC',
                'date'          => 'DESC',
            ),
        )
    );
}

/**
 * Строит подборку материалов из тех же рубрик, исключая открытую запись.
 *
 * @param int $post_id Текущая запись.
 * @param int $count   Максимальное число рекомендаций.
 * @return WP_Query
 */
function tl_theme_related_query( $post_id, $count = 3 ) {
    $category_ids = wp_get_post_categories( $post_id );
    $arguments    = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => absint( $count ),
        'post__not_in'        => array( absint( $post_id ) ),
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    );

    /* При наличии рубрик рекомендации становятся тематическими, иначе используются свежие новости. */
    if ( ! empty( $category_ids ) ) {
        $arguments['category__in'] = $category_ids;
    }

    return new WP_Query( $arguments );
}

/**
 * Задаёт одинаковую плотность архивов, поиска и домашнего списка.
 *
 * @param WP_Query $query Основной запрос WordPress.
 */
function tl_theme_shape_main_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_home() || $query->is_archive() || $query->is_search() ) {
        if ( $query->is_home() ) {
            $query->set( 'posts_per_page', tl_theme_sanitize_count( get_theme_mod( 'tl_theme_posts_count', 12 ) ) );
        }
    }
}
add_action( 'pre_get_posts', 'tl_theme_shape_main_query' );

/**
 * Отделяем страницы новостной ленты от частей текста статической главной.
 *
 * @param array $variables Разрешённые параметры запроса WordPress.
 * @return array
 */
function tl_theme_news_query_vars( $variables ) {
    $variables[] = 'tl_page';
    return $variables;
}
add_filter( 'query_vars', 'tl_theme_news_query_vars' );

/**
 * Сохраняем маршрут статической главной при переходе по страницам её ленты.
 *
 * @param array $variables Параметры основного запроса после разбора URL.
 * @return array
 */
function tl_theme_static_news_request( $variables ) {
    if ( empty( $variables['tl_page'] ) || 'page' !== get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) {
        return $variables;
    }

    /* Поиск, статьи и архивы сохраняют собственные маршруты. */
    $route = $variables;
    unset( $route['tl_page'], $route['preview'], $route['page'], $route['paged'], $route['cpage'] );
    if ( isset( $route['pagename'] ) && '' === $route['pagename'] ) {
        unset( $route['pagename'] );
    }
    if ( empty( $route ) ) {
        $variables['page_id'] = absint( get_option( 'page_on_front' ) );
    }

    return $variables;
}
add_filter( 'request', 'tl_theme_static_news_request' );

/**
 * Определяем текущую страницу новостей в обоих режимах главной.
 *
 * @return int
 */
function tl_theme_news_page() {
    return max( 1, absint( get_query_var( is_home() ? 'paged' : 'tl_page' ) ) );
}
