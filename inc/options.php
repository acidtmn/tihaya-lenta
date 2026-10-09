<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Ограничиваем плотность главной страницы разумным диапазоном.
 *
 * @param int $value Число карточек, например 12.
 * @return int
 */
function tl_theme_sanitize_count( $value ) {
    return max( 6, min( 24, absint( $value ) ) );
}

/**
 * Принимаем только обычные веб-ссылки на каналы.
 *
 * @param string $value Полный адрес канала.
 * @return string
 */
function tl_theme_sanitize_channel_url( $value ) {
    return esc_url_raw( $value, array( 'http', 'https' ) );
}

/**
 * Собираем настроенные каналы и стандартную RSS-ленту WordPress.
 *
 * @return array Ссылки с ключами label и url.
 */
function tl_theme_get_channels() {
    $channels = array();

    foreach ( array( 'telegram' => 'Telegram', 'max' => 'MAX' ) as $key => $label ) {
        $url = tl_theme_sanitize_channel_url( get_theme_mod( 'tl_theme_' . $key . '_url', '' ) );
        if ( $url ) {
            $channels[] = array( 'label' => $label, 'url' => $url );
        }
    }

    if ( get_theme_mod( 'tl_theme_show_rss', true ) ) {
        $channels[] = array( 'label' => 'RSS', 'url' => get_feed_link() );
    }

    return $channels;
}

/**
 * Применяем акцент как к кнопкам, так и к ссылкам с читаемым цветом текста.
 *
 * @return void
 */
function tl_theme_accent_styles() {
    $accent = sanitize_hex_color( get_theme_mod( 'tl_theme_accent', '#19a9e5' ) );
    if ( ! $accent ) {
        return;
    }

    if ( 4 === strlen( $accent ) ) {
        $accent = '#' . $accent[1] . $accent[1] . $accent[2] . $accent[2] . $accent[3] . $accent[3];
    }
    $rgb = sscanf( $accent, '#%02x%02x%02x' );
    $brightness = static function ( $channels ) {
        $result = 0;
        foreach ( array( 0.2126, 0.7152, 0.0722 ) as $index => $weight ) {
            $channel = $channels[ $index ] / 255;
            $result += $weight * ( $channel <= 0.04045 ? $channel / 12.92 : pow( ( $channel + 0.055 ) / 1.055, 2.4 ) );
        }
        return $result;
    };
    $text = $brightness( $rgb ) > 0.179 ? '#000000' : '#ffffff';

    /* Для ссылок на светлом фоне получаем более тёмный оттенок того же акцента. */
    while ( $brightness( $rgb ) > 0.17 ) {
        $rgb = array_map( static fn( $channel ) => (int) floor( $channel * 0.9 ), $rgb );
    }
    $link = sprintf( '#%02x%02x%02x', ...$rgb );
    wp_add_inline_style( 'tl-theme-main', ':root{--nbs-blue:' . $accent . ';--nbs-blue-dark:' . $link . ';--tl-accent-text:' . $text . ';}' );
}
add_action( 'wp_enqueue_scripts', 'tl_theme_accent_styles', 20 );
