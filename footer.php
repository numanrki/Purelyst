<?php
/**
 * The footer template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<footer class="site-footer" role="contentinfo">
    <div class="footer-inner">
        <div class="footer-widgets">
            <!-- Branding Column -->
            <div class="footer-branding">
                <div class="footer-logo">
                    <span class="material-symbols-outlined footer-logo-icon" aria-hidden="true">spa</span>
                    <span class="footer-logo-text"><?php bloginfo( 'name' ); ?></span>
                </div>
                <p class="footer-tagline">
                    <?php echo esc_html( get_theme_mod( 'purelyst_footer_tagline', __( 'A digital publication dedicated to clarity, design, and intentional living in a chaotic world.', 'purelyst' ) ) ); ?>
                </p>
            </div>

            <!-- Explore Column -->
            <div class="footer-nav-column">
                <h3 class="footer-nav-title"><?php esc_html_e( 'Explore', 'purelyst' ); ?></h3>
                <?php
                if ( has_nav_menu( 'footer-explore' ) ) {
                    purelyst_footer_navigation( 'footer-explore' );
                } else {
                    // Default category links
                    $categories = get_categories( array(
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'number'  => 4,
                    ) );

                    if ( ! empty( $categories ) ) {
                        echo '<ul class="footer-nav-list">';
                        foreach ( $categories as $category ) {
                            printf(
                                '<li><a href="%s" class="footer-nav-link">%s</a></li>',
                                esc_url( get_category_link( $category->term_id ) ),
                                esc_html( $category->name )
                            );
                        }
                        echo '</ul>';
                    }
                }
                ?>
            </div>

            <!-- Company Column -->
            <div class="footer-nav-column">
                <h3 class="footer-nav-title"><?php esc_html_e( 'Company', 'purelyst' ); ?></h3>
                <?php
                if ( has_nav_menu( 'footer-company' ) ) {
                    purelyst_footer_navigation( 'footer-company' );
                } else {
                    // Default page links
                    ?>
                    <ul class="footer-nav-list">
                        <?php
                        $pages = array(
                            'about'   => __( 'About Us', 'purelyst' ),
                            'contact' => __( 'Contact', 'purelyst' ),
                            'privacy-policy' => __( 'Privacy Policy', 'purelyst' ),
                        );

                        foreach ( $pages as $slug => $title ) {
                            $page = get_page_by_path( $slug );
                            if ( $page ) {
                                printf(
                                    '<li><a href="%s" class="footer-nav-link">%s</a></li>',
                                    esc_url( get_permalink( $page ) ),
                                    esc_html( $title )
                                );
                            }
                        }
                        ?>
                    </ul>
                    <?php
                }
                ?>
            </div>

            <!-- Connect Column -->
            <div class="footer-nav-column">
                <h3 class="footer-nav-title"><?php esc_html_e( 'Connect', 'purelyst' ); ?></h3>
                <?php purelyst_social_links(); ?>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p class="footer-copyright">
                <?php
                $copyright_text = get_theme_mod( 'purelyst_copyright_text', '' );
                
                if ( ! empty( $copyright_text ) ) {
                    echo esc_html( $copyright_text );
                } else {
                    printf(
                        /* translators: %1$s: Current year, %2$s: Site name */
                        esc_html__( '© %1$s %2$s. All rights reserved.', 'purelyst' ),
                        esc_html( date( 'Y' ) ),
                        esc_html( get_bloginfo( 'name' ) )
                    );
                }
                ?>
            </p>
            <div class="footer-legal">
                <?php
                $privacy_page = get_privacy_policy_url();
                if ( $privacy_page ) {
                    printf(
                        '<a href="%s" class="footer-legal-link">%s</a>',
                        esc_url( $privacy_page ),
                        esc_html__( 'Privacy', 'purelyst' )
                    );
                }
                ?>
                <a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>" class="footer-legal-link"><?php esc_html_e( 'Terms', 'purelyst' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/sitemap/' ) ); ?>" class="footer-legal-link"><?php esc_html_e( 'Sitemap', 'purelyst' ); ?></a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
