<?php
/**
 * The header template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary">
    <?php esc_html_e( 'Skip to content', 'purelyst' ); ?>
</a>

<header class="site-header" role="banner">
    <div class="header-inner">
        <!-- Logo -->
        <?php purelyst_site_logo(); ?>

        <!-- Desktop Navigation -->
        <?php purelyst_primary_navigation(); ?>

        <!-- Header Actions -->
        <div class="header-actions">
            <?php if ( get_theme_mod( 'purelyst_show_search', true ) ) : ?>
                <button class="search-toggle" aria-label="<?php esc_attr_e( 'Search', 'purelyst' ); ?>" aria-expanded="false" data-search-toggle>
                    <span class="material-symbols-outlined" aria-hidden="true">search</span>
                </button>
            <?php endif; ?>

            <?php
            $subscribe_url = get_theme_mod( 'purelyst_header_subscribe_url', '' );
            $subscribe_text = get_theme_mod( 'purelyst_header_subscribe_text', __( 'Subscribe', 'purelyst' ) );
            
            if ( empty( $subscribe_url ) ) {
                $subscribe_url = '#newsletter-widget';
            }
            ?>
            <a href="<?php echo esc_url( $subscribe_url ); ?>" class="btn-subscribe">
                <?php echo esc_html( $subscribe_text ); ?>
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle Menu', 'purelyst' ); ?>" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
                <span class="material-symbols-outlined" aria-hidden="true">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <?php purelyst_mobile_navigation(); ?>
</header>
