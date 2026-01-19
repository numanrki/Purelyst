<?php
/**
 * Template part for displaying when no content is found
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<section class="no-results not-found">
    <div class="no-results-inner">
        <h3 class="section-title"><?php esc_html_e( 'Nothing Found', 'purelyst' ); ?></h3>

        <div class="page-content">
            <?php
            if ( is_home() && current_user_can( 'publish_posts' ) ) :
                printf(
                    '<p>' . wp_kses(
                        /* translators: %1$s: Link to new post */
                        __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'purelyst' ),
                        array(
                            'a' => array(
                                'href' => array(),
                            ),
                        )
                    ) . '</p>',
                    esc_url( admin_url( 'post-new.php' ) )
                );
            elseif ( is_search() ) :
            ?>
                <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'purelyst' ); ?></p>
                <?php get_search_form(); ?>
            <?php else : ?>
                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'purelyst' ); ?></p>
                <?php get_search_form(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
