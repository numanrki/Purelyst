<?php
/**
 * Page template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
            <header class="page-header">
                <div class="page-header-inner">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </div>
            </header>

            <!-- Featured Image -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="page-featured-image">
                    <?php
                    $thumbnail_id = get_post_thumbnail_id();
                    $image_data = wp_get_attachment_image_src( $thumbnail_id, 'purelyst-hero' );
                    
                    if ( $image_data ) {
                        $alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                        if ( empty( $alt_text ) ) {
                            $alt_text = get_the_title();
                        }
                        
                        printf(
                            '<img src="%s" alt="%s" width="%d" height="%d" loading="eager" fetchpriority="high" decoding="async">',
                            esc_url( $image_data[0] ),
                            esc_attr( $alt_text ),
                            esc_attr( $image_data[1] ),
                            esc_attr( $image_data[2] )
                        );
                    }
                    ?>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <div class="page-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'purelyst' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <!-- Comments -->
            <?php
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            ?>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
