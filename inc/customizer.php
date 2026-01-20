<?php
/**
 * Purelyst Theme Customizer
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add customizer settings
 */
function purelyst_customize_register( $wp_customize ) {

    // ==========================================================================
    // Purelyst Theme Panel
    // ==========================================================================
    $wp_customize->add_panel( 'purelyst_panel', array(
        'title'       => __( 'Purelyst Theme', 'purelyst' ),
        'description' => __( 'Customize all Purelyst theme settings.', 'purelyst' ),
        'priority'    => 30,
    ) );

    // ==========================================================================
    // Read More Button Section
    // ==========================================================================
    $wp_customize->add_section( 'purelyst_read_more_section', array(
        'title'       => __( 'Read More Button', 'purelyst' ),
        'description' => __( 'Customize the Read More button on archive pages.', 'purelyst' ),
        'panel'       => 'purelyst_panel',
        'priority'    => 10,
    ) );

    // Enable Read More Button
    $wp_customize->add_setting( 'purelyst_read_more_enable', array(
        'default'           => true,
        'sanitize_callback' => 'purelyst_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'purelyst_read_more_enable', array(
        'label'       => __( 'Enable Read More Button', 'purelyst' ),
        'description' => __( 'Show Read More button on archive card items.', 'purelyst' ),
        'section'     => 'purelyst_read_more_section',
        'type'        => 'checkbox',
    ) );

    // Read More Button Text
    $wp_customize->add_setting( 'purelyst_read_more_text', array(
        'default'           => __( 'Read More', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_read_more_text', array(
        'label'   => __( 'Button Text', 'purelyst' ),
        'section' => 'purelyst_read_more_section',
        'type'    => 'text',
    ) );

    // Read More Button Background Color
    $wp_customize->add_setting( 'purelyst_read_more_bg_color', array(
        'default'           => '#2b403e',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'purelyst_read_more_bg_color', array(
        'label'   => __( 'Button Background Color', 'purelyst' ),
        'section' => 'purelyst_read_more_section',
    ) ) );

    // Read More Button Text Color
    $wp_customize->add_setting( 'purelyst_read_more_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'purelyst_read_more_text_color', array(
        'label'   => __( 'Button Text Color', 'purelyst' ),
        'section' => 'purelyst_read_more_section',
    ) ) );

    // Read More Button Hover Background Color
    $wp_customize->add_setting( 'purelyst_read_more_hover_bg_color', array(
        'default'           => '#1a2a29',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'purelyst_read_more_hover_bg_color', array(
        'label'   => __( 'Button Hover Background Color', 'purelyst' ),
        'section' => 'purelyst_read_more_section',
    ) ) );

    // ==========================================================================
    // Hero Section
    // ==========================================================================
    $wp_customize->add_section( 'purelyst_hero_section', array(
        'title'       => __( 'Hero Section', 'purelyst' ),
        'description' => __( 'Customize the homepage hero section.', 'purelyst' ),
        'panel'       => 'purelyst_panel',
        'priority'    => 20,
    ) );

    // Featured Post
    $wp_customize->add_setting( 'purelyst_hero_post', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'purelyst_hero_post', array(
        'label'       => __( 'Featured Post ID', 'purelyst' ),
        'description' => __( 'Enter the post ID to feature in the hero section. Leave empty to use the latest post.', 'purelyst' ),
        'section'     => 'purelyst_hero_section',
        'type'        => 'number',
    ) );

    // Hero Badge Text
    $wp_customize->add_setting( 'purelyst_hero_badge', array(
        'default'           => __( 'Featured Story', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_hero_badge', array(
        'label'   => __( 'Badge Text', 'purelyst' ),
        'section' => 'purelyst_hero_section',
        'type'    => 'text',
    ) );

    // Hero Button Text
    $wp_customize->add_setting( 'purelyst_hero_button_text', array(
        'default'           => __( 'Read Article', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_hero_button_text', array(
        'label'   => __( 'Button Text', 'purelyst' ),
        'section' => 'purelyst_hero_section',
        'type'    => 'text',
    ) );

    // ==========================================================================
    // Sidebar Section
    // ==========================================================================
    $wp_customize->add_section( 'purelyst_sidebar_section', array(
        'title'       => __( 'Sidebar Settings', 'purelyst' ),
        'description' => __( 'Customize the sidebar widgets.', 'purelyst' ),
        'panel'       => 'purelyst_panel',
        'priority'    => 30,
    ) );

    // Author Widget
    $wp_customize->add_setting( 'purelyst_author_name', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_author_name', array(
        'label'       => __( 'Author Name', 'purelyst' ),
        'description' => __( 'Display name for the sidebar author widget.', 'purelyst' ),
        'section'     => 'purelyst_sidebar_section',
        'type'        => 'text',
    ) );

    $wp_customize->add_setting( 'purelyst_author_title', array(
        'default'           => __( 'Editor in Chief', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_author_title', array(
        'label'   => __( 'Author Title', 'purelyst' ),
        'section' => 'purelyst_sidebar_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'purelyst_author_bio', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'purelyst_author_bio', array(
        'label'   => __( 'Author Bio', 'purelyst' ),
        'section' => 'purelyst_sidebar_section',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'purelyst_author_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'purelyst_author_image', array(
        'label'   => __( 'Author Image', 'purelyst' ),
        'section' => 'purelyst_sidebar_section',
    ) ) );

    $wp_customize->add_setting( 'purelyst_author_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'purelyst_author_link', array(
        'label'       => __( 'Author Page URL', 'purelyst' ),
        'description' => __( 'Link to the author\'s about page.', 'purelyst' ),
        'section'     => 'purelyst_sidebar_section',
        'type'        => 'url',
    ) );

    // ==========================================================================
    // Newsletter Section
    // ==========================================================================
    $wp_customize->add_section( 'purelyst_newsletter_section', array(
        'title'       => __( 'Newsletter Widget', 'purelyst' ),
        'description' => __( 'Customize the newsletter signup widget.', 'purelyst' ),
        'panel'       => 'purelyst_panel',
        'priority'    => 40,
    ) );

    $wp_customize->add_setting( 'purelyst_newsletter_title', array(
        'default'           => __( 'Join the Newsletter', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_newsletter_title', array(
        'label'   => __( 'Newsletter Title', 'purelyst' ),
        'section' => 'purelyst_newsletter_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'purelyst_newsletter_description', array(
        'default'           => __( 'Get the latest stories on slow living delivered to your inbox every Sunday.', 'purelyst' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'purelyst_newsletter_description', array(
        'label'   => __( 'Newsletter Description', 'purelyst' ),
        'section' => 'purelyst_newsletter_section',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'purelyst_newsletter_form_action', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'purelyst_newsletter_form_action', array(
        'label'       => __( 'Form Action URL', 'purelyst' ),
        'description' => __( 'Enter your email service form action URL (e.g., Mailchimp, ConvertKit).', 'purelyst' ),
        'section'     => 'purelyst_newsletter_section',
        'type'        => 'url',
    ) );

    $wp_customize->add_setting( 'purelyst_newsletter_button_text', array(
        'default'           => __( 'Subscribe', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_newsletter_button_text', array(
        'label'   => __( 'Button Text', 'purelyst' ),
        'section' => 'purelyst_newsletter_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'purelyst_newsletter_disclaimer', array(
        'default'           => __( 'No spam, unsubscribe anytime.', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_newsletter_disclaimer', array(
        'label'   => __( 'Disclaimer Text', 'purelyst' ),
        'section' => 'purelyst_newsletter_section',
        'type'    => 'text',
    ) );

    // ==========================================================================
    // Footer Section
    // ==========================================================================
    $wp_customize->add_section( 'purelyst_footer_section', array(
        'title'       => __( 'Footer Settings', 'purelyst' ),
        'description' => __( 'Customize the footer area.', 'purelyst' ),
        'panel'       => 'purelyst_panel',
        'priority'    => 50,
    ) );

    $wp_customize->add_setting( 'purelyst_footer_tagline', array(
        'default'           => __( 'A digital publication dedicated to clarity, design, and intentional living in a chaotic world.', 'purelyst' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'purelyst_footer_tagline', array(
        'label'   => __( 'Footer Tagline', 'purelyst' ),
        'section' => 'purelyst_footer_section',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'purelyst_copyright_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_copyright_text', array(
        'label'       => __( 'Copyright Text', 'purelyst' ),
        'description' => __( 'Custom copyright text. Leave empty to use default.', 'purelyst' ),
        'section'     => 'purelyst_footer_section',
        'type'        => 'text',
    ) );

    // ==========================================================================
    // Social Links Section
    // ==========================================================================
    $wp_customize->add_section( 'purelyst_social_section', array(
        'title'       => __( 'Social Links', 'purelyst' ),
        'description' => __( 'Add your social media links.', 'purelyst' ),
        'panel'       => 'purelyst_panel',
        'priority'    => 60,
    ) );

    $wp_customize->add_setting( 'purelyst_social_website', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'purelyst_social_website', array(
        'label'   => __( 'Website URL', 'purelyst' ),
        'section' => 'purelyst_social_section',
        'type'    => 'url',
    ) );

    $wp_customize->add_setting( 'purelyst_social_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ) );

    $wp_customize->add_control( 'purelyst_social_email', array(
        'label'   => __( 'Email Address', 'purelyst' ),
        'section' => 'purelyst_social_section',
        'type'    => 'email',
    ) );

    // ==========================================================================
    // Colors Section Enhancement
    // ==========================================================================
    $wp_customize->add_setting( 'purelyst_primary_color', array(
        'default'           => '#2b403e',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'purelyst_primary_color', array(
        'label'   => __( 'Primary Color', 'purelyst' ),
        'section' => 'colors',
    ) ) );

    $wp_customize->add_setting( 'purelyst_accent_color', array(
        'default'           => '#B5A795',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'purelyst_accent_color', array(
        'label'   => __( 'Accent Color', 'purelyst' ),
        'section' => 'colors',
    ) ) );

    // ==========================================================================
    // Header Section
    // ==========================================================================
    $wp_customize->add_section( 'purelyst_header_section', array(
        'title'       => __( 'Header Settings', 'purelyst' ),
        'description' => __( 'Customize the header area.', 'purelyst' ),
        'panel'       => 'purelyst_panel',
        'priority'    => 15,
    ) );

    $wp_customize->add_setting( 'purelyst_header_subscribe_text', array(
        'default'           => __( 'Subscribe', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_header_subscribe_text', array(
        'label'   => __( 'Subscribe Button Text', 'purelyst' ),
        'section' => 'purelyst_header_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'purelyst_header_subscribe_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'purelyst_header_subscribe_url', array(
        'label'       => __( 'Subscribe Button URL', 'purelyst' ),
        'description' => __( 'Leave empty to scroll to newsletter widget.', 'purelyst' ),
        'section'     => 'purelyst_header_section',
        'type'        => 'url',
    ) );

    $wp_customize->add_setting( 'purelyst_show_search', array(
        'default'           => true,
        'sanitize_callback' => 'purelyst_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'purelyst_show_search', array(
        'label'   => __( 'Show Search Button', 'purelyst' ),
        'section' => 'purelyst_header_section',
        'type'    => 'checkbox',
    ) );

    // ==========================================================================
    // Posts Section
    // ==========================================================================
    $wp_customize->add_section( 'purelyst_posts_section', array(
        'title'       => __( 'Posts Settings', 'purelyst' ),
        'description' => __( 'Customize how posts are displayed.', 'purelyst' ),
        'panel'       => 'purelyst_panel',
        'priority'    => 25,
    ) );

    $wp_customize->add_setting( 'purelyst_recent_posts_title', array(
        'default'           => __( 'Recent Stories', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_recent_posts_title', array(
        'label'   => __( 'Recent Posts Section Title', 'purelyst' ),
        'section' => 'purelyst_posts_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'purelyst_load_more_text', array(
        'default'           => __( 'Load More Stories', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_load_more_text', array(
        'label'   => __( 'Load More Button Text', 'purelyst' ),
        'section' => 'purelyst_posts_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'purelyst_topics_title', array(
        'default'           => __( 'Popular Topics', 'purelyst' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'purelyst_topics_title', array(
        'label'   => __( 'Popular Topics Title', 'purelyst' ),
        'section' => 'purelyst_posts_section',
        'type'    => 'text',
    ) );
}
add_action( 'customize_register', 'purelyst_customize_register' );

/**
 * Sanitize checkbox
 */
function purelyst_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Output customizer CSS
 */
function purelyst_customizer_css() {
    $primary_color = get_theme_mod( 'purelyst_primary_color', '#2b403e' );
    $accent_color = get_theme_mod( 'purelyst_accent_color', '#B5A795' );
    $read_more_bg = get_theme_mod( 'purelyst_read_more_bg_color', '#2b403e' );
    $read_more_text = get_theme_mod( 'purelyst_read_more_text_color', '#ffffff' );
    $read_more_hover_bg = get_theme_mod( 'purelyst_read_more_hover_bg_color', '#1a2a29' );

    $css = '';

    // Root variables
    if ( '#2b403e' !== $primary_color || '#B5A795' !== $accent_color ) {
        $css .= ':root {';
        if ( '#2b403e' !== $primary_color ) {
            $css .= '--color-primary: ' . esc_attr( $primary_color ) . ';';
        }
        if ( '#B5A795' !== $accent_color ) {
            $css .= '--color-accent: ' . esc_attr( $accent_color ) . ';';
        }
        $css .= '}';
    }

    // Read More button colors
    if ( '#2b403e' !== $read_more_bg || '#ffffff' !== $read_more_text || '#1a2a29' !== $read_more_hover_bg ) {
        $css .= '.read-more-btn { background-color: ' . esc_attr( $read_more_bg ) . '; color: ' . esc_attr( $read_more_text ) . '; }';
        $css .= '.read-more-btn:hover { background-color: ' . esc_attr( $read_more_hover_bg ) . '; }';
    }

    if ( ! empty( $css ) ) {
        wp_add_inline_style( 'purelyst-style', $css );
    }
}
add_action( 'wp_enqueue_scripts', 'purelyst_customizer_css', 20 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously
 */
function purelyst_customize_preview_js() {
    wp_enqueue_script(
        'purelyst-customizer',
        PURELYST_URI . '/assets/js/customizer.js',
        array( 'customize-preview' ),
        PURELYST_VERSION,
        true
    );
}
add_action( 'customize_preview_init', 'purelyst_customize_preview_js' );
