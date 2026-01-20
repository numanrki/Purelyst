<?php
/**
 * Purelyst Theme Functions
 *
 * @package Purelyst
 * @author Numan Rasheed
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define theme constants
 */
define( 'PURELYST_VERSION', '1.0.23' );
define( 'PURELYST_DIR', get_template_directory() );
define( 'PURELYST_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function purelyst_setup() {
    // Make theme available for translation
    load_theme_textdomain( 'purelyst', PURELYST_DIR . '/languages' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );
    
    // Set custom image sizes
    add_image_size( 'purelyst-hero', 1200, 675, true );
    add_image_size( 'purelyst-card', 600, 450, true );
    add_image_size( 'purelyst-thumbnail', 150, 150, true );

    // Register navigation menus
    register_nav_menus( array(
        'primary'        => esc_html__( 'Primary Menu', 'purelyst' ),
        'footer-explore' => esc_html__( 'Footer Explore', 'purelyst' ),
        'footer-company' => esc_html__( 'Footer Company', 'purelyst' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 64,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Add support for Block Editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'f9fafb',
    ) );

    // Add support for wide alignment
    add_theme_support( 'align-wide' );

    // Add support for editor color palette
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => esc_html__( 'Primary', 'purelyst' ),
            'slug'  => 'primary',
            'color' => '#2b403e',
        ),
        array(
            'name'  => esc_html__( 'Accent', 'purelyst' ),
            'slug'  => 'accent',
            'color' => '#B5A795',
        ),
        array(
            'name'  => esc_html__( 'Background Light', 'purelyst' ),
            'slug'  => 'background-light',
            'color' => '#f9fafb',
        ),
        array(
            'name'  => esc_html__( 'Background Dark', 'purelyst' ),
            'slug'  => 'background-dark',
            'color' => '#1a1e23',
        ),
    ) );
}
add_action( 'after_setup_theme', 'purelyst_setup' );

/**
 * Set content width
 */
function purelyst_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'purelyst_content_width', 1280 );
}
add_action( 'after_setup_theme', 'purelyst_content_width', 0 );

/**
 * Output critical CSS inline for faster FCP/LCP
 * This CSS is required for above-the-fold content rendering
 */
