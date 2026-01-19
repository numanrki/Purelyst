<?php
/**
 * Sidebar template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<aside class="sidebar" role="complementary">
    
    <!-- Author Widget -->
    <?php
    $author_name = get_theme_mod( 'purelyst_author_name', '' );
    $author_title = get_theme_mod( 'purelyst_author_title', __( 'Editor in Chief', 'purelyst' ) );
    $author_bio = get_theme_mod( 'purelyst_author_bio', '' );
    $author_image = get_theme_mod( 'purelyst_author_image', '' );
    $author_link = get_theme_mod( 'purelyst_author_link', '' );

    // Get default author if not set
    if ( empty( $author_name ) ) {
        $admin = get_user_by( 'email', get_option( 'admin_email' ) );
        if ( $admin ) {
            $author_name = $admin->display_name;
            if ( empty( $author_bio ) ) {
                $author_bio = get_the_author_meta( 'description', $admin->ID );
            }
            if ( empty( $author_image ) ) {
                $author_image = get_avatar_url( $admin->ID, array( 'size' => 96 ) );
            }
        }
    }

    if ( $author_name ) :
    ?>
    <div class="widget-author">
        <div class="author-header">
            <?php if ( $author_image ) : ?>
                <div class="author-avatar" style="background-image: url('<?php echo esc_url( $author_image ); ?>');"></div>
            <?php endif; ?>
            <div class="author-info">
                <h4><?php echo esc_html( $author_name ); ?></h4>
                <p><?php echo esc_html( $author_title ); ?></p>
            </div>
        </div>
        
        <?php if ( $author_bio ) : ?>
            <p class="author-bio"><?php echo esc_html( $author_bio ); ?></p>
        <?php endif; ?>
        
        <?php if ( $author_link ) : ?>
            <a href="<?php echo esc_url( $author_link ); ?>" class="author-link">
                <?php esc_html_e( 'More about me', 'purelyst' ); ?>
                <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Newsletter Widget -->
    <?php
    $newsletter_title = get_theme_mod( 'purelyst_newsletter_title', __( 'Weekly Inspiration', 'purelyst' ) );
    $newsletter_description = get_theme_mod( 'purelyst_newsletter_description', __( 'Join 15,000+ readers receiving our best design tips.', 'purelyst' ) );
    $newsletter_form_action = get_theme_mod( 'purelyst_newsletter_form_action', '' );
    $newsletter_button_text = get_theme_mod( 'purelyst_newsletter_button_text', __( 'Subscribe', 'purelyst' ) );
    ?>
    <div class="widget-newsletter" id="newsletter-widget">
        <div class="newsletter-box">
            <span class="material-symbols-outlined newsletter-icon" aria-hidden="true">mail</span>
            <h3 class="newsletter-title"><?php echo esc_html( $newsletter_title ); ?></h3>
            <p class="newsletter-description"><?php echo esc_html( $newsletter_description ); ?></p>
            
            <form class="newsletter-form" action="<?php echo esc_url( $newsletter_form_action ? $newsletter_form_action : '#' ); ?>" method="post">
                <label for="newsletter-email-sidebar" class="screen-reader-text"><?php esc_html_e( 'Email address', 'purelyst' ); ?></label>
                <input 
                    type="email" 
                    id="newsletter-email-sidebar" 
                    name="email" 
                    class="newsletter-input" 
                    placeholder="<?php esc_attr_e( 'Your email address', 'purelyst' ); ?>" 
                    required
                >
                <button type="submit" class="newsletter-submit">
                    <?php echo esc_html( $newsletter_button_text ); ?>
                </button>
            </form>
        </div>
    </div>

</aside>
