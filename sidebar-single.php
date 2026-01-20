<?php
/**
 * Sidebar template for single posts
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<aside class="single-sidebar" role="complementary">
    <div class="sidebar-sticky">
        
        <!-- Search Widget -->
        <div class="sidebar-widget search-widget">
            <form role="search" method="get" class="sidebar-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label for="sidebar-search" class="screen-reader-text"><?php esc_html_e( 'Search', 'purelyst' ); ?></label>
                <div class="search-input-wrapper">
                    <input 
                        type="search" 
                        id="sidebar-search" 
                        class="sidebar-search-input" 
                        placeholder="<?php esc_attr_e( 'Search articles...', 'purelyst' ); ?>" 
                        value="<?php echo get_search_query(); ?>" 
                        name="s"
                    >
                    <button type="submit" class="sidebar-search-btn" aria-label="<?php esc_attr_e( 'Search', 'purelyst' ); ?>">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Trending Posts Widget -->
        <?php
        $trending_posts = new WP_Query( array(
            'posts_per_page'      => 3,
            'post__not_in'        => array( get_the_ID() ),
            'orderby'             => 'comment_count',
            'order'               => 'DESC',
            'ignore_sticky_posts' => 1,
        ) );

        if ( $trending_posts->have_posts() ) :
        ?>
        <div class="sidebar-widget trending-widget">
            <div class="widget-header">
                <h3 class="widget-title"><?php esc_html_e( 'Trending', 'purelyst' ); ?></h3>
                <span class="material-symbols-outlined widget-icon">trending_up</span>
            </div>
            <div class="trending-list">
                <?php
                $counter = 1;
                while ( $trending_posts->have_posts() ) : $trending_posts->the_post();
                    $categories = get_the_category();
                    $category_name = ! empty( $categories ) ? $categories[0]->name : '';
                ?>
                    <a href="<?php the_permalink(); ?>" class="trending-item">
                        <span class="trending-number"><?php echo sprintf( '%02d', $counter ); ?></span>
                        <div class="trending-content">
                            <h4 class="trending-title"><?php the_title(); ?></h4>
                            <?php if ( $category_name ) : ?>
                                <span class="trending-category"><?php echo esc_html( $category_name ); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php
                $counter++;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Newsletter Widget -->
        <?php
        $newsletter_title = get_theme_mod( 'purelyst_newsletter_title', __( 'Weekly Inspiration', 'purelyst' ) );
        $newsletter_description = get_theme_mod( 'purelyst_newsletter_description', __( 'Join 15,000+ readers receiving our best design tips.', 'purelyst' ) );
        $newsletter_form_action = get_theme_mod( 'purelyst_newsletter_form_action', '' );
        $newsletter_button_text = get_theme_mod( 'purelyst_newsletter_button_text', __( 'Subscribe', 'purelyst' ) );
        ?>
        <div class="sidebar-widget newsletter-widget-single" id="newsletter-widget">
            <div class="newsletter-icon-wrapper">
                <span class="material-symbols-outlined">mail</span>
            </div>
            <h3 class="newsletter-title-centered"><?php echo esc_html( $newsletter_title ); ?></h3>
            <p class="newsletter-description-centered"><?php echo esc_html( $newsletter_description ); ?></p>
            
            <form class="newsletter-form-single" action="<?php echo esc_url( $newsletter_form_action ? $newsletter_form_action : '#' ); ?>" method="post">
                <label for="newsletter-email-single" class="screen-reader-text"><?php esc_html_e( 'Email address', 'purelyst' ); ?></label>
                <input 
                    type="email" 
                    id="newsletter-email-single" 
                    name="email" 
                    class="newsletter-input-single" 
                    placeholder="<?php esc_attr_e( 'Your email address', 'purelyst' ); ?>" 
                    required
                >
                <button type="submit" class="newsletter-submit-single">
                    <?php echo esc_html( $newsletter_button_text ); ?>
                </button>
            </form>
        </div>

    </div>
</aside>
