<?php
/**
 * Template part for displaying article cards
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="article-image-link">
            <?php
            $thumbnail_id = get_post_thumbnail_id();
            $image_data = wp_get_attachment_image_src( $thumbnail_id, 'purelyst-card' );
            
            if ( $image_data ) {
                $alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                if ( empty( $alt_text ) ) {
                    $alt_text = get_the_title();
                }
                
                printf(
                    '<img src="%s" alt="%s" width="%d" height="%d" class="article-image" loading="lazy" decoding="async">',
                    esc_url( $image_data[0] ),
                    esc_attr( $alt_text ),
                    esc_attr( $image_data[1] ),
                    esc_attr( $image_data[2] )
                );
            }
            ?>
        </a>
    <?php endif; ?>

    <div class="article-content">
        <?php purelyst_post_categories(); ?>

        <h3 class="article-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="article-excerpt">
            <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
        </p>

        <?php purelyst_post_meta(); ?>
    </div>
</article>
