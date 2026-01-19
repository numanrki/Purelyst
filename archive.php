<?php
/**
 * Archive template
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
            <!-- Archive Header -->
            <header class="archive-header">
                <?php the_archive_title( '<h1 class="archive-title">', '</h1>' ); ?>
                <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
            </header>

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
