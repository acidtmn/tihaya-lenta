<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( post_password_required() ) {
    return;
}
?>
<section class="nbs-comments" id="comments">
    <?php if ( have_comments() ) : ?>
        <h2>
            <?php
            printf(
                /* translators: %s - число комментариев. */
                esc_html( _n( '%s комментарий', '%s комментариев', get_comments_number(), 'tihaya-lenta' ) ),
                esc_html( number_format_i18n( get_comments_number() ) )
            );
            ?>
        </h2>
        <ol class="nbs-comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'      => 'ol',
                    'short_ping' => true,
                    'avatar_size' => 48,
                )
            );
            ?>
        </ol>
        <?php the_comments_navigation(); ?>
    <?php endif; ?>

    <?php if ( comments_open() ) : ?>
        <?php comment_form(); ?>
    <?php elseif ( get_comments_number() ) : ?>
        <p class="nbs-muted"><?php esc_html_e( 'Обсуждение закрыто.', 'tihaya-lenta' ); ?></p>
    <?php endif; ?>
</section>
