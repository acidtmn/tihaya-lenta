<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Добавляем настройки оформления без изменения содержимого сайта.
 *
 * @param WP_Customize_Manager $wp_customize Менеджер настроек WordPress.
 * @return void
 */
function tl_theme_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'tl_theme_options', array(
        'title' => __( 'Тихая лента', 'tihaya-lenta' ),
        'priority' => 35,
    ) );

    /* Общие параметры описывают контролы и правила очистки каждого значения. */
    $controls = array(
        'telegram_url' => array( 'label' => __( 'Ссылка на Telegram', 'tihaya-lenta' ), 'type' => 'url', 'default' => '', 'sanitize' => 'tl_theme_sanitize_channel_url' ),
        'max_url' => array( 'label' => __( 'Ссылка на MAX', 'tihaya-lenta' ), 'type' => 'url', 'default' => '', 'sanitize' => 'tl_theme_sanitize_channel_url' ),
        'show_rss' => array( 'label' => __( 'Показывать RSS', 'tihaya-lenta' ), 'type' => 'checkbox', 'default' => true, 'sanitize' => 'rest_sanitize_boolean' ),
        'show_channels' => array( 'label' => __( 'Показывать блок каналов на главной', 'tihaya-lenta' ), 'type' => 'checkbox', 'default' => true, 'sanitize' => 'rest_sanitize_boolean' ),
        'show_ticker' => array( 'label' => __( 'Показывать строку «Сейчас»', 'tihaya-lenta' ), 'type' => 'checkbox', 'default' => true, 'sanitize' => 'rest_sanitize_boolean' ),
        'show_hero' => array( 'label' => __( 'Показывать главную сетку новостей', 'tihaya-lenta' ), 'type' => 'checkbox', 'default' => true, 'sanitize' => 'rest_sanitize_boolean' ),
        'posts_count' => array( 'label' => __( 'Новостей на странице главной', 'tihaya-lenta' ), 'type' => 'number', 'default' => 12, 'sanitize' => 'tl_theme_sanitize_count', 'input_attrs' => array( 'min' => 6, 'max' => 24 ) ),
        'show_credit' => array( 'label' => __( 'Показывать автора темы в подвале', 'tihaya-lenta' ), 'type' => 'checkbox', 'default' => true, 'sanitize' => 'rest_sanitize_boolean' ),
    );

    foreach ( $controls as $key => $control ) {
        $id = 'tl_theme_' . $key;
        $wp_customize->add_setting( $id, array( 'default' => $control['default'], 'sanitize_callback' => $control['sanitize'] ) );
        $wp_customize->add_control( $id, array(
            'section' => 'tl_theme_options',
            'label' => $control['label'],
            'type' => $control['type'],
            'input_attrs' => $control['input_attrs'] ?? array(),
        ) );
    }

    /* Выбор рубрики использует существующие материалы, не создавая новые разделы. */
    $categories = array( 0 => __( 'Все рубрики', 'tihaya-lenta' ) );
    foreach ( get_categories( array( 'hide_empty' => false ) ) as $category ) {
        $categories[ $category->term_id ] = $category->name;
    }
    $wp_customize->add_setting( 'tl_theme_hero_category', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'tl_theme_hero_category', array(
        'section' => 'tl_theme_options',
        'label' => __( 'Рубрика главного блока', 'tihaya-lenta' ),
        'type' => 'select',
        'choices' => $categories,
    ) );

    $wp_customize->add_setting( 'tl_theme_accent', array( 'default' => '#19a9e5', 'sanitize_callback' => 'sanitize_hex_color' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tl_theme_accent', array(
        'label' => __( 'Цвет акцента', 'tihaya-lenta' ),
        'section' => 'colors',
    ) ) );
}
add_action( 'customize_register', 'tl_theme_customize_register' );
