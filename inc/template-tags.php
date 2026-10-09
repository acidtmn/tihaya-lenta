<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Возвращает URL изображения записи или пустую строку для фирменной CSS-заглушки.
 *
 * @param int    $post_id Идентификатор записи.
 * @param string $size    Зарегистрированный размер изображения.
 * @return string
 */
function tl_theme_get_post_image( $post_id, $size = 'nbs-card' ) {
    if ( ! has_post_thumbnail( $post_id ) ) {
        return '';
    }

    $image = wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), $size );

    return $image ? $image : '';
}

/**
 * Возвращает первый термин заданной таксономии.
 *
 * @param int    $post_id Идентификатор записи.
 * @param string $taxonomy Имя таксономии.
 * @return WP_Term|null
 */
function tl_theme_get_primary_term( $post_id, $taxonomy ) {
    if ( ! taxonomy_exists( $taxonomy ) ) {
        return null;
    }

    $terms = get_the_terms( $post_id, $taxonomy );

    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return null;
    }

    return reset( $terms );
}

/**
 * Находим первую стандартную рубрику материала.
 *
 * @param int $post_id Идентификатор записи.
 * @return WP_Term|null
 */
function tl_theme_get_section( $post_id ) {
    return tl_theme_get_primary_term( $post_id, 'category' );
}

/**
 * Печатает компактные метаданные карточки без дублирования разметки в шаблонах.
 *
 * @param int $post_id Идентификатор записи.
 */
function tl_theme_card_meta( $post_id ) {
    $section = tl_theme_get_section( $post_id );
    ?>
    <div class="nbs-card-meta">
        <?php if ( $section ) : ?>
            <span class="nbs-kicker"><?php echo esc_html( $section->name ); ?></span>
        <?php endif; ?>
        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post_id ) ); ?>">
            <?php echo esc_html( get_the_date( get_option( 'date_format' ), $post_id ) . ' · ' . get_the_time( get_option( 'time_format' ), $post_id ) ); ?>
        </time>
    </div>
    <?php
}

/**
 * Возвращает время чтения на основе объёма очищенного текста.
 *
 * @param int $post_id Идентификатор записи.
 * @return int
 */
function tl_theme_reading_minutes( $post_id ) {
    $content = wp_strip_all_tags( (string) get_post_field( 'post_content', $post_id ) );
    $words   = preg_split( '/\s+/u', trim( $content ), -1, PREG_SPLIT_NO_EMPTY );
    $count   = is_array( $words ) ? count( $words ) : 0;

    return max( 1, (int) ceil( $count / 180 ) );
}

/**
 * Печатает пагинацию с понятными подписями для клавиатуры и скринридера.
 */
function tl_theme_pagination() {
    the_posts_pagination(
        array(
            'mid_size'           => 1,
            'prev_text'          => __( 'Назад', 'tihaya-lenta' ),
            'next_text'          => __( 'Дальше', 'tihaya-lenta' ),
            'screen_reader_text' => __( 'Навигация по материалам', 'tihaya-lenta' ),
        )
    );
}

/**
 * Формирует полезное меню даже до ручного назначения меню в панели WordPress.
 */
function tl_theme_primary_menu_fallback() {
    $items = array( home_url( '/' ) => __( 'Главное', 'tihaya-lenta' ) );

    /* Показываем реальные рубрики сайта до назначения собственного меню. */
    foreach ( get_categories( array( 'number' => 5, 'hide_empty' => true ) ) as $category ) {
        $items[ get_category_link( $category ) ] = $category->name;
    }

    $items[ get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/#latest' ) ] = __( 'Последние', 'tihaya-lenta' );
    ?>
    <ul class="nbs-menu">
        <?php foreach ( $items as $url => $label ) : ?>
            <li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php
}
