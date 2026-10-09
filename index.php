<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<div class="nbs-shell nbs-page-heading">
    <span class="nbs-kicker"><?php esc_html_e( 'Архив', 'tihaya-lenta' ); ?></span>
    <h1><?php bloginfo( 'name' ); ?></h1>
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
            <p class="nbs-muted"><?php esc_html_e( 'Материалы не найдены.', 'tihaya-lenta' ); ?></p>
        <?php endif; ?>
    </section>
    <?php get_template_part( 'template-parts/components/sidebar' ); ?>
</div>
<?php get_footer(); ?>
