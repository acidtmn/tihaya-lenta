<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tl_theme_variant   = isset( $args['variant'] ) ? sanitize_html_class( $args['variant'] ) : 'standard';
$tl_theme_post_id   = get_the_ID();
$tl_theme_image_url = tl_theme_get_post_image( $tl_theme_post_id, 'nbs-card' );
?>
<article <?php post_class( 'nbs-card nbs-card--' . $tl_theme_variant ); ?>>
    <?php if ( $tl_theme_image_url && ! post_password_required() ) : ?>
        <a class="nbs-card-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
            <?php the_post_thumbnail( 'feature' === $tl_theme_variant ? 'nbs-hero' : 'nbs-card', array( 'alt' => '', 'loading' => 'feature' === $tl_theme_variant ? 'eager' : 'lazy', 'fetchpriority' => 'feature' === $tl_theme_variant ? 'high' : 'auto' ) ); ?>
        </a>
    <?php endif; ?>
    <div class="nbs-card-body">
        <?php tl_theme_card_meta( $tl_theme_post_id ); ?>
        <h2 class="nbs-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if ( 'compact' !== $tl_theme_variant ) : ?>
            <div class="nbs-card-excerpt"><?php the_excerpt(); ?></div>
        <?php endif; ?>
    </div>
</article>
