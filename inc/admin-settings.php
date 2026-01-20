<?php
/**
 * Purelyst Theme Admin Settings
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Purelyst Admin Settings Class
 */
class Purelyst_Admin_Settings {

    /**
     * Settings option name
     */
    const OPTION_NAME = 'purelyst_settings';

    /**
     * Default settings
     */
    private $defaults = array(
        // General
        'site_layout'           => 'wide',
        'container_width'       => 1200,
        'sidebar_position'      => 'right',
        'show_reading_progress' => true,
        'show_scroll_top'       => true,
        
        // Typography
        'font_family'           => 'Manrope',
        'heading_weight'        => '700',
        'heading_letter_spacing'=> '-0.02em',
        'heading_line_height'   => '1.2',
        'body_font_size'        => 16,
        'fluid_typography'      => false,
        
        // Colors
        'primary_color'         => '#2b403e',
        'accent_color'          => '#B5A795',
        'background_color'      => '#f9fafb',
        'text_color'            => '#2b403e',
        'enable_dark_mode'      => true,
        
        // Read More Button
        'read_more_enable'      => true,
        'read_more_text'        => 'Read More',
        'read_more_bg_color'    => '#2b403e',
        'read_more_text_color'  => '#ffffff',
        'read_more_hover_color' => '#1a2a29',
        
        // Footer
        'footer_copyright'      => '© {year} Purelyst Theme. All rights reserved.',
        'footer_tagline'        => 'Crafted with intention.',
        'show_footer_social'    => true,
        'footer_columns'        => 4,
    );

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'wp_ajax_purelyst_save_settings', array( $this, 'ajax_save_settings' ) );
        add_action( 'wp_ajax_purelyst_reset_settings', array( $this, 'ajax_reset_settings' ) );
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __( 'Purelyst Theme', 'purelyst' ),
            __( 'Purelyst', 'purelyst' ),
            'manage_options',
            'purelyst-settings',
            array( $this, 'render_settings_page' ),
            'dashicons-art',
            59
        );

        add_submenu_page(
            'purelyst-settings',
            __( 'Theme Settings', 'purelyst' ),
            __( 'Theme Settings', 'purelyst' ),
            'manage_options',
            'purelyst-settings',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets( $hook ) {
        if ( 'toplevel_page_purelyst-settings' !== $hook ) {
            return;
        }

        // Google Fonts
        wp_enqueue_style(
            'purelyst-admin-fonts',
            'https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap',
            array(),
            null
        );

        // Material Icons
        wp_enqueue_style(
            'purelyst-material-icons',
            'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
            array(),
            null
        );

        // Admin CSS
        wp_enqueue_style(
            'purelyst-admin-style',
            get_template_directory_uri() . '/assets/css/admin-style.css',
            array(),
            PURELYST_VERSION
        );

        // WordPress color picker
        wp_enqueue_style( 'wp-color-picker' );

        // WordPress media uploader
        wp_enqueue_media();

        // Admin JS
        wp_enqueue_script(
            'purelyst-admin-script',
            get_template_directory_uri() . '/assets/js/admin.js',
            array( 'jquery', 'wp-color-picker', 'media-upload' ),
            PURELYST_VERSION,
            true
        );

        wp_localize_script( 'purelyst-admin-script', 'purelystAdmin', array(
            'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
            'nonce'         => wp_create_nonce( 'purelyst_admin_nonce' ),
            'saving'        => __( 'Saving...', 'purelyst' ),
            'saved'         => __( 'Settings Saved!', 'purelyst' ),
            'resetting'     => __( 'Resetting...', 'purelyst' ),
            'resetConfirm'  => __( 'Are you sure you want to reset all settings to defaults?', 'purelyst' ),
            'error'         => __( 'An error occurred. Please try again.', 'purelyst' ),
        ) );
    }

    /**
     * Get settings
     */
    public function get_settings() {
        $saved = get_option( self::OPTION_NAME, array() );
        return wp_parse_args( $saved, $this->defaults );
    }

    /**
     * Save settings via AJAX
     */
    public function ajax_save_settings() {
        check_ajax_referer( 'purelyst_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'purelyst' ) ) );
        }

        $settings = array();
        
        // Sanitize and save each setting
        if ( isset( $_POST['settings'] ) && is_array( $_POST['settings'] ) ) {
            foreach ( $_POST['settings'] as $key => $value ) {
                // Handle site logo separately
                if ( $key === 'site_logo' ) {
                    $logo_id = absint( $value );
                    if ( $logo_id ) {
                        set_theme_mod( 'custom_logo', $logo_id );
                    } else {
                        remove_theme_mod( 'custom_logo' );
                    }
                    continue;
                }
                
                // Handle site favicon separately
                if ( $key === 'site_favicon' ) {
                    $favicon_id = absint( $value );
                    update_option( 'site_icon', $favicon_id );
                    continue;
                }
                
                $settings[ sanitize_key( $key ) ] = $this->sanitize_setting( $key, $value );
            }
        }

        update_option( self::OPTION_NAME, $settings );

        // Generate custom CSS
        $this->generate_custom_css( $settings );

        wp_send_json_success( array( 'message' => __( 'Settings saved successfully!', 'purelyst' ) ) );
    }

    /**
     * Reset settings via AJAX
     */
    public function ajax_reset_settings() {
        check_ajax_referer( 'purelyst_admin_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'purelyst' ) ) );
        }

        delete_option( self::OPTION_NAME );
        
        // Regenerate CSS with defaults
        $this->generate_custom_css( $this->defaults );

        wp_send_json_success( array( 
            'message'  => __( 'Settings reset to defaults!', 'purelyst' ),
            'settings' => $this->defaults 
        ) );
    }

    /**
     * Sanitize individual setting
     */
    private function sanitize_setting( $key, $value ) {
        switch ( $key ) {
            case 'primary_color':
            case 'accent_color':
            case 'background_color':
            case 'text_color':
            case 'read_more_bg_color':
            case 'read_more_text_color':
            case 'read_more_hover_color':
                return sanitize_hex_color( $value );

            case 'container_width':
            case 'body_font_size':
            case 'footer_columns':
                return absint( $value );

            case 'heading_line_height':
                return floatval( $value );

            case 'show_reading_progress':
            case 'show_scroll_top':
            case 'fluid_typography':
            case 'enable_dark_mode':
            case 'show_footer_social':
            case 'read_more_enable':
                return (bool) $value;

            case 'footer_copyright':
            case 'footer_tagline':
                return wp_kses_post( $value );

            case 'read_more_text':
                return sanitize_text_field( $value );

            default:
                return sanitize_text_field( $value );
        }
    }

    /**
     * Generate custom CSS based on settings
     */
    private function generate_custom_css( $settings ) {
        $css = ':root {' . "\n";
        
        if ( ! empty( $settings['primary_color'] ) ) {
            $css .= '    --color-primary: ' . $settings['primary_color'] . ';' . "\n";
        }
        
        if ( ! empty( $settings['accent_color'] ) ) {
            $css .= '    --color-accent: ' . $settings['accent_color'] . ';' . "\n";
        }
        
        if ( ! empty( $settings['background_color'] ) ) {
            $css .= '    --color-background-light: ' . $settings['background_color'] . ';' . "\n";
        }
        
        if ( ! empty( $settings['body_font_size'] ) ) {
            $css .= '    --font-size-base: ' . $settings['body_font_size'] . 'px;' . "\n";
        }
        
        $css .= '}' . "\n";

        // Read More Button Styles
        if ( ! empty( $settings['read_more_bg_color'] ) || ! empty( $settings['read_more_text_color'] ) ) {
            $css .= '.read-more-btn {' . "\n";
            if ( ! empty( $settings['read_more_bg_color'] ) ) {
                $css .= '    background-color: ' . $settings['read_more_bg_color'] . ';' . "\n";
            }
            if ( ! empty( $settings['read_more_text_color'] ) ) {
                $css .= '    color: ' . $settings['read_more_text_color'] . ';' . "\n";
            }
            $css .= '}' . "\n";
        }

        if ( ! empty( $settings['read_more_hover_color'] ) ) {
            $css .= '.read-more-btn:hover {' . "\n";
            $css .= '    background-color: ' . $settings['read_more_hover_color'] . ';' . "\n";
            $css .= '}' . "\n";
        }

        // Save to file
        $upload_dir = wp_upload_dir();
        $css_dir = $upload_dir['basedir'] . '/purelyst/';
        
        if ( ! file_exists( $css_dir ) ) {
            wp_mkdir_p( $css_dir );
        }
        
        file_put_contents( $css_dir . 'custom-styles.css', $css );
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        $settings = $this->get_settings();
        $current_user = wp_get_current_user();
        ?>
        <div class="purelyst-admin-wrap">
            <!-- WP Top Admin Bar -->
            <header class="purelyst-admin-header">
                <div class="purelyst-breadcrumb">
                    <span class="purelyst-brand"><?php esc_html_e( 'Purelyst Theme', 'purelyst' ); ?></span>
                    <span class="material-symbols-outlined">chevron_right</span>
                    <span><?php esc_html_e( 'Theme Settings', 'purelyst' ); ?></span>
                </div>
                <div class="purelyst-user-info">
                    <span class="purelyst-user-greeting"><?php printf( esc_html__( 'Howdy, %s', 'purelyst' ), esc_html( $current_user->display_name ) ); ?></span>
                    <?php echo get_avatar( $current_user->ID, 32, '', '', array( 'class' => 'purelyst-user-avatar' ) ); ?>
                </div>
            </header>

            <!-- Main Content -->
            <main class="purelyst-admin-main">
                <div class="purelyst-admin-container">
                    <!-- Page Header -->
                    <div class="purelyst-page-header">
                        <div class="purelyst-page-title-wrap">
                            <h1 class="purelyst-page-title"><?php esc_html_e( 'Theme Settings', 'purelyst' ); ?></h1>
                            <p class="purelyst-page-desc"><?php esc_html_e( 'Customize the look and feel of your Purelyst theme.', 'purelyst' ); ?></p>
                        </div>
                        <div class="purelyst-page-actions">
                            <button type="button" class="purelyst-btn purelyst-btn-secondary" id="purelyst-reset-btn">
                                <span class="material-symbols-outlined">history</span>
                                <?php esc_html_e( 'Reset Defaults', 'purelyst' ); ?>
                            </button>
                            <button type="button" class="purelyst-btn purelyst-btn-primary" id="purelyst-save-btn">
                                <span class="material-symbols-outlined">save</span>
                                <?php esc_html_e( 'Save Changes', 'purelyst' ); ?>
                            </button>
                        </div>
                    </div>

                    <!-- Tabs & Content -->
                    <div class="purelyst-settings-card">
                        <!-- Tabs Navigation -->
                        <div class="purelyst-tabs-nav">
                            <button class="purelyst-tab active" data-tab="general">
                                <?php esc_html_e( 'General', 'purelyst' ); ?>
                            </button>
                            <button class="purelyst-tab" data-tab="customize">
                                <?php esc_html_e( 'Customize', 'purelyst' ); ?>
                            </button>
                            <button class="purelyst-tab" data-tab="typography">
                                <?php esc_html_e( 'Typography', 'purelyst' ); ?>
                            </button>
                            <button class="purelyst-tab" data-tab="colors">
                                <?php esc_html_e( 'Colors', 'purelyst' ); ?>
                            </button>
                            <button class="purelyst-tab" data-tab="footer">
                                <?php esc_html_e( 'Footer', 'purelyst' ); ?>
                            </button>
                        </div>

                        <!-- Tab Content Panels -->
                        <div class="purelyst-tabs-content">
                            <form id="purelyst-settings-form">
                                
                                <!-- General Tab -->
                                <div class="purelyst-tab-panel active" data-panel="general">
                                    <div class="purelyst-settings-layout">
                                        <div class="purelyst-settings-controls">
                                            <h2 class="purelyst-section-title">
                                                <span class="material-symbols-outlined">tune</span>
                                                <?php esc_html_e( 'General Settings', 'purelyst' ); ?>
                                            </h2>

                                            <div class="purelyst-settings-group">
                                                <!-- Site Identity Section -->
                                                <div class="purelyst-config-box">
                                                    <h3 class="purelyst-config-title"><?php esc_html_e( 'SITE IDENTITY', 'purelyst' ); ?></h3>
                                                    
                                                    <!-- Site Logo -->
                                                    <div class="purelyst-field">
                                                        <label class="purelyst-label"><?php esc_html_e( 'Site Logo', 'purelyst' ); ?></label>
                                                        <div class="purelyst-media-upload">
                                                            <?php 
                                                            $site_logo = get_theme_mod( 'custom_logo' );
                                                            $logo_url = $site_logo ? wp_get_attachment_image_url( $site_logo, 'medium' ) : '';
                                                            ?>
                                                            <div class="purelyst-media-preview <?php echo $logo_url ? 'has-image' : ''; ?>" id="logo-preview">
                                                                <?php if ( $logo_url ) : ?>
                                                                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="">
                                                                <?php else : ?>
                                                                    <span class="material-symbols-outlined">add_photo_alternate</span>
                                                                    <span class="purelyst-media-text"><?php esc_html_e( 'Upload Logo', 'purelyst' ); ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <input type="hidden" name="site_logo" id="site_logo" value="<?php echo esc_attr( $site_logo ); ?>">
                                                            <div class="purelyst-media-actions">
                                                                <button type="button" class="purelyst-btn purelyst-btn-sm purelyst-btn-secondary" id="upload-logo-btn">
                                                                    <span class="material-symbols-outlined">upload</span>
                                                                    <?php esc_html_e( 'Upload', 'purelyst' ); ?>
                                                                </button>
                                                                <button type="button" class="purelyst-btn purelyst-btn-sm purelyst-btn-outline" id="remove-logo-btn" <?php echo ! $logo_url ? 'style="display:none;"' : ''; ?>>
                                                                    <span class="material-symbols-outlined">delete</span>
                                                                    <?php esc_html_e( 'Remove', 'purelyst' ); ?>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <p class="purelyst-field-desc"><?php esc_html_e( 'Recommended size: 200x64 pixels. PNG or SVG format.', 'purelyst' ); ?></p>
                                                    </div>

                                                    <!-- Site Favicon -->
                                                    <div class="purelyst-field">
                                                        <label class="purelyst-label"><?php esc_html_e( 'Site Favicon', 'purelyst' ); ?></label>
                                                        <div class="purelyst-media-upload">
                                                            <?php 
                                                            $site_icon = get_option( 'site_icon' );
                                                            $favicon_url = $site_icon ? wp_get_attachment_image_url( $site_icon, 'thumbnail' ) : '';
                                                            ?>
                                                            <div class="purelyst-media-preview purelyst-media-preview-sm <?php echo $favicon_url ? 'has-image' : ''; ?>" id="favicon-preview">
                                                                <?php if ( $favicon_url ) : ?>
                                                                    <img src="<?php echo esc_url( $favicon_url ); ?>" alt="">
                                                                <?php else : ?>
                                                                    <span class="material-symbols-outlined">add_photo_alternate</span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <input type="hidden" name="site_favicon" id="site_favicon" value="<?php echo esc_attr( $site_icon ); ?>">
                                                            <div class="purelyst-media-actions">
                                                                <button type="button" class="purelyst-btn purelyst-btn-sm purelyst-btn-secondary" id="upload-favicon-btn">
                                                                    <span class="material-symbols-outlined">upload</span>
                                                                    <?php esc_html_e( 'Upload', 'purelyst' ); ?>
                                                                </button>
                                                                <button type="button" class="purelyst-btn purelyst-btn-sm purelyst-btn-outline" id="remove-favicon-btn" <?php echo ! $favicon_url ? 'style="display:none;"' : ''; ?>>
                                                                    <span class="material-symbols-outlined">delete</span>
                                                                    <?php esc_html_e( 'Remove', 'purelyst' ); ?>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <p class="purelyst-field-desc"><?php esc_html_e( 'Recommended size: 512x512 pixels. PNG format.', 'purelyst' ); ?></p>
                                                    </div>
                                                </div>

                                                <div class="purelyst-divider"></div>

                                                <!-- Site Layout -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Site Layout', 'purelyst' ); ?></label>
                                                    <div class="purelyst-select-wrap">
                                                        <select name="site_layout" class="purelyst-select">
                                                            <option value="wide" <?php selected( $settings['site_layout'], 'wide' ); ?>><?php esc_html_e( 'Wide', 'purelyst' ); ?></option>
                                                            <option value="boxed" <?php selected( $settings['site_layout'], 'boxed' ); ?>><?php esc_html_e( 'Boxed', 'purelyst' ); ?></option>
                                                        </select>
                                                        <span class="material-symbols-outlined">expand_more</span>
                                                    </div>
                                                    <p class="purelyst-field-desc"><?php esc_html_e( 'Choose between wide or boxed layout for your site.', 'purelyst' ); ?></p>
                                                </div>

                                                <!-- Container Width -->
                                                <div class="purelyst-field">
                                                    <div class="purelyst-range-header">
                                                        <label class="purelyst-label"><?php esc_html_e( 'Container Width', 'purelyst' ); ?></label>
                                                        <span class="purelyst-range-value"><?php echo esc_html( $settings['container_width'] ); ?>px</span>
                                                    </div>
                                                    <input type="range" name="container_width" class="purelyst-range" min="960" max="1600" step="20" value="<?php echo esc_attr( $settings['container_width'] ); ?>">
                                                    <div class="purelyst-range-labels">
                                                        <span><?php esc_html_e( 'Narrow (960px)', 'purelyst' ); ?></span>
                                                        <span><?php esc_html_e( 'Wide (1600px)', 'purelyst' ); ?></span>
                                                    </div>
                                                </div>

                                                <!-- Sidebar Position -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Sidebar Position', 'purelyst' ); ?></label>
                                                    <div class="purelyst-select-wrap">
                                                        <select name="sidebar_position" class="purelyst-select">
                                                            <option value="right" <?php selected( $settings['sidebar_position'], 'right' ); ?>><?php esc_html_e( 'Right', 'purelyst' ); ?></option>
                                                            <option value="left" <?php selected( $settings['sidebar_position'], 'left' ); ?>><?php esc_html_e( 'Left', 'purelyst' ); ?></option>
                                                            <option value="none" <?php selected( $settings['sidebar_position'], 'none' ); ?>><?php esc_html_e( 'No Sidebar', 'purelyst' ); ?></option>
                                                        </select>
                                                        <span class="material-symbols-outlined">expand_more</span>
                                                    </div>
                                                </div>

                                                <div class="purelyst-divider"></div>

                                                <!-- Toggle Switches -->
                                                <div class="purelyst-toggle-field">
                                                    <div class="purelyst-toggle-info">
                                                        <h4 class="purelyst-toggle-title"><?php esc_html_e( 'Reading Progress Bar', 'purelyst' ); ?></h4>
                                                        <p class="purelyst-toggle-desc"><?php esc_html_e( 'Show a progress bar at the top of single posts.', 'purelyst' ); ?></p>
                                                    </div>
                                                    <label class="purelyst-toggle">
                                                        <input type="checkbox" name="show_reading_progress" value="1" <?php checked( $settings['show_reading_progress'], true ); ?>>
                                                        <span class="purelyst-toggle-slider"></span>
                                                    </label>
                                                </div>

                                                <div class="purelyst-toggle-field">
                                                    <div class="purelyst-toggle-info">
                                                        <h4 class="purelyst-toggle-title"><?php esc_html_e( 'Scroll to Top Button', 'purelyst' ); ?></h4>
                                                        <p class="purelyst-toggle-desc"><?php esc_html_e( 'Display a button to scroll back to top.', 'purelyst' ); ?></p>
                                                    </div>
                                                    <label class="purelyst-toggle">
                                                        <input type="checkbox" name="show_scroll_top" value="1" <?php checked( $settings['show_scroll_top'], true ); ?>>
                                                        <span class="purelyst-toggle-slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview Panel -->
                                        <div class="purelyst-preview-panel">
                                            <?php $this->render_preview_panel(); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Customize Tab -->
                                <div class="purelyst-tab-panel" data-panel="customize">
                                    <div class="purelyst-settings-layout">
                                        <div class="purelyst-settings-controls">
                                            <h2 class="purelyst-section-title">
                                                <span class="material-symbols-outlined">brush</span>
                                                <?php esc_html_e( 'Customize Elements', 'purelyst' ); ?>
                                            </h2>

                                            <div class="purelyst-settings-group">
                                                <!-- Read More Button Section -->
                                                <div class="purelyst-config-box">
                                                    <h3 class="purelyst-config-title"><?php esc_html_e( 'READ MORE BUTTON', 'purelyst' ); ?></h3>
                                                    
                                                    <!-- Enable Read More Button -->
                                                    <div class="purelyst-toggle-field">
                                                        <div class="purelyst-toggle-info">
                                                            <h4 class="purelyst-toggle-title"><?php esc_html_e( 'Enable Read More Button', 'purelyst' ); ?></h4>
                                                            <p class="purelyst-toggle-desc"><?php esc_html_e( 'Show "Read More" button on archive page cards.', 'purelyst' ); ?></p>
                                                        </div>
                                                        <label class="purelyst-toggle">
                                                            <input type="checkbox" name="read_more_enable" value="1" <?php checked( $settings['read_more_enable'], true ); ?>>
                                                            <span class="purelyst-toggle-slider"></span>
                                                        </label>
                                                    </div>

                                                    <div class="purelyst-divider"></div>

                                                    <!-- Button Text -->
                                                    <div class="purelyst-field">
                                                        <label class="purelyst-label"><?php esc_html_e( 'Button Text', 'purelyst' ); ?></label>
                                                        <input type="text" name="read_more_text" class="purelyst-input" value="<?php echo esc_attr( $settings['read_more_text'] ); ?>">
                                                        <p class="purelyst-field-desc"><?php esc_html_e( 'Text displayed on the button.', 'purelyst' ); ?></p>
                                                    </div>

                                                    <!-- Button Background Color -->
                                                    <div class="purelyst-field">
                                                        <label class="purelyst-label"><?php esc_html_e( 'Button Background Color', 'purelyst' ); ?></label>
                                                        <div class="purelyst-color-field">
                                                            <input type="text" name="read_more_bg_color" class="purelyst-color-picker" value="<?php echo esc_attr( $settings['read_more_bg_color'] ); ?>" data-default-color="#2b403e">
                                                        </div>
                                                    </div>

                                                    <!-- Button Text Color -->
                                                    <div class="purelyst-field">
                                                        <label class="purelyst-label"><?php esc_html_e( 'Button Text Color', 'purelyst' ); ?></label>
                                                        <div class="purelyst-color-field">
                                                            <input type="text" name="read_more_text_color" class="purelyst-color-picker" value="<?php echo esc_attr( $settings['read_more_text_color'] ); ?>" data-default-color="#ffffff">
                                                        </div>
                                                    </div>

                                                    <!-- Button Hover Color -->
                                                    <div class="purelyst-field">
                                                        <label class="purelyst-label"><?php esc_html_e( 'Button Hover Background Color', 'purelyst' ); ?></label>
                                                        <div class="purelyst-color-field">
                                                            <input type="text" name="read_more_hover_color" class="purelyst-color-picker" value="<?php echo esc_attr( $settings['read_more_hover_color'] ); ?>" data-default-color="#1a2a29">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview Panel -->
                                        <div class="purelyst-preview-panel">
                                            <?php $this->render_preview_panel(); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Typography Tab -->
                                <div class="purelyst-tab-panel" data-panel="typography">
                                    <div class="purelyst-settings-layout">
                                        <div class="purelyst-settings-controls">
                                            <h2 class="purelyst-section-title">
                                                <span class="material-symbols-outlined">text_fields</span>
                                                <?php esc_html_e( 'Global Typography', 'purelyst' ); ?>
                                            </h2>

                                            <div class="purelyst-settings-group">
                                                <!-- Font Family -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Primary Font Family', 'purelyst' ); ?></label>
                                                    <div class="purelyst-select-wrap">
                                                        <select name="font_family" class="purelyst-select">
                                                            <option value="Manrope" <?php selected( $settings['font_family'], 'Manrope' ); ?>><?php esc_html_e( 'Manrope (Theme Default)', 'purelyst' ); ?></option>
                                                            <option value="Inter" <?php selected( $settings['font_family'], 'Inter' ); ?>>Inter</option>
                                                            <option value="Roboto" <?php selected( $settings['font_family'], 'Roboto' ); ?>>Roboto</option>
                                                            <option value="Merriweather" <?php selected( $settings['font_family'], 'Merriweather' ); ?>>Merriweather</option>
                                                            <option value="Playfair Display" <?php selected( $settings['font_family'], 'Playfair Display' ); ?>>Playfair Display</option>
                                                        </select>
                                                        <span class="material-symbols-outlined">expand_more</span>
                                                    </div>
                                                    <p class="purelyst-field-desc"><?php esc_html_e( 'Used for headings and body text throughout the site.', 'purelyst' ); ?></p>
                                                </div>

                                                <!-- Headings Configuration Box -->
                                                <div class="purelyst-config-box">
                                                    <h3 class="purelyst-config-title"><?php esc_html_e( 'HEADINGS CONFIGURATION', 'purelyst' ); ?></h3>
                                                    
                                                    <div class="purelyst-config-grid">
                                                        <div class="purelyst-field">
                                                            <label class="purelyst-label-sm"><?php esc_html_e( 'Base Weight', 'purelyst' ); ?></label>
                                                            <div class="purelyst-select-wrap purelyst-select-sm">
                                                                <select name="heading_weight" class="purelyst-select">
                                                                    <option value="400" <?php selected( $settings['heading_weight'], '400' ); ?>><?php esc_html_e( 'Regular (400)', 'purelyst' ); ?></option>
                                                                    <option value="500" <?php selected( $settings['heading_weight'], '500' ); ?>><?php esc_html_e( 'Medium (500)', 'purelyst' ); ?></option>
                                                                    <option value="700" <?php selected( $settings['heading_weight'], '700' ); ?>><?php esc_html_e( 'Bold (700)', 'purelyst' ); ?></option>
                                                                    <option value="800" <?php selected( $settings['heading_weight'], '800' ); ?>><?php esc_html_e( 'Extra Bold (800)', 'purelyst' ); ?></option>
                                                                </select>
                                                                <span class="material-symbols-outlined">expand_more</span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="purelyst-field">
                                                            <label class="purelyst-label-sm"><?php esc_html_e( 'Letter Spacing', 'purelyst' ); ?></label>
                                                            <div class="purelyst-select-wrap purelyst-select-sm">
                                                                <select name="heading_letter_spacing" class="purelyst-select">
                                                                    <option value="-0.02em" <?php selected( $settings['heading_letter_spacing'], '-0.02em' ); ?>><?php esc_html_e( 'Tight (-0.02em)', 'purelyst' ); ?></option>
                                                                    <option value="0" <?php selected( $settings['heading_letter_spacing'], '0' ); ?>><?php esc_html_e( 'Normal (0)', 'purelyst' ); ?></option>
                                                                    <option value="0.05em" <?php selected( $settings['heading_letter_spacing'], '0.05em' ); ?>><?php esc_html_e( 'Wide (0.05em)', 'purelyst' ); ?></option>
                                                                </select>
                                                                <span class="material-symbols-outlined">expand_more</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Line Height Slider -->
                                                    <div class="purelyst-field">
                                                        <div class="purelyst-range-header">
                                                            <label class="purelyst-label-sm"><?php esc_html_e( 'Heading Line Height', 'purelyst' ); ?></label>
                                                            <span class="purelyst-range-badge"><?php echo esc_html( $settings['heading_line_height'] ); ?></span>
                                                        </div>
                                                        <input type="range" name="heading_line_height" class="purelyst-range" min="1" max="2" step="0.1" value="<?php echo esc_attr( $settings['heading_line_height'] ); ?>">
                                                    </div>
                                                </div>

                                                <!-- Body Base Size -->
                                                <div class="purelyst-field">
                                                    <div class="purelyst-range-header">
                                                        <label class="purelyst-label"><?php esc_html_e( 'Body Base Size', 'purelyst' ); ?></label>
                                                        <span class="purelyst-range-value"><?php echo esc_html( $settings['body_font_size'] ); ?>px</span>
                                                    </div>
                                                    <input type="range" name="body_font_size" class="purelyst-range" min="14" max="24" step="1" value="<?php echo esc_attr( $settings['body_font_size'] ); ?>">
                                                    <div class="purelyst-range-labels">
                                                        <span><?php esc_html_e( 'Small (14px)', 'purelyst' ); ?></span>
                                                        <span><?php esc_html_e( 'Large (24px)', 'purelyst' ); ?></span>
                                                    </div>
                                                </div>

                                                <div class="purelyst-divider"></div>

                                                <!-- Fluid Typography Toggle -->
                                                <div class="purelyst-toggle-field">
                                                    <div class="purelyst-toggle-info">
                                                        <h4 class="purelyst-toggle-title"><?php esc_html_e( 'Fluid Typography', 'purelyst' ); ?></h4>
                                                        <p class="purelyst-toggle-desc"><?php esc_html_e( 'Scale text size smoothly based on viewport width.', 'purelyst' ); ?></p>
                                                    </div>
                                                    <label class="purelyst-toggle">
                                                        <input type="checkbox" name="fluid_typography" value="1" <?php checked( $settings['fluid_typography'], true ); ?>>
                                                        <span class="purelyst-toggle-slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview Panel -->
                                        <div class="purelyst-preview-panel">
                                            <?php $this->render_preview_panel(); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Colors Tab -->
                                <div class="purelyst-tab-panel" data-panel="colors">
                                    <div class="purelyst-settings-layout">
                                        <div class="purelyst-settings-controls">
                                            <h2 class="purelyst-section-title">
                                                <span class="material-symbols-outlined">palette</span>
                                                <?php esc_html_e( 'Color Settings', 'purelyst' ); ?>
                                            </h2>

                                            <div class="purelyst-settings-group">
                                                <!-- Primary Color -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Primary Color', 'purelyst' ); ?></label>
                                                    <div class="purelyst-color-field">
                                                        <input type="text" name="primary_color" class="purelyst-color-picker" value="<?php echo esc_attr( $settings['primary_color'] ); ?>">
                                                    </div>
                                                    <p class="purelyst-field-desc"><?php esc_html_e( 'Main brand color used for headings, links, and buttons.', 'purelyst' ); ?></p>
                                                </div>

                                                <!-- Accent Color -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Accent Color', 'purelyst' ); ?></label>
                                                    <div class="purelyst-color-field">
                                                        <input type="text" name="accent_color" class="purelyst-color-picker" value="<?php echo esc_attr( $settings['accent_color'] ); ?>">
                                                    </div>
                                                    <p class="purelyst-field-desc"><?php esc_html_e( 'Secondary color for highlights and decorative elements.', 'purelyst' ); ?></p>
                                                </div>

                                                <!-- Background Color -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Background Color', 'purelyst' ); ?></label>
                                                    <div class="purelyst-color-field">
                                                        <input type="text" name="background_color" class="purelyst-color-picker" value="<?php echo esc_attr( $settings['background_color'] ); ?>">
                                                    </div>
                                                    <p class="purelyst-field-desc"><?php esc_html_e( 'Main background color for the website.', 'purelyst' ); ?></p>
                                                </div>

                                                <!-- Text Color -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Text Color', 'purelyst' ); ?></label>
                                                    <div class="purelyst-color-field">
                                                        <input type="text" name="text_color" class="purelyst-color-picker" value="<?php echo esc_attr( $settings['text_color'] ); ?>">
                                                    </div>
                                                    <p class="purelyst-field-desc"><?php esc_html_e( 'Default text color for body content.', 'purelyst' ); ?></p>
                                                </div>

                                                <div class="purelyst-divider"></div>

                                                <!-- Dark Mode Toggle -->
                                                <div class="purelyst-toggle-field">
                                                    <div class="purelyst-toggle-info">
                                                        <h4 class="purelyst-toggle-title"><?php esc_html_e( 'Enable Dark Mode', 'purelyst' ); ?></h4>
                                                        <p class="purelyst-toggle-desc"><?php esc_html_e( 'Allow visitors to switch to dark mode.', 'purelyst' ); ?></p>
                                                    </div>
                                                    <label class="purelyst-toggle">
                                                        <input type="checkbox" name="enable_dark_mode" value="1" <?php checked( $settings['enable_dark_mode'], true ); ?>>
                                                        <span class="purelyst-toggle-slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview Panel -->
                                        <div class="purelyst-preview-panel">
                                            <?php $this->render_preview_panel(); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Tab -->
                                <div class="purelyst-tab-panel" data-panel="footer">
                                    <div class="purelyst-settings-layout">
                                        <div class="purelyst-settings-controls">
                                            <h2 class="purelyst-section-title">
                                                <span class="material-symbols-outlined">dock_to_bottom</span>
                                                <?php esc_html_e( 'Footer Settings', 'purelyst' ); ?>
                                            </h2>

                                            <div class="purelyst-settings-group">
                                                <!-- Copyright Text -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Copyright Text', 'purelyst' ); ?></label>
                                                    <input type="text" name="footer_copyright" class="purelyst-input" value="<?php echo esc_attr( $settings['footer_copyright'] ); ?>">
                                                    <p class="purelyst-field-desc"><?php esc_html_e( 'Use {year} to display the current year dynamically.', 'purelyst' ); ?></p>
                                                </div>

                                                <!-- Tagline -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Footer Tagline', 'purelyst' ); ?></label>
                                                    <input type="text" name="footer_tagline" class="purelyst-input" value="<?php echo esc_attr( $settings['footer_tagline'] ); ?>">
                                                    <p class="purelyst-field-desc"><?php esc_html_e( 'A short tagline displayed in the footer.', 'purelyst' ); ?></p>
                                                </div>

                                                <!-- Footer Columns -->
                                                <div class="purelyst-field">
                                                    <label class="purelyst-label"><?php esc_html_e( 'Footer Widget Columns', 'purelyst' ); ?></label>
                                                    <div class="purelyst-select-wrap">
                                                        <select name="footer_columns" class="purelyst-select">
                                                            <option value="2" <?php selected( $settings['footer_columns'], 2 ); ?>>2 <?php esc_html_e( 'Columns', 'purelyst' ); ?></option>
                                                            <option value="3" <?php selected( $settings['footer_columns'], 3 ); ?>>3 <?php esc_html_e( 'Columns', 'purelyst' ); ?></option>
                                                            <option value="4" <?php selected( $settings['footer_columns'], 4 ); ?>>4 <?php esc_html_e( 'Columns', 'purelyst' ); ?></option>
                                                        </select>
                                                        <span class="material-symbols-outlined">expand_more</span>
                                                    </div>
                                                </div>

                                                <div class="purelyst-divider"></div>

                                                <!-- Show Social Links Toggle -->
                                                <div class="purelyst-toggle-field">
                                                    <div class="purelyst-toggle-info">
                                                        <h4 class="purelyst-toggle-title"><?php esc_html_e( 'Show Social Links', 'purelyst' ); ?></h4>
                                                        <p class="purelyst-toggle-desc"><?php esc_html_e( 'Display social media icons in the footer.', 'purelyst' ); ?></p>
                                                    </div>
                                                    <label class="purelyst-toggle">
                                                        <input type="checkbox" name="show_footer_social" value="1" <?php checked( $settings['show_footer_social'], true ); ?>>
                                                        <span class="purelyst-toggle-slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Preview Panel -->
                                        <div class="purelyst-preview-panel">
                                            <?php $this->render_preview_panel(); ?>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="purelyst-admin-footer">
                        <p><?php printf( esc_html__( 'Purelyst Theme v%s', 'purelyst' ), PURELYST_VERSION ); ?></p>
                        <div class="purelyst-footer-links">
                            <a href="#"><?php esc_html_e( 'Documentation', 'purelyst' ); ?></a>
                            <a href="#"><?php esc_html_e( 'Support', 'purelyst' ); ?></a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php
    }

    /**
     * Render preview panel
     */
    private function render_preview_panel() {
        ?>
        <div class="purelyst-preview-decoration"></div>
        <div class="purelyst-preview-header">
            <span class="purelyst-preview-label"><?php esc_html_e( 'LIVE PREVIEW', 'purelyst' ); ?></span>
            <div class="purelyst-preview-devices">
                <button type="button" class="purelyst-device-btn active" data-device="desktop">
                    <span class="material-symbols-outlined">desktop_windows</span>
                </button>
                <button type="button" class="purelyst-device-btn" data-device="mobile">
                    <span class="material-symbols-outlined">smartphone</span>
                </button>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="purelyst-preview-card">
            <div class="purelyst-preview-image">
                <div class="purelyst-preview-badge"><?php esc_html_e( 'Minimalism', 'purelyst' ); ?></div>
            </div>
            <div class="purelyst-preview-content">
                <div class="purelyst-preview-meta">
                    <span>Oct 24, 2023</span>
                    <span>•</span>
                    <span>5 min read</span>
                </div>
                <h3 class="purelyst-preview-title"><?php esc_html_e( 'The Art of Quiet Luxury in Digital Design', 'purelyst' ); ?></h3>
                <p class="purelyst-preview-excerpt"><?php esc_html_e( 'Simplicity is the ultimate sophistication. Explore how negative space and refined typography can elevate your content strategy...', 'purelyst' ); ?></p>
                <div class="purelyst-preview-author">
                    <div class="purelyst-preview-author-avatar"></div>
                    <span class="purelyst-preview-author-name">Sarah Jenkins</span>
                </div>
            </div>
        </div>

        <div class="purelyst-preview-quote">
            <p>"<?php esc_html_e( 'Good design is obvious. Great design is transparent.', 'purelyst' ); ?>"</p>
        </div>
        <?php
    }
}

// Initialize
new Purelyst_Admin_Settings();

/**
 * Get Purelyst setting
 */
function purelyst_get_setting( $key, $default = '' ) {
    $settings = get_option( Purelyst_Admin_Settings::OPTION_NAME, array() );
    return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
}
