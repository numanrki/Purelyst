<?php
/**
 * The main template file
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <div class="main-content">
        <div class="content-area">
            <!-- Section Header -->
            <div class="section-header">
                <h2 class="section-title">
                    <?php
                    if ( is_home() && ! is_front_page() ) {
                        single_post_title();
                    } elseif ( is_home() ) {
                        echo esc_html( get_theme_mod( 'purelyst_recent_posts_title', __( 'Recent Stories', 'purelyst' ) ) );
                    } elseif ( is_category() || is_tag() || is_author() ) {
                        the_archive_title();
                    } elseif ( is_search() ) {
                        printf(
                            /* translators: %s: search query */
                            esc_html__( 'Search Results for: %s', 'purelyst' ),
                            '<span>' . get_search_query() . '</span>'
                        );
                    }
                    ?>
                </h2>
                <?php if ( is_home() ) : ?>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="view-all-link">
                        <?php esc_html_e( 'View All', 'purelyst' ); ?>
                        <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ( have_posts() ) : ?>
                <div class="articles-grid" id="articles-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile;
                    ?>
                </div>

                <?php
                global $wp_query;
                $max_pages = $wp_query->max_num_pages;
                
                if ( $max_pages > 1 ) :
                    ?>
                        <div class="load-more-wrapper">
                            <button class="load-more-btn" data-page="1" data-max-pages="<?php echo esc_attr( $max_pages ); ?>">
                                <?php echo esc_html( get_theme_mod( 'purelyst_load_more_text', __( 'Load More Stories', 'purelyst' ) ) ); ?>
                                <span class="material-symbols-outlined" aria-hidden="true">expand_more</span>
                            </button>
                        </div>

                        <!-- Fallback pagination for no-JS -->
                        <noscript>
                            <nav class="pagination" role="navigation" aria-label="<?php esc_attr_e( 'Posts navigation', 'purelyst' ); ?>">
                                <?php
                                echo paginate_links( array(
                                    'prev_text' => __( '&larr; Previous', 'purelyst' ),
                                    'next_text' => __( 'Next &rarr;', 'purelyst' ),
                                ) );
                                ?>
                            </nav>
                        </noscript>
                    <?php endif; ?>
                <?php else : ?>
                    <?php get_template_part( 'template-parts/content', 'none' ); ?>
                <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php
get_footer();
