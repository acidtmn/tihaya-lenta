<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<header class="nbs-shell nbs-page-heading">
    <span class="nbs-kicker"><?php esc_html_e( 'Архив редакции', 'tihaya-lenta' ); ?></span>
    <?php the_archive_title( '<h1>', '</h1>' ); ?>
    <?php the_archive_description( '<div class="nbs-archive-description">', '</div>' ); ?>
</header>
<?php
get_template_part( 'template-parts/content/archive-loop' );
get_template_part( 'template-parts/components/subscribe-block' );
get_footer();
