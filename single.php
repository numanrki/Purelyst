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
            <div class="single-main-column">
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

                <!-- Author Box -->
                <?php
                $purelyst_settings = get_option( 'purelyst_settings', array() );
                $author_box_enable = isset( $purelyst_settings['author_box_enable'] ) ? $purelyst_settings['author_box_enable'] : true;
                
                if ( $author_box_enable ) :
                    $author_id = get_the_author_meta( 'ID' );
                    $author_name = get_the_author();
                    $author_bio = get_the_author_meta( 'description' );
                    $author_title = get_theme_mod( 'purelyst_author_title', __( 'Writer', 'purelyst' ) );
                    $author_url = get_author_posts_url( $author_id );
                    $show_social = isset( $purelyst_settings['author_box_show_social'] ) ? $purelyst_settings['author_box_show_social'] : true;
                    $custom_image_id = isset( $purelyst_settings['author_box_image'] ) ? absint( $purelyst_settings['author_box_image'] ) : 0;
                    
                    // Get author avatar - custom image or Gravatar
                    if ( $custom_image_id ) {
                        $author_avatar = wp_get_attachment_image( $custom_image_id, array( 96, 96 ), false, array( 'class' => 'author-box-avatar' ) );
                    } else {
                        $author_avatar = get_avatar( $author_id, 96, '', $author_name, array( 'class' => 'author-box-avatar' ) );
                    }
                ?>
                <div class="author-box">
                    <div class="author-box-avatar-wrapper">
                        <?php echo $author_avatar; ?>
                    </div>
                    <div class="author-box-content">
                        <span class="author-box-label"><?php esc_html_e( 'Written by', 'purelyst' ); ?></span>
                        <h4 class="author-box-name">
                            <a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a>
                        </h4>
                        <?php if ( $author_title ) : ?>
                            <span class="author-box-title"><?php echo esc_html( $author_title ); ?></span>
                        <?php endif; ?>
                        <?php if ( $author_bio ) : ?>
                            <p class="author-box-bio"><?php echo esc_html( $author_bio ); ?></p>
                        <?php endif; ?>
                        <?php if ( $show_social ) : ?>
                            <div class="author-box-social">
                                <?php
                                $twitter = get_the_author_meta( 'twitter', $author_id );
                                $facebook = get_the_author_meta( 'facebook', $author_id );
                                $instagram = get_the_author_meta( 'instagram', $author_id );
                                $linkedin = get_the_author_meta( 'linkedin', $author_id );
                                $website = get_the_author_meta( 'url', $author_id );
                                
                                if ( $twitter ) : ?>
                                    <a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Twitter', 'purelyst' ); ?>">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $facebook ) : ?>
                                    <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'purelyst' ); ?>">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $instagram ) : ?>
                                    <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'purelyst' ); ?>">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $linkedin ) : ?>
                                    <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn', 'purelyst' ); ?>">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $website ) : ?>
                                    <a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Website', 'purelyst' ); ?>">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Post Navigation -->
                <?php purelyst_post_navigation(); ?>

                <!-- Comments -->
                <?php
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
                <?php endwhile; ?>
            </div>

            <!-- Sidebar -->
            <?php get_sidebar( 'single' ); ?>
        </div>
    </div>
</main>

<?php
get_footer();
