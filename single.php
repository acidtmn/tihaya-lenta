<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<?php while ( have_posts() ) : ?>
    <?php the_post(); ?>
    <?php $tl_theme_single_image = tl_theme_get_post_image( get_the_ID(), 'nbs-hero' ); ?>
    <article <?php post_class( 'nbs-article' ); ?>>
        <header class="nbs-article-header nbs-shell">
            <?php tl_theme_card_meta( get_the_ID() ); ?>
            <h1><?php the_title(); ?></h1>
            <?php if ( has_excerpt() && ! post_password_required() ) : ?>
                <p class="nbs-article-lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>
            <div class="nbs-article-byline">
                <span><?php echo esc_html( get_the_author() ); ?></span>
                <span><?php /* translators: %d - примерное число минут чтения. */ echo esc_html( sprintf( __( '%d мин. чтения', 'tihaya-lenta' ), tl_theme_reading_minutes( get_the_ID() ) ) ); ?></span>
                <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() . ', ' . get_the_time() ); ?></time>
            </div>
        </header>

        <?php if ( $tl_theme_single_image && ! post_password_required() ) : ?>
            <div class="nbs-article-media">
                <?php the_post_thumbnail( 'nbs-hero', array( 'loading' => 'eager' ) ); ?>
            </div>
        <?php endif; ?>

        <div class="nbs-shell nbs-article-layout">
            <div class="nbs-article-main">
                <div class="nbs-article-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages(); ?>
                </div>
                <?php get_template_part( 'template-parts/content/share' ); ?>
                <?php get_template_part( 'template-parts/content/related' ); ?>
                <?php comments_template(); ?>
            </div>
            <?php get_template_part( 'template-parts/components/sidebar' ); ?>
        </div>
    </article>
<?php endwhile; ?>
<?php get_footer(); ?>
