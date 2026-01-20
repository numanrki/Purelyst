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
            $image_url = get_the_post_thumbnail_url( get_the_ID(), 'purelyst-card' );
            ?>
            <div class="article-thumbnail-inner" style="background-image: url('<?php echo esc_url( $image_url ); ?>');"></div>
        <?php else : ?>
            <div class="article-thumbnail-inner article-thumbnail-placeholder">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.svg' ); ?>" alt="" class="placeholder-svg">
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
