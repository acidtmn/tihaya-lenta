<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tl_theme_related = tl_theme_related_query( get_the_ID(), 3 );

if ( ! $tl_theme_related->have_posts() ) {
    return;
}
?>
<section class="nbs-related" aria-labelledby="nbs-related-title">
    <div class="nbs-section-heading">
        <span><?php esc_html_e( 'Продолжение темы', 'tihaya-lenta' ); ?></span>
        <h2 id="nbs-related-title"><?php esc_html_e( 'Связанные новости', 'tihaya-lenta' ); ?></h2>
    </div>
    <div class="nbs-card-grid nbs-card-grid--three">
        <?php while ( $tl_theme_related->have_posts() ) : ?>
            <?php $tl_theme_related->the_post(); ?>
            <?php get_template_part( 'template-parts/cards/card', null, array( 'variant' => 'related' ) ); ?>
        <?php endwhile; ?>
    </div>
</section>
<?php wp_reset_postdata(); ?>
