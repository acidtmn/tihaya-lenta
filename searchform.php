<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form class="nbs-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" data-live-search-form>
    <label>
        <span class="screen-reader-text"><?php esc_html_e( 'Поиск по сайту', 'tihaya-lenta' ); ?></span>
        <input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Начните вводить заголовок…', 'tihaya-lenta' ); ?>" autocomplete="off" data-live-search-input>
    </label>
    <button type="submit"><?php esc_html_e( 'Найти', 'tihaya-lenta' ); ?></button>
</form>
