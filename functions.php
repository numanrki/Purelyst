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
define( 'PURELYST_VERSION', '1.0.7' );
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
 * Enqueue scripts and styles
 */
function purelyst_scripts() {
    // Preconnect to Google Fonts
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    
    // Enqueue Google Fonts with display=swap for better CLS
    wp_enqueue_style(
        'purelyst-fonts',
        'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Enqueue Material Symbols
    wp_enqueue_style(
        'purelyst-icons',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@400,0&display=swap',
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
 * Add preload for critical fonts
 */
function purelyst_preload_fonts() {
    ?>
    <link rel="preload" href="https://fonts.gstatic.com/s/manrope/v15/xn7gYHE41ni1AdIRggexSg.woff2" as="font" type="font/woff2" crossorigin>
    <?php
}
add_action( 'wp_head', 'purelyst_preload_fonts', 1 );

/**
 * Add resource hints for performance
 */
function purelyst_resource_hints( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        $hints[] = '//fonts.googleapis.com';
        $hints[] = '//fonts.gstatic.com';
    }

    if ( 'preconnect' === $relation_type ) {
        $hints[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $hints;
}
add_filter( 'wp_resource_hints', 'purelyst_resource_hints', 10, 2 );

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
