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
    <!-- Preconnect for Material Symbols icons only (fonts are self-hosted) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Preload critical self-hosted font -->
    <link rel="preload" href="<?php echo esc_url( get_template_directory_uri() . '/assets/fonts/manrope-latin.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php purelyst_critical_css(); ?>
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
                    <span class="material-symbols-outlined search-icon" aria-hidden="true">search</span>
                    <span class="material-symbols-outlined close-icon" aria-hidden="true">close</span>
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

    <!-- Search Bar Slide Down -->
    <div class="search-bar-wrapper" id="search-bar" aria-hidden="true">
        <div class="search-bar-inner">
            <form role="search" method="get" class="search-bar-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <span class="material-symbols-outlined search-bar-icon" aria-hidden="true">search</span>
                <input type="search" class="search-bar-input" placeholder="<?php esc_attr_e( 'Search articles...', 'purelyst' ); ?>" value="<?php echo get_search_query(); ?>" name="s" id="header-search-input" autocomplete="off">
                <button type="submit" class="search-bar-submit">
                    <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <?php purelyst_mobile_navigation(); ?>
</header>
