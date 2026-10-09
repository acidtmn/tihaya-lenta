<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! get_theme_mod( 'tl_theme_show_channels', true ) || ! tl_theme_get_channels() ) {
    return;
}
?>
<section class="nbs-subscribe nbs-shell" aria-labelledby="nbs-subscribe-title">
    <div class="nbs-subscribe-visual tl-subscribe-art" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="nbs-subscribe-copy">
        <span class="nbs-kicker"><?php esc_html_e( 'Всегда рядом', 'tihaya-lenta' ); ?></span>
        <h2 id="nbs-subscribe-title"><?php esc_html_e( 'Читайте новости там, где удобно', 'tihaya-lenta' ); ?></h2>
        <p><?php esc_html_e( 'Следите за новыми публикациями в любимом канале.', 'tihaya-lenta' ); ?></p>
        <?php get_template_part( 'template-parts/components/channel-options' ); ?>
    </div>
</section>
