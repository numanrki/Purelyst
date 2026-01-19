<?php
/**
 * Comments template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php
    if ( have_comments() ) :
        $comment_count = get_comments_number();
    ?>
        <h2 class="comments-title">
            <?php
            if ( '1' === $comment_count ) {
                printf(
                    /* translators: %1$s: Post title */
                    esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'purelyst' ),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    /* translators: %1$s: Comment count, %2$s: Post title */
                    esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'purelyst' ) ),
                    number_format_i18n( $comment_count ),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if ( ! comments_open() ) :
        ?>
            <p class="no-comments">
                <?php esc_html_e( 'Comments are closed.', 'purelyst' ); ?>
            </p>
        <?php
        endif;
    endif;

    comment_form( array(
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h2>',
    ) );
    ?>
</div>
