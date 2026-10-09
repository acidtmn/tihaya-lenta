<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tl_theme_sidebar_posts = tl_theme_get_sidebar_posts();
$tl_theme_sections      = get_terms(
    array(
        'taxonomy'   => 'category',
        'hide_empty' => true,
        'number'     => 8,
    )
);
?>
<aside class="nbs-sidebar" aria-label="<?php esc_attr_e( 'Дополнительные материалы', 'tihaya-lenta' ); ?>">
    <section class="nbs-sidebar-panel">
        <div class="nbs-section-heading">
            <span><?php esc_html_e( 'В фокусе', 'tihaya-lenta' ); ?></span>
            <h2><?php esc_html_e( 'Обсуждают', 'tihaya-lenta' ); ?></h2>
        </div>
        <?php if ( $tl_theme_sidebar_posts ) : ?>
            <ol class="nbs-ranked-list">
                <?php foreach ( $tl_theme_sidebar_posts as $tl_theme_sidebar_post ) : ?>
                    <li>
                        <a href="<?php echo esc_url( get_permalink( $tl_theme_sidebar_post ) ); ?>"><?php echo esc_html( get_the_title( $tl_theme_sidebar_post ) ); ?></a>
                        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $tl_theme_sidebar_post ) ); ?>"><?php echo esc_html( get_the_time( get_option( 'time_format' ), $tl_theme_sidebar_post ) ); ?></time>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php else : ?>
            <p class="nbs-muted"><?php esc_html_e( 'Список сформируется после первых публикаций.', 'tihaya-lenta' ); ?></p>
        <?php endif; ?>
    </section>

    <?php if ( ! empty( $tl_theme_sections ) && ! is_wp_error( $tl_theme_sections ) ) : ?>
        <section class="nbs-sidebar-panel">
            <div class="nbs-section-heading">
                <span><?php esc_html_e( 'Навигация', 'tihaya-lenta' ); ?></span>
                <h2><?php esc_html_e( 'Разделы', 'tihaya-lenta' ); ?></h2>
            </div>
            <div class="nbs-topic-cloud">
                <?php foreach ( $tl_theme_sections as $tl_theme_section ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $tl_theme_section ) ); ?>"><?php echo esc_html( $tl_theme_section->name ); ?></a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</aside>
