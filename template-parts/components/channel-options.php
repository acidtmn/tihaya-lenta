<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tl_channels = tl_theme_get_channels();
if ( ! $tl_channels ) {
    return;
}
$tl_modifier = isset( $args['modifier'] ) ? sanitize_html_class( $args['modifier'] ) : '';
?>
<div class="<?php echo esc_attr( trim( 'nbs-subscribe-options ' . $tl_modifier ) ); ?>">
    <?php foreach ( $tl_channels as $tl_channel ) : ?>
        <a href="<?php echo esc_url( $tl_channel['url'] ); ?>">
            <span class="tl-channel-symbol" aria-hidden="true">↗</span>
            <span><strong><?php echo esc_html( $tl_channel['label'] ); ?></strong><?php esc_html_e( 'Читать новости', 'tihaya-lenta' ); ?></span>
        </a>
    <?php endforeach; ?>
</div>
