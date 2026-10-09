<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Добавляет первой ссылкой переход к основному содержимому для клавиатурной навигации.
 */
function tl_theme_skip_link() {
    ?>
    <a class="nbs-skip-link" href="#content"><?php esc_html_e( 'Перейти к содержимому', 'tihaya-lenta' ); ?></a>
    <?php
}
add_action( 'wp_body_open', 'tl_theme_skip_link' );

/**
 * Помечает ссылки на внешний источник, не изменяя пользовательский HTML записи.
 *
 * @param array  $attributes Атрибуты ссылки.
 * @param string $item_output Готовая разметка пункта.
 * @param object $item Объект пункта меню.
 * @return array
 */
function tl_theme_menu_link_attributes( $attributes, $item_output, $item ) {
    unset( $item_output, $item );

    if ( isset( $attributes['target'] ) && '_blank' === $attributes['target'] ) {
        $attributes['rel'] = 'noopener noreferrer';
    }

    return $attributes;
}
add_filter( 'nav_menu_link_attributes', 'tl_theme_menu_link_attributes', 10, 3 );