function purelyst_critical_css() {
    ?>
    <style id="purelyst-critical-css">
    /* Critical CSS - Above the fold styles */
    :root{--color-primary:#2b403e;--color-accent:#B5A795;--color-background-light:#f9fafb;--color-surface-light:#fff;--color-text-primary:#131616;--color-text-secondary:#6a7c7a;--color-border-light:#ecefee;--font-family:'Manrope',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;--spacing-md:1rem;--spacing-lg:1.5rem;--spacing-xl:2rem;--radius-md:0.5rem;--radius-lg:0.75rem;--radius-full:9999px;--shadow-soft:0 4px 20px rgba(0,0,0,.05);--max-width:1280px;--header-height:72px}
    *,*::before,*::after{box-sizing:border-box}
    html{-webkit-text-size-adjust:100%}
    body{margin:0;padding:0;font-family:var(--font-family);font-size:16px;line-height:1.5;color:var(--color-text-primary);background-color:var(--color-background-light);-webkit-font-smoothing:antialiased}
    a{color:inherit;text-decoration:none}
    img{max-width:100%;height:auto;display:block}
    .site-header{position:sticky;top:0;z-index:50;width:100%;border-bottom:1px solid var(--color-border-light);background-color:rgba(249,250,251,.95);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px)}
    .header-inner{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;max-width:var(--max-width);margin:0 auto}
    .site-logo{display:flex;align-items:center;gap:.75rem}
    .custom-logo-link{display:flex;align-items:center}
    .custom-logo-link img,.custom-logo{max-height:40px!important;width:auto!important;height:auto!important;max-width:180px!important;object-fit:contain}
    .logo-text{font-size:1.25rem;font-weight:800;color:var(--color-primary);letter-spacing:-.025em}
    .main-navigation{display:none}
    @media(min-width:768px){.main-navigation{display:flex;align-items:center}.custom-logo-link img,.custom-logo{max-height:48px!important;max-width:200px!important}}
    .nav-list{display:flex;align-items:center;gap:2rem;list-style:none;margin:0;padding:0}
    .nav-list li{list-style:none;margin:0;padding:0}
    .nav-link{font-size:.875rem;font-weight:600;color:var(--color-text-secondary)}
    .header-actions{display:flex;align-items:center;gap:1rem}
    .btn-subscribe{display:none;padding:.625rem 1.25rem;border-radius:var(--radius-full);background-color:var(--color-primary);color:#fff;font-size:.875rem;font-weight:600}
    @media(min-width:768px){.btn-subscribe{display:inline-flex}}
    .mobile-menu-toggle{display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border:none;background:0 0;color:var(--color-text-primary);cursor:pointer}
    @media(min-width:768px){.mobile-menu-toggle{display:none}}
    .hero-section{position:relative;width:100%;padding:4rem 1.5rem 5rem;background-color:var(--color-background-light);overflow:hidden}
    .hero-inner{max-width:var(--max-width);margin:0 auto}
    .hero-content{display:grid;grid-template-columns:1fr;gap:3rem;align-items:center}
    @media(min-width:1024px){.hero-content{grid-template-columns:1fr 1fr;gap:4rem}}
    .hero-text{display:flex;flex-direction:column;gap:1.5rem;order:2}
    @media(min-width:1024px){.hero-text{order:1;padding-right:2rem}}
    .featured-badge{display:inline-flex;align-items:center;gap:.5rem;padding:.375rem 1rem;border-radius:var(--radius-full);background-color:rgba(181,167,149,.15);color:var(--color-accent);font-size:.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;width:fit-content}
    .hero-title{font-size:2.5rem;font-weight:800;color:var(--color-text-primary);line-height:1.1;letter-spacing:-.03em;margin:0}
    .hero-title a{color:inherit}
    @media(min-width:768px){.hero-title{font-size:3.5rem}}
    @media(min-width:1024px){.hero-title{font-size:4rem}}
    .hero-excerpt{font-size:1.125rem;color:var(--color-text-secondary);line-height:1.8;max-width:32rem;margin:0}
    @media(min-width:768px){.hero-excerpt{font-size:1.25rem}}
    .hero-image{order:1}
    @media(min-width:1024px){.hero-image{order:2}}
    .hero-image-wrapper{position:relative;border-radius:var(--radius-lg);overflow:hidden;aspect-ratio:4/3}
    .hero-image-inner{position:absolute;inset:0;background-size:cover;background-position:center;background-repeat:no-repeat}
    .btn-primary{display:inline-flex;align-items:center;gap:.5rem;padding:1rem 1.75rem;border:none;border-radius:var(--radius-lg);background-color:var(--color-primary);color:#fff;font-size:.9375rem;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(43,64,62,.25)}
    .search-toggle{display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border:none;border-radius:var(--radius-full);background:0 0;color:var(--color-text-primary);cursor:pointer;position:relative}
    .search-toggle .close-icon{display:none}
    /* Font fallback to prevent FOIT */
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif}
    .fonts-loaded body{font-family:var(--font-family)}
    </style>
    <?php
}

/**
 * Mark fonts as loaded for CSS font-display optimization
 */
function purelyst_font_loading_script() {
    ?>
    <script>
    if("fonts"in document){document.fonts.ready.then(function(){document.documentElement.classList.add("fonts-loaded")})}else{document.documentElement.classList.add("fonts-loaded")}
    </script>
    <?php
}
add_action( 'wp_head', 'purelyst_font_loading_script', 3 );

/**
 * Enqueue scripts and styles
 */
function purelyst_scripts() {
    // Enqueue Google Fonts with display=swap for better CLS
    wp_enqueue_style(
        'purelyst-fonts',
        'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Enqueue Material Symbols with display=swap
    // Enqueue Material Symbols icon font
    // Note: Not deferred as icons are visible above-the-fold
    wp_enqueue_style(
        'purelyst-icons',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap',
        array(),
        null
    );

    // Enqueue main stylesheet
    wp_enqueue_style(
        'purelyst-style',
        get_stylesheet_uri(),
        array( 'purelyst-fonts' ),
        PURELYST_VERSION
    );

    // Enqueue custom JavaScript
    wp_enqueue_script(
        'purelyst-scripts',
        PURELYST_URI . '/assets/js/main.js',
        array(),
        PURELYST_VERSION,
        array(
            'strategy'  => 'defer',
            'in_footer' => true,
        )
    );

    // Enqueue comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'purelyst_scripts' );

/**
 * Style loader tag modifications
 * Note: Icon font loads normally (not async) as icons are above-the-fold
 */
function purelyst_async_styles( $tag, $handle, $src ) {
    // Currently no async stylesheet loading
    // Icon font loads normally to ensure immediate rendering
    return $tag;
}
add_filter( 'style_loader_tag', 'purelyst_async_styles', 10, 3 );

/**
 * Critical preloads are now in header.php directly for earliest possible loading
 * This function is kept for backwards compatibility but preconnects moved to header.php
 */
function purelyst_critical_preloads() {
    // Preconnects and preloads are now hardcoded in header.php
    // for maximum priority (before any wp_head output)
}
add_action( 'wp_head', 'purelyst_critical_preloads', 1 );

/**
 * Preload LCP image on front page
 */
function purelyst_preload_lcp_image() {
    if ( ! is_front_page() ) {
        return;
    }
    
    // Get hero post
    $hero_post_id = get_theme_mod( 'purelyst_hero_post', '' );
    
    if ( ! $hero_post_id ) {
        $sticky = get_option( 'sticky_posts' );
        if ( ! empty( $sticky ) ) {
            $hero_post_id = $sticky[0];
        } else {
            $recent = get_posts( array( 'posts_per_page' => 1, 'fields' => 'ids' ) );
            $hero_post_id = ! empty( $recent ) ? $recent[0] : 0;
        }
    }
    
    if ( $hero_post_id && has_post_thumbnail( $hero_post_id ) ) {
        $image_id = get_post_thumbnail_id( $hero_post_id );
        $image_src = wp_get_attachment_image_src( $image_id, 'purelyst-hero' );
        
        if ( $image_src ) {
            printf(
                '<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n",
                esc_url( $image_src[0] )
            );
        }
    }
}
add_action( 'wp_head', 'purelyst_preload_lcp_image', 2 );

/**
 * Add resource hints for performance (backup/additional hints via WP filter)
 */
function purelyst_resource_hints( $hints, $relation_type ) {
    // Preconnects are now hardcoded in header.php for maximum priority
    // This function provides backup hints via WordPress filter
    return $hints;
}
add_filter( 'wp_resource_hints', 'purelyst_resource_hints', 10, 2 );

/**
 * Defer non-critical JavaScript (jQuery)
 */
function purelyst_defer_scripts( $tag, $handle, $src ) {
    // List of scripts to defer
    $defer_scripts = array( 'jquery-core', 'jquery-migrate' );
    
    if ( in_array( $handle, $defer_scripts, true ) ) {
        // Don't defer in admin
        if ( is_admin() ) {
            return $tag;
        }
        // Add defer attribute
        return str_replace( ' src=', ' defer src=', $tag );
    }
    
    return $tag;
}
add_filter( 'script_loader_tag', 'purelyst_defer_scripts', 10, 3 );

/**
 * Remove WordPress block library CSS on front-end
 * This saves ~14KB of unused CSS
 */
function purelyst_dequeue_block_styles() {
    // Only dequeue on front-end, not in admin or block editor
    if ( is_admin() ) {
        return;
    }
    
    // Always dequeue on front page (it doesn't use blocks)
    if ( is_front_page() || is_home() ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'wc-blocks-style' );
        wp_dequeue_style( 'global-styles' );
        return;
    }
    
    // For other pages, check if post uses blocks
    $post = get_post();
    if ( $post && ! has_blocks( $post->post_content ) ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'wc-blocks-style' );
        wp_dequeue_style( 'global-styles' );
    }
}
add_action( 'wp_enqueue_scripts', 'purelyst_dequeue_block_styles', 100 );

/**
 * Preload LCP placeholder image on front page when no featured image
 */
function purelyst_preload_placeholder_lcp() {
    if ( ! is_front_page() ) {
        return;
    }
    
    // Get hero post
    $hero_post_id = get_theme_mod( 'purelyst_hero_post', '' );
    
    if ( ! $hero_post_id ) {
        $sticky = get_option( 'sticky_posts' );
        if ( ! empty( $sticky ) ) {
            $hero_post_id = $sticky[0];
        } else {
            $recent = get_posts( array( 'posts_per_page' => 1, 'fields' => 'ids' ) );
            $hero_post_id = ! empty( $recent ) ? $recent[0] : 0;
        }
    }
    
    // If no featured image, preload the placeholder
    if ( ! $hero_post_id || ! has_post_thumbnail( $hero_post_id ) ) {
        echo '<link rel="preload" as="image" href="' . esc_url( get_template_directory_uri() . '/assets/images/placeholder.svg' ) . '" fetchpriority="high">' . "\n";
    }
}
add_action( 'wp_head', 'purelyst_preload_placeholder_lcp', 2 );

/**
 * Register widget areas
 */
function purelyst_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'purelyst' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'purelyst' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area', 'purelyst' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'purelyst' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-nav-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'purelyst_widgets_init' );

/**
 * Custom template tags
 */
require PURELYST_DIR . '/inc/template-tags.php';

/**
 * Customizer additions
 */
require PURELYST_DIR . '/inc/customizer.php';

/**
 * Custom Walker for navigation menu
 */
class Purelyst_Nav_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        
        if ( $item->current ) {
            $classes[] = 'current';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';
        $atts['class']  = $item->current ? 'nav-link current' : 'nav-link';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 * Custom Walker for footer navigation menu
 */
class Purelyst_Footer_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= '<ul class="footer-nav-list">';
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= '</ul>';
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $output .= '<li>';

        $atts = array();
        $atts['href']  = ! empty( $item->url ) ? $item->url : '';
        $atts['class'] = 'footer-nav-link';

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output = '<a' . $attributes . '>' . $title . '</a>';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

/**
 * Add excerpt support for pages
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Modify excerpt length
 */
function purelyst_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'purelyst_excerpt_length' );

/**
 * Modify excerpt more string
 */
function purelyst_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'purelyst_excerpt_more' );

