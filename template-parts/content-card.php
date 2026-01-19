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
                <span class="material-icons">image</span>
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

        <div class="article-meta">
            <span class="meta-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
            <span class="meta-separator">•</span>
            <span class="meta-reading-time"><?php echo esc_html( purelyst_reading_time() ); ?></span>
        </div>
    </div>
</article>
