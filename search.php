<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<header class="nbs-shell nbs-page-heading nbs-search-heading">
    <span class="nbs-kicker"><?php esc_html_e( 'Поиск по сайту', 'tihaya-lenta' ); ?></span>
    <h1>
        <?php
        printf(
            /* translators: %s - текст поискового запроса. */
            esc_html__( 'Результаты для «%s»', 'tihaya-lenta' ),
            esc_html( get_search_query() )
        );
        ?>
    </h1>
    <?php get_search_form(); ?>
</header>
<?php
get_template_part( 'template-parts/content/archive-loop' );
get_footer();