/**
 * Get reading time for posts
 */
function purelyst_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 );
    
    if ( $reading_time < 1 ) {
        $reading_time = 1;
    }
    
    return sprintf(
        /* translators: %d: reading time in minutes */
        _n( '%d min read', '%d min read', $reading_time, 'purelyst' ),
        $reading_time
    );
}

/**
 * Add image dimensions to prevent CLS
 */
function purelyst_add_image_dimensions( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    if ( empty( $html ) ) {
        return $html;
    }

    $image_data = wp_get_attachment_image_src( $post_thumbnail_id, $size );
    
    if ( $image_data ) {
        $width = $image_data[1];
        $height = $image_data[2];
        
        if ( strpos( $html, 'width=' ) === false ) {
            $html = str_replace( '<img', '<img width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '"', $html );
        }
    }

    return $html;
}
add_filter( 'post_thumbnail_html', 'purelyst_add_image_dimensions', 10, 5 );

/**
 * Add loading="lazy" to images by default (except above the fold)
 */
function purelyst_add_lazy_loading( $attr, $attachment, $size ) {
    if ( ! is_admin() && ! isset( $attr['loading'] ) ) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'purelyst_add_lazy_loading', 10, 3 );

/**
 * Add fetchpriority="high" to hero images
 */
function purelyst_hero_image_priority( $attr, $attachment, $size ) {
    if ( is_front_page() && in_the_loop() && 0 === get_query_var( 'paged', 0 ) ) {
        if ( 'purelyst-hero' === $size || 'full' === $size ) {
            $attr['fetchpriority'] = 'high';
            $attr['loading'] = 'eager';
        }
    }
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'purelyst_hero_image_priority', 11, 3 );

/**
 * Defer non-critical CSS
 */
function purelyst_defer_styles( $html, $handle, $href, $media ) {
    $defer_handles = array( 'purelyst-icons' );
    
    if ( in_array( $handle, $defer_handles, true ) ) {
        $html = str_replace( "rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html );
        $html .= "<noscript><link rel='stylesheet' href='{$href}' media='{$media}' /></noscript>";
    }
    
    return $html;
}
add_filter( 'style_loader_tag', 'purelyst_defer_styles', 10, 4 );

/**
 * Remove unnecessary WordPress default scripts/styles for performance
 */
function purelyst_remove_unnecessary_assets() {
    // Remove emoji scripts
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'purelyst_remove_unnecessary_assets' );

/**
 * Add theme support for dark mode
 */
function purelyst_dark_mode_body_class( $classes ) {
    if ( isset( $_COOKIE['purelyst_dark_mode'] ) && $_COOKIE['purelyst_dark_mode'] === 'true' ) {
        $classes[] = 'dark';
    }
    return $classes;
}
add_filter( 'body_class', 'purelyst_dark_mode_body_class' );

/**
 * AJAX handler for loading more posts
 */
function purelyst_load_more_posts() {
    check_ajax_referer( 'purelyst_load_more', 'nonce' );

    $page = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
    $posts_per_page = get_option( 'posts_per_page' );

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $page,
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        ob_start();
        
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/content', 'card' );
        }
        
        $html = ob_get_clean();
        
        wp_send_json_success( array(
            'html'     => $html,
            'has_more' => $page < $query->max_num_pages,
        ) );
    } else {
        wp_send_json_error( array(
            'message' => esc_html__( 'No more posts to load.', 'purelyst' ),
        ) );
    }

    wp_die();
}
add_action( 'wp_ajax_purelyst_load_more', 'purelyst_load_more_posts' );
add_action( 'wp_ajax_nopriv_purelyst_load_more', 'purelyst_load_more_posts' );

