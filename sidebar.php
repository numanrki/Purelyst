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
    <div class="sidebar-widget author-widget">
        <?php if ( $author_image ) : ?>
            <img src="<?php echo esc_url( $author_image ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="author-avatar" width="96" height="96" loading="lazy">
        <?php endif; ?>
        
        <h3 class="author-name"><?php echo esc_html( $author_name ); ?></h3>
        <span class="author-title"><?php echo esc_html( $author_title ); ?></span>
        
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

    <!-- Popular Topics Widget -->
    <?php
    $topics_title = get_theme_mod( 'purelyst_topics_title', __( 'Popular Topics', 'purelyst' ) );
    $tags = get_tags( array(
        'orderby' => 'count',
        'order'   => 'DESC',
        'number'  => 5,
    ) );

    if ( ! empty( $tags ) ) :
    ?>
    <div class="sidebar-widget topics-widget">
        <h3 class="widget-title"><?php echo esc_html( $topics_title ); ?></h3>
        <div class="topics-list">
            <?php foreach ( $tags as $tag ) : ?>
                <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="topic-link">
                    <?php echo esc_html( $tag->name ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Newsletter Widget -->
    <?php
    $newsletter_title = get_theme_mod( 'purelyst_newsletter_title', __( 'Weekly Inspiration', 'purelyst' ) );
    $newsletter_description = get_theme_mod( 'purelyst_newsletter_description', __( 'Join 15,000+ readers receiving our best design tips.', 'purelyst' ) );
    $newsletter_form_action = get_theme_mod( 'purelyst_newsletter_form_action', '' );
    $newsletter_button_text = get_theme_mod( 'purelyst_newsletter_button_text', __( 'Subscribe', 'purelyst' ) );
    $newsletter_disclaimer = get_theme_mod( 'purelyst_newsletter_disclaimer', __( 'No spam, unsubscribe anytime.', 'purelyst' ) );
    ?>
    <div class="sidebar-widget newsletter-widget-single" id="newsletter-widget">
        <div class="newsletter-icon-wrapper">
            <span class="material-symbols-outlined">mail</span>
        </div>
        <h3 class="newsletter-title-centered"><?php echo esc_html( $newsletter_title ); ?></h3>
        <p class="newsletter-description-centered"><?php echo esc_html( $newsletter_description ); ?></p>
        
        <form class="newsletter-form-single" action="<?php echo esc_url( $newsletter_form_action ? $newsletter_form_action : '#' ); ?>" method="post">
            <label for="newsletter-email" class="screen-reader-text"><?php esc_html_e( 'Email address', 'purelyst' ); ?></label>
            <input 
                type="email" 
                id="newsletter-email" 
                name="email" 
                class="newsletter-input-single" 
                placeholder="<?php esc_attr_e( 'Your email address', 'purelyst' ); ?>" 
                required
            >
            <button type="submit" class="newsletter-submit-single">
                <?php echo esc_html( $newsletter_button_text ); ?>
            </button>
        </form>
        
        <?php if ( $newsletter_disclaimer ) : ?>
            <p class="newsletter-disclaimer"><?php echo esc_html( $newsletter_disclaimer ); ?></p>
        <?php endif; ?>
    </div>

</aside>
