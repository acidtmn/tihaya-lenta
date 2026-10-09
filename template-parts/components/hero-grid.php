<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tl_theme_hero = tl_theme_hero_query( 5 );
?>
<section class="nbs-hero nbs-shell" aria-label="<?php esc_attr_e( 'Главные новости', 'tihaya-lenta' ); ?>">
    <?php if ( is_home() ) : ?>
    <h1 id="nbs-home-title" class="screen-reader-text">
        <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
    </h1>
    <?php endif; ?>

    <?php if ( $tl_theme_hero->have_posts() ) : ?>
        <div class="nbs-hero-grid">
            <?php
            $tl_theme_hero_index = 0;
            while ( $tl_theme_hero->have_posts() ) :
                $tl_theme_hero->the_post();
                $tl_theme_variant = 0 === $tl_theme_hero_index ? 'feature' : 'compact';
                get_template_part( 'template-parts/cards/card', null, array( 'variant' => $tl_theme_variant ) );
                $tl_theme_hero_index++;
            endwhile;
            ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <div class="nbs-empty-state">
            <span class="nbs-empty-state-mark">ТЛ<i></i></span>
            <p class="nbs-kicker"><?php esc_html_e( 'Редакция на связи', 'tihaya-lenta' ); ?></p>
            <h2><?php esc_html_e( 'Здесь появятся главные новости', 'tihaya-lenta' ); ?></h2>
            <p><?php esc_html_e( 'Свежие материалы появятся здесь после первой публикации.', 'tihaya-lenta' ); ?></p>
        </div>
    <?php endif; ?>
</section>
