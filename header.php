<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tl_channels = tl_theme_get_channels();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="nbs-site-header">
    <div class="nbs-topbar">
        <div class="nbs-shell nbs-topbar-inner">
            <time datetime="<?php echo esc_attr( wp_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( wp_date( get_option( 'date_format' ) ) ); ?></time>
            <div class="nbs-topbar-actions">
                <?php foreach ( $tl_channels as $tl_channel ) : ?>
                    <a href="<?php echo esc_url( $tl_channel['url'] ); ?>"><?php echo esc_html( $tl_channel['label'] ); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="nbs-navigation">
        <div class="nbs-shell nbs-navigation-inner">
            <a class="nbs-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <?php if ( has_custom_logo() ) : ?>
                    <?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'custom-logo', 'alt' => get_bloginfo( 'name' ) ) ); ?>
                <?php else : ?>
                    <span class="tl-brand-mark" aria-hidden="true"></span>
                    <span class="tl-brand-title"><?php bloginfo( 'name' ); ?></span>
                <?php endif; ?>
            </a>
            <button class="nbs-menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="nbs-primary-menu">
                <span><?php esc_html_e( 'Меню', 'tihaya-lenta' ); ?></span><i aria-hidden="true"></i>
            </button>
            <nav class="nbs-primary-nav" id="nbs-primary-menu" aria-label="<?php esc_attr_e( 'Основная навигация', 'tihaya-lenta' ); ?>" data-menu>
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nbs-menu', 'fallback_cb' => 'tl_theme_primary_menu_fallback' ) ); ?>
            </nav>
            <button class="nbs-icon-button nbs-search-toggle" type="button" data-search-toggle aria-expanded="false" aria-controls="nbs-header-search" aria-label="<?php esc_attr_e( 'Открыть поиск', 'tihaya-lenta' ); ?>"><span aria-hidden="true">⌕</span></button>
            <?php if ( $tl_channels ) : ?>
                <button class="nbs-button nbs-header-subscribe" type="button" data-subscribe-toggle aria-expanded="false" aria-controls="nbs-subscribe-panel"><?php esc_html_e( 'Подписаться', 'tihaya-lenta' ); ?></button>
            <?php endif; ?>
        </div>
        <noscript><div class="nbs-shell tl-no-script-search"><?php get_search_form(); ?></div></noscript>
        <div class="nbs-header-search" id="nbs-header-search" data-search-panel hidden>
            <div class="nbs-search-dialog" role="dialog" aria-modal="true" aria-labelledby="nbs-search-title">
                <div class="nbs-search-dialog-head">
                    <div><span class="nbs-kicker"><?php esc_html_e( 'Быстрый поиск', 'tihaya-lenta' ); ?></span><h2 id="nbs-search-title"><?php esc_html_e( 'Что вы хотите найти?', 'tihaya-lenta' ); ?></h2></div>
                    <button class="nbs-search-close" type="button" data-search-close aria-label="<?php esc_attr_e( 'Закрыть поиск', 'tihaya-lenta' ); ?>">×</button>
                </div>
                <?php get_search_form(); ?>
                <div class="nbs-live-search-results" data-live-search-results aria-live="polite"></div>
            </div>
        </div>
        <?php if ( $tl_channels ) : ?>
            <div class="nbs-subscribe-modal" id="nbs-subscribe-panel" data-subscribe-panel hidden>
                <div class="nbs-subscribe-dialog" role="dialog" aria-modal="true" aria-labelledby="nbs-subscribe-modal-title">
                    <button class="nbs-subscribe-close" type="button" data-subscribe-close aria-label="<?php esc_attr_e( 'Закрыть выбор канала', 'tihaya-lenta' ); ?>">×</button>
                    <span class="nbs-kicker"><?php esc_html_e( 'Оставайтесь в курсе', 'tihaya-lenta' ); ?></span>
                    <h2 id="nbs-subscribe-modal-title"><?php esc_html_e( 'Выберите удобный канал', 'tihaya-lenta' ); ?></h2>
                    <p><?php esc_html_e( 'Новые материалы там, где удобно читать вам.', 'tihaya-lenta' ); ?></p>
                    <?php get_template_part( 'template-parts/components/channel-options' ); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>
<?php if ( get_theme_mod( 'tl_theme_show_ticker', true ) ) { get_template_part( 'template-parts/components/ticker' ); } ?>
<main id="content" class="nbs-site-content" tabindex="-1">
