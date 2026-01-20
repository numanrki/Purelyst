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
    <a href="<?php the_permalink(); ?>" class="article-thumbnail">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php
            $thumbnail_id = get_post_thumbnail_id();
            $image_src = wp_get_attachment_image_src( $thumbnail_id, 'purelyst-card' );
            $image_srcset = wp_get_attachment_image_srcset( $thumbnail_id, 'purelyst-card' );
            $image_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
            
            if ( ! $image_alt ) {
                $image_alt = get_the_title();
            }
            ?>
            <img 
                src="<?php echo esc_url( $image_src[0] ); ?>"
                <?php if ( $image_srcset ) : ?>
                srcset="<?php echo esc_attr( $image_srcset ); ?>"
                sizes="(min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw"
                <?php endif; ?>
                width="<?php echo esc_attr( $image_src[1] ); ?>"
                height="<?php echo esc_attr( $image_src[2] ); ?>"
                alt="<?php echo esc_attr( $image_alt ); ?>"
                class="article-thumbnail-inner"
                loading="lazy"
                decoding="async"
            >
        <?php else : ?>
            <div class="article-thumbnail-inner article-thumbnail-placeholder">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.svg' ); ?>" alt="" class="placeholder-svg" loading="lazy">
            </div>
        <?php endif; ?>
    </a>

    <div class="article-content">
        <span class="article-category">
            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                echo esc_html( $categories[0]->name );
            }
            ?>
        </span>

        <h3 class="article-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="article-excerpt">
            <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
        </p>

        <div class="article-footer">
            <div class="article-meta">
                <span class="meta-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
                <span class="meta-separator">•</span>
                <span class="meta-reading-time"><?php echo esc_html( purelyst_reading_time() ); ?></span>
            </div>
            <?php 
            $purelyst_settings = get_option( 'purelyst_settings', array() );
            $read_more_enable = isset( $purelyst_settings['read_more_enable'] ) ? $purelyst_settings['read_more_enable'] : true;
            $read_more_text = isset( $purelyst_settings['read_more_text'] ) && ! empty( $purelyst_settings['read_more_text'] ) ? $purelyst_settings['read_more_text'] : __( 'Read More', 'purelyst' );
            
            if ( $read_more_enable ) : ?>
                <a href="<?php the_permalink(); ?>" class="read-more-btn">
                    <?php echo esc_html( $read_more_text ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</article>
