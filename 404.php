<?php
/**
 * 404 error page template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <div class="error-404-wrapper">
        <div class="error-404-inner">
            <h1 class="page-title"><?php esc_html_e( 'Page Not Found', 'purelyst' ); ?></h1>
            
            <p class="error-description">
                <?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'purelyst' ); ?>
            </p>
            
            <?php get_search_form(); ?>
            
            <div class="error-actions">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary">
                    <?php esc_html_e( 'Back to Home', 'purelyst' ); ?>
                </a>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