/**
 * Localize script with AJAX URL and nonce
 */
function purelyst_localize_scripts() {
    wp_localize_script( 'purelyst-scripts', 'purelystData', array(
        'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
        'nonce'        => wp_create_nonce( 'purelyst_load_more' ),
        'loadMoreText' => esc_html( get_theme_mod( 'purelyst_load_more_text', __( 'Load More Stories', 'purelyst' ) ) ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'purelyst_localize_scripts' );

/**
 * Load Admin Settings
 */
if ( is_admin() ) {
    require_once PURELYST_DIR . '/inc/admin-settings.php';
}

/**
 * Enqueue custom CSS generated from theme settings
 */
function purelyst_custom_styles() {
    $upload_dir = wp_upload_dir();
    $css_file = $upload_dir['basedir'] . '/purelyst/custom-styles.css';
    
    if ( file_exists( $css_file ) ) {
        wp_enqueue_style(
            'purelyst-custom-styles',
            $upload_dir['baseurl'] . '/purelyst/custom-styles.css',
            array( 'purelyst-style' ),
            filemtime( $css_file )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'purelyst_custom_styles', 20 );

/**
 * Apply theme settings to frontend
 */
function purelyst_apply_settings() {
    // Get settings
    $settings = get_option( 'purelyst_settings', array() );
    
    // Default values
    $defaults = array(
        'show_reading_progress' => true,
        'enable_dark_mode'      => true,
    );
    
    $settings = wp_parse_args( $settings, $defaults );
    
    // Add body classes based on settings
    add_filter( 'body_class', function( $classes ) use ( $settings ) {
        if ( ! empty( $settings['site_layout'] ) && $settings['site_layout'] === 'boxed' ) {
            $classes[] = 'layout-boxed';
        }
        
        if ( empty( $settings['enable_dark_mode'] ) ) {
            $classes[] = 'no-dark-mode';
        }
        
        return $classes;
    } );
}
add_action( 'wp', 'purelyst_apply_settings' );
