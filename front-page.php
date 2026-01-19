<?php
/**
 * The front page template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Get featured post for hero section
$hero_post_id = get_theme_mod( 'purelyst_hero_post', '' );

if ( $hero_post_id ) {
    $hero_query = new WP_Query( array(
        'p' => $hero_post_id,
        'post_type' => 'post',
    ) );
} else {
    // Get latest sticky post or latest post
    $sticky = get_option( 'sticky_posts' );
    
    if ( ! empty( $sticky ) ) {
        $hero_query = new WP_Query( array(
            'post__in' => $sticky,
            'posts_per_page' => 1,
            'ignore_sticky_posts' => 1,
        ) );
    } else {
        $hero_query = new WP_Query( array(
            'posts_per_page' => 1,
        ) );
    }
}
?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <?php if ( $hero_query->have_posts() ) : $hero_query->the_post(); ?>
        <section class="hero-section">
            <div class="hero-inner">
                <div class="hero-content">
                    <div class="hero-text">
                        <span class="featured-badge">
                            <span class="featured-badge-dot"></span>
                            <?php echo esc_html( get_theme_mod( 'purelyst_hero_badge', __( 'Featured Story', 'purelyst' ) ) ); ?>
                        </span>
                        
                        <h1 class="hero-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h1>
                        
                        <p class="hero-excerpt">
                            <?php 
                            if ( has_excerpt() ) {
                                echo esc_html( get_the_excerpt() );
                            } else {
                                echo esc_html( wp_trim_words( get_the_content(), 30 ) );
                            }
                            ?>
                        </p>
                        
                        <div class="hero-cta">
                            <a href="<?php the_permalink(); ?>" class="btn-primary">
                                <?php echo esc_html( get_theme_mod( 'purelyst_hero_button_text', __( 'Read Article', 'purelyst' ) ) ); ?>
                                <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="hero-image">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="hero-image-wrapper">
                                <?php 
                                $image_url = get_the_post_thumbnail_url( get_the_ID(), 'purelyst-hero' );
                                ?>
                                <div class="hero-image-inner" style="background-image: url('<?php echo esc_url( $image_url ); ?>');"></div>
                            </div>
                        <?php else : ?>
                            <div class="hero-image-placeholder">
                                <span class="material-symbols-outlined" aria-hidden="true">image</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php 
    $hero_post_id_exclude = get_the_ID();
    wp_reset_postdata();
    endif; 
    ?>

    <!-- Recent Stories Section -->
    <div class="main-content">
        <div class="content-area">
            <!-- Section Header -->
            <div class="section-header">
                <h2 class="section-title">
                    <?php echo esc_html( get_theme_mod( 'purelyst_recent_posts_title', __( 'Recent Stories', 'purelyst' ) ) ); ?>
                </h2>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="view-all-link">
                    <?php esc_html_e( 'View All', 'purelyst' ); ?>
                    <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                </a>
            </div>

            <?php
            // Query for recent posts excluding the hero post
            $recent_posts = new WP_Query( array(
                'posts_per_page' => 6,
                'post__not_in'   => isset( $hero_post_id_exclude ) ? array( $hero_post_id_exclude ) : array(),
                'ignore_sticky_posts' => 1,
            ) );

            if ( $recent_posts->have_posts() ) :
            ?>
                <div class="articles-grid" id="articles-grid">
                    <?php
                    while ( $recent_posts->have_posts() ) :
                        $recent_posts->the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile;
                    ?>
                </div>

                <?php if ( $recent_posts->max_num_pages > 1 ) : ?>
                    <div class="load-more-wrapper">
                        <button class="load-more-btn" data-page="1" data-max-pages="<?php echo esc_attr( $recent_posts->max_num_pages ); ?>">
                            <?php echo esc_html( get_theme_mod( 'purelyst_load_more_text', __( 'Load More Stories', 'purelyst' ) ) ); ?>
                            <span class="material-symbols-outlined" aria-hidden="true">expand_more</span>
                        </button>
                    </div>
                <?php endif; ?>
            <?php 
            wp_reset_postdata();
            else : 
            ?>
                <p><?php esc_html_e( 'No posts found.', 'purelyst' ); ?></p>
            <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php
get_footer();
