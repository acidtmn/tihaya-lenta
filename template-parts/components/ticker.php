<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tl_theme_ticker_posts = tl_theme_get_ticker_posts();
?>
<section class="nbs-ticker" aria-label="<?php esc_attr_e( 'Последние новости', 'tihaya-lenta' ); ?>">
    <div class="nbs-shell nbs-ticker-track">
        <strong class="nbs-ticker-label"><i aria-hidden="true"></i><?php esc_html_e( 'Сейчас', 'tihaya-lenta' ); ?></strong>
        <div class="nbs-ticker-items">
            <?php if ( $tl_theme_ticker_posts ) : ?>
                <?php foreach ( $tl_theme_ticker_posts as $tl_theme_ticker_post ) : ?>
                    <a href="<?php echo esc_url( get_permalink( $tl_theme_ticker_post ) ); ?>">
                        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $tl_theme_ticker_post ) ); ?>"><?php echo esc_html( get_the_time( 'H:i', $tl_theme_ticker_post ) ); ?></time>
                        <span><?php echo esc_html( get_the_title( $tl_theme_ticker_post ) ); ?></span>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <span><?php esc_html_e( 'Редакционная лента готова к первым публикациям', 'tihaya-lenta' ); ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>
