<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
</main>
<footer class="nbs-site-footer">
    <div class="nbs-shell nbs-footer-grid">
        <div class="nbs-footer-brand">
            <strong><?php bloginfo( 'name' ); ?></strong>
            <p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
        </div>
        <nav aria-label="<?php esc_attr_e( 'Навигация в подвале', 'tihaya-lenta' ); ?>">
            <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'nbs-footer-menu', 'fallback_cb' => false ) ); ?>
        </nav>
        <?php if ( tl_theme_get_channels() ) : ?>
            <div class="nbs-footer-subscribe">
                <span class="nbs-kicker"><?php esc_html_e( 'Оставайтесь в курсе', 'tihaya-lenta' ); ?></span>
                <?php get_template_part( 'template-parts/components/channel-options', null, array( 'modifier' => 'nbs-subscribe-options--footer' ) ); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="nbs-shell nbs-footer-bottom">
        <span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
        <?php if ( get_theme_mod( 'tl_theme_show_credit', true ) ) : ?>
            <span><?php esc_html_e( 'Тема «Тихая лента»', 'tihaya-lenta' ); ?> · <a href="https://kodalexandrova.ru" rel="author"><?php esc_html_e( 'Кирилл Александров', 'tihaya-lenta' ); ?></a></span>
        <?php endif; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
