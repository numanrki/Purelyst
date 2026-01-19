<?php
/**
 * Search results template
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
                <h1 class="section-title">
                    <?php
                    printf(
                        /* translators: %s: search query */
                        esc_html__( 'Search Results for: %s', 'purelyst' ),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
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
                the_posts_pagination( array(
                    'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>' . esc_html__( 'Previous', 'purelyst' ),
                    'next_text' => esc_html__( 'Next', 'purelyst' ) . '<span class="material-symbols-outlined">chevron_right</span>',
                    'class'     => 'pagination',
                ) );
                ?>
            <?php else : ?>
                <?php get_template_part( 'template-parts/content', 'none' ); ?>
            <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</main>

<?php
get_footer();
