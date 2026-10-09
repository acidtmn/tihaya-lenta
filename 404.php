<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<section class="nbs-not-found nbs-shell">
    <div class="nbs-not-found-code" aria-hidden="true">404</div>
    <div>
        <span class="nbs-kicker"><?php esc_html_e( 'Страница потерялась в ленте', 'tihaya-lenta' ); ?></span>
        <h1><?php esc_html_e( 'Похоже, такой страницы больше нет', 'tihaya-lenta' ); ?></h1>
        <p><?php esc_html_e( 'Проверьте адрес, воспользуйтесь поиском или вернитесь к свежим новостям.', 'tihaya-lenta' ); ?></p>
        <?php get_search_form(); ?>
        <a class="nbs-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'На главную', 'tihaya-lenta' ); ?></a>
    </div>
</section>
<?php get_footer(); ?>
