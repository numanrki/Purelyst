<?php
/**
 * Single post template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- Reading Progress Bar -->
<div class="reading-progress-container">
    <div class="reading-progress-bar" id="reading-progress"></div>
</div>

<main id="primary" class="site-main single-post-main">
    <div class="single-content-wrapper">
        <div class="single-content-layout">
            <!-- Article Column -->
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>
                    
                    <!-- Article Header Card -->
                    <div class="article-header-card">
                        <!-- Category Chip -->
                        <div class="article-category-wrapper">
                            <?php
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) {
                                $category = $categories[0];
                                printf(
                                    '<a href="%s" class="article-category-chip">%s</a>',
                                    esc_url( get_category_link( $category->term_id ) ),
                                    esc_html( $category->name )
                                );
                            }
                            ?>
                        </div>

                        <!-- Title -->
                        <h1 class="single-post-title"><?php the_title(); ?></h1>

                        <!-- Meta Data -->
                        <div class="article-meta-bar">
                            <div class="article-author-info">
                                <?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', get_the_author(), array( 'class' => 'author-avatar-medium' ) ); ?>
                                <div class="author-details">
                                    <span class="author-name"><?php the_author(); ?></span>
                                    <div class="article-date-reading">
                                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></time>
                                        <span class="meta-dot"></span>
                                        <span><?php echo esc_html( purelyst_reading_time() ); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="article-actions">
                                <button class="article-action-btn" aria-label="<?php esc_attr_e( 'Bookmark', 'purelyst' ); ?>">
                                    <span class="material-symbols-outlined">bookmark_border</span>
                                </button>
                                <button class="article-action-btn share-btn" aria-label="<?php esc_attr_e( 'Share', 'purelyst' ); ?>" data-url="<?php the_permalink(); ?>" data-title="<?php the_title_attribute(); ?>">
                                    <span class="material-symbols-outlined">share</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="single-featured-image">
                            <?php
                            $thumbnail_id = get_post_thumbnail_id();
                            $image_data = wp_get_attachment_image_src( $thumbnail_id, 'purelyst-hero' );
                            
                            if ( $image_data ) {
                                $alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                                if ( empty( $alt_text ) ) {
                                    $alt_text = get_the_title();
                                }
                                
                                printf(
                                    '<img src="%s" alt="%s" width="%d" height="%d" class="featured-image-inner" loading="eager" fetchpriority="high" decoding="async">',
                                    esc_url( $image_data[0] ),
                                    esc_attr( $alt_text ),
                                    esc_attr( $image_data[1] ),
                                    esc_attr( $image_data[2] )
                                );
                            }
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Article Body Card -->
                    <div class="article-body-card">
                        <div class="article-content drop-cap-content">
                            <?php the_content(); ?>

                            <?php
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'purelyst' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>

                        <!-- Tags -->
                        <?php
                        $tags = get_the_tags();
                        if ( $tags ) :
                        ?>
                            <div class="article-tags">
                                <?php
                                foreach ( $tags as $tag ) {
                                    printf(
                                        '<a href="%s" class="article-tag">%s</a>',
                                        esc_url( get_tag_link( $tag->term_id ) ),
                                        esc_html( $tag->name )
                                    );
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>

                <!-- Post Navigation -->
                <?php purelyst_post_navigation(); ?>

                <!-- Comments -->
                <?php
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
            <?php endwhile; ?>

            <!-- Sidebar -->
            <?php get_sidebar( 'single' ); ?>
        </div>
    </div>
</main>

<?php
get_footer();
