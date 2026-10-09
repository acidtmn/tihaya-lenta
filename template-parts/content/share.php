<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tl_theme_share_url   = rawurlencode( get_permalink() );
$tl_theme_share_title = rawurlencode( wp_strip_all_tags( get_the_title() ) );
?>
<div class="nbs-share" aria-label="<?php esc_attr_e( 'Поделиться материалом', 'tihaya-lenta' ); ?>">
    <strong><?php esc_html_e( 'Поделиться', 'tihaya-lenta' ); ?></strong>
    <a href="https://t.me/share/url?url=<?php echo esc_attr( $tl_theme_share_url ); ?>&amp;text=<?php echo esc_attr( $tl_theme_share_title ); ?>" target="_blank" rel="noopener noreferrer">Telegram</a>
    <a href="https://vk.com/share.php?url=<?php echo esc_attr( $tl_theme_share_url ); ?>" target="_blank" rel="noopener noreferrer">VK</a>
    <button type="button" data-copy-link="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Копировать ссылку', 'tihaya-lenta' ); ?></button>
    <span class="nbs-copy-status" data-copy-status aria-live="polite"></span>
</div>
