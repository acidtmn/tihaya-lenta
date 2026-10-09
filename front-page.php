<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
$tl_current_page = tl_theme_news_page();

/* Содержимое назначенной страницы остаётся доступным в статическом режиме главной. */
if ( ! is_home() && have_posts() && 1 === $tl_current_page ) :
    while ( have_posts() ) :
        the_post();
        ?>
        <section class="nbs-shell tl-home-intro">
            <h1><?php the_title(); ?></h1>
            <div class="nbs-page-content"><?php the_content(); ?><?php wp_link_pages(); ?></div>
        </section>
        <?php
    endwhile;
endif;

if ( 1 === $tl_current_page && get_theme_mod( 'tl_theme_show_hero', true ) ) {
    get_template_part( 'template-parts/components/hero-grid' );
} elseif ( is_home() || $tl_current_page > 1 ) {
    echo '<h1 class="screen-reader-text">' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
}
$tl_latest = is_home() ? $GLOBALS['wp_query'] : tl_theme_latest_query( tl_theme_sanitize_count( get_theme_mod( 'tl_theme_posts_count', 12 ) ) );
?>
<div class="nbs-shell nbs-content-layout" id="latest">
    <section class="nbs-news-stream" aria-labelledby="nbs-latest-title">
        <div class="nbs-section-heading nbs-section-heading--line">
            <span><?php esc_html_e( 'Лента', 'tihaya-lenta' ); ?></span>
            <h2 id="nbs-latest-title"><?php esc_html_e( 'Последние новости', 'tihaya-lenta' ); ?></h2>
        </div>
        <?php if ( $tl_latest->have_posts() ) : ?>
            <div class="nbs-card-grid nbs-card-grid--two">
                <?php while ( $tl_latest->have_posts() ) : ?>
                    <?php $tl_latest->the_post(); ?>
                    <?php get_template_part( 'template-parts/cards/card', null, array( 'variant' => 'standard' ) ); ?>
                <?php endwhile; ?>
            </div>
            <?php
            $tl_pagination_args = array(
                'current' => $tl_current_page,
                'total' => $tl_latest->max_num_pages,
                'prev_text' => __( 'Назад', 'tihaya-lenta' ),
                'next_text' => __( 'Дальше', 'tihaya-lenta' ),
                'type' => 'list',
            );
            if ( ! is_home() ) {
                $tl_pagination_args['base'] = str_replace( '999999999', '%#%', add_query_arg( 'tl_page', 999999999, get_permalink( get_option( 'page_on_front' ) ) ) );
                $tl_pagination_args['format'] = '';
            }
            $tl_pagination = paginate_links( $tl_pagination_args );
            if ( $tl_pagination ) {
                echo '<nav class="navigation pagination" aria-label="' . esc_attr__( 'Страницы новостей', 'tihaya-lenta' ) . '">' . wp_kses_post( $tl_pagination ) . '</nav>';
            }
            wp_reset_postdata();
            ?>
        <?php else : ?>
            <p class="nbs-muted"><?php esc_html_e( 'Публикаций пока нет.', 'tihaya-lenta' ); ?></p>
        <?php endif; ?>
    </section>
    <?php get_template_part( 'template-parts/components/sidebar' ); ?>
</div>
<?php
get_template_part( 'template-parts/components/subscribe-block' );
get_footer();
