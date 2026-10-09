<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
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
                <h2><?php esc_html_e( 'Здесь пока нет материалов', 'tihaya-lenta' ); ?></h2>
                <p><?php esc_html_e( 'Попробуйте выбрать другой раздел или перейти на главную.', 'tihaya-lenta' ); ?></p>
            </div>
        <?php endif; ?>
    </section>
    <?php get_template_part( 'template-parts/components/sidebar' ); ?>
</div>
