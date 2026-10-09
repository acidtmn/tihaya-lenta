<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<?php while ( have_posts() ) : ?>
    <?php the_post(); ?>
    <article <?php post_class( 'nbs-page nbs-shell' ); ?>>
        <header class="nbs-page-heading nbs-page-heading--inside">
            <span class="nbs-kicker"><?php bloginfo( 'name' ); ?></span>
            <h1><?php the_title(); ?></h1>
        </header>
        <div class="nbs-page-content">
            <?php the_content(); ?>
            <?php wp_link_pages(); ?>
        </div>
        <?php if ( comments_open() || get_comments_number() ) : ?>
            <?php comments_template(); ?>
        <?php endif; ?>
    </article>
<?php endwhile; ?>
<?php get_footer(); ?>
