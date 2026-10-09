<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<div class="nbs-shell nbs-page-heading">
    <span class="nbs-kicker"><?php bloginfo( 'name' ); ?></span>
    <h1><?php echo esc_html( get_option( 'page_for_posts' ) ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'Последние новости', 'tihaya-lenta' ) ); ?></h1>
    <p><?php esc_html_e( 'Свежие материалы редакции в хронологическом порядке.', 'tihaya-lenta' ); ?></p>
</div>

<div class="nbs-shell nbs-content-layout">
    <section class="nbs-news-stream">
        <?php if ( have_posts() ) : ?>
            <div class="nbs-card-grid nbs-card-grid--two">
                <?php while ( have_posts() ) : ?>
                    <?php the_post(); ?>
                    <?php get_template_part( 'template-parts/cards/card', null, array( 'variant' => 'standard' ) ); ?>
                <?php endwhile; ?>
            </div>
            <?php tl_theme_pagination(); ?>
        <?php else : ?>
            <div class="nbs-empty-inline">
                <h2><?php esc_html_e( 'Публикаций пока нет', 'tihaya-lenta' ); ?></h2>
                <p><?php esc_html_e( 'Редакционная лента готова к первому материалу.', 'tihaya-lenta' ); ?></p>
            </div>
        <?php endif; ?>
    </section>
    <?php get_template_part( 'template-parts/components/sidebar' ); ?>
</div>

<?php
get_template_part( 'template-parts/components/subscribe-block' );
get_footer();
