<?php
/**
 * Custom template tags for Purelyst theme
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display post categories
 */
function purelyst_post_categories() {
    $categories = get_the_category();
    
    if ( ! empty( $categories ) ) {
        $category = $categories[0];
        printf(
            '<a href="%s" class="article-category">%s</a>',
            esc_url( get_category_link( $category->term_id ) ),
            esc_html( $category->name )
        );
    }
}

/**
 * Display post meta (date and reading time)
 */
function purelyst_post_meta() {
    $date = get_the_date( 'M d, Y' );
    $reading_time = purelyst_reading_time();
    
    printf(
        '<div class="article-meta">
            <span>%s</span>
            <span class="meta-separator">•</span>
            <span>%s</span>
        </div>',
        esc_html( $date ),
        esc_html( $reading_time )
    );
}

/**
 * Display featured image with proper attributes for CLS prevention
 */
function purelyst_featured_image( $size = 'purelyst-card', $class = '' ) {
    if ( ! has_post_thumbnail() ) {
        return;
    }

    $thumbnail_id = get_post_thumbnail_id();
    $image_data = wp_get_attachment_image_src( $thumbnail_id, $size );
    
    if ( ! $image_data ) {
        return;
    }

    $alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
    if ( empty( $alt_text ) ) {
        $alt_text = get_the_title();
    }

    printf(
        '<img src="%s" alt="%s" width="%d" height="%d" class="%s" loading="lazy" decoding="async">',
        esc_url( $image_data[0] ),
        esc_attr( $alt_text ),
        esc_attr( $image_data[1] ),
        esc_attr( $image_data[2] ),
        esc_attr( $class )
    );
}

/**
 * Display hero featured image (eager loading for LCP)
 */
function purelyst_hero_featured_image() {
    if ( ! has_post_thumbnail() ) {
        return;
    }

    $thumbnail_id = get_post_thumbnail_id();
    $image_data = wp_get_attachment_image_src( $thumbnail_id, 'purelyst-hero' );
    
    if ( ! $image_data ) {
        return;
    }

    $alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
    if ( empty( $alt_text ) ) {
        $alt_text = get_the_title();
    }

    printf(
        '<img src="%s" alt="%s" width="%d" height="%d" class="hero-image-inner" loading="eager" fetchpriority="high" decoding="async">',
        esc_url( $image_data[0] ),
        esc_attr( $alt_text ),
        esc_attr( $image_data[1] ),
        esc_attr( $image_data[2] )
    );
}

/**
 * Display author avatar
 */
function purelyst_author_avatar( $size = 64, $class = '' ) {
    $author_id = get_the_author_meta( 'ID' );
    
    printf(
        '<img src="%s" alt="%s" width="%d" height="%d" class="%s" loading="lazy">',
        esc_url( get_avatar_url( $author_id, array( 'size' => $size ) ) ),
        esc_attr( get_the_author() ),
        esc_attr( $size ),
        esc_attr( $size ),
        esc_attr( $class )
    );
}

/**
 * Display site logo or text
 */
function purelyst_site_logo() {
    if ( has_custom_logo() ) {
        the_custom_logo();
    } else {
        ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" rel="home">
            <span class="material-symbols-outlined logo-icon" aria-hidden="true">spa</span>
            <span class="logo-text"><?php bloginfo( 'name' ); ?></span>
        </a>
        <?php
    }
}

/**
 * Display primary navigation
 */
function purelyst_primary_navigation() {
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => 'nav-list',
            'container'      => 'nav',
            'container_class' => 'main-navigation',
            'walker'         => new Purelyst_Nav_Walker(),
            'depth'          => 1,
        ) );
    } else {
        // Default menu if no menu is set
        ?>
        <nav class="main-navigation">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-link current"><?php esc_html_e( 'Home', 'purelyst' ); ?></a>
            <?php
            $categories = get_categories( array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 3,
            ) );
            
            foreach ( $categories as $category ) {
                printf(
                    '<a href="%s" class="nav-link">%s</a>',
                    esc_url( get_category_link( $category->term_id ) ),
                    esc_html( $category->name )
                );
            }
            ?>
        </nav>
        <?php
    }
}

/**
 * Display mobile navigation
 */
function purelyst_mobile_navigation() {
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => 'mobile-nav-list',
            'container'      => 'nav',
            'container_class' => 'mobile-navigation',
            'container_id'   => 'mobile-menu',
            'depth'          => 1,
            'link_before'    => '',
            'link_after'     => '',
        ) );
    } else {
        ?>
        <nav class="mobile-navigation" id="mobile-menu">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-nav-link"><?php esc_html_e( 'Home', 'purelyst' ); ?></a>
            <?php
            $categories = get_categories( array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 3,
            ) );
            
            foreach ( $categories as $category ) {
                printf(
                    '<a href="%s" class="mobile-nav-link">%s</a>',
                    esc_url( get_category_link( $category->term_id ) ),
                    esc_html( $category->name )
                );
            }
            ?>
        </nav>
        <?php
    }
}

/**
 * Display footer navigation
 */
function purelyst_footer_navigation( $location = 'footer-explore' ) {
    if ( has_nav_menu( $location ) ) {
        wp_nav_menu( array(
            'theme_location' => $location,
            'menu_class'     => 'footer-nav-list',
            'container'      => false,
            'walker'         => new Purelyst_Footer_Nav_Walker(),
            'depth'          => 1,
        ) );
    }
}

/**
 * Display social links
 */
function purelyst_social_links() {
    $social_links = array(
        'website' => array(
            'url'   => get_theme_mod( 'purelyst_social_website', '' ),
            'icon'  => 'public',
            'label' => __( 'Website', 'purelyst' ),
        ),
        'rss'     => array(
            'url'   => get_bloginfo( 'rss2_url' ),
            'icon'  => 'rss_feed',
            'label' => __( 'RSS Feed', 'purelyst' ),
        ),
        'email'   => array(
            'url'   => get_theme_mod( 'purelyst_social_email', '' ) ? 'mailto:' . get_theme_mod( 'purelyst_social_email', '' ) : '',
            'icon'  => 'alternate_email',
            'label' => __( 'Email', 'purelyst' ),
        ),
    );

    echo '<div class="footer-social">';
    
    foreach ( $social_links as $key => $link ) {
        if ( ! empty( $link['url'] ) ) {
            printf(
                '<a href="%s" class="social-link" aria-label="%s" target="_blank" rel="noopener noreferrer">
                    <span class="material-symbols-outlined" aria-hidden="true">%s</span>
                </a>',
                esc_url( $link['url'] ),
                esc_attr( $link['label'] ),
                esc_html( $link['icon'] )
            );
        }
    }
    
    echo '</div>';
}

/**
 * Display popular topics/tags
 */
function purelyst_popular_topics( $number = 5 ) {
    $tags = get_tags( array(
        'orderby' => 'count',
        'order'   => 'DESC',
        'number'  => $number,
    ) );

    if ( ! empty( $tags ) ) {
        echo '<div class="topics-list">';
        
        foreach ( $tags as $tag ) {
            printf(
                '<a href="%s" class="topic-link">%s</a>',
                esc_url( get_tag_link( $tag->term_id ) ),
                esc_html( $tag->name )
            );
        }
        
        echo '</div>';
    }
}

/**
 * Display breadcrumbs
 */
function purelyst_breadcrumbs() {
    if ( is_front_page() ) {
        return;
    }

    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'purelyst' ) . '">';
    echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'purelyst' ) . '</a>';
    echo '<span class="breadcrumb-separator" aria-hidden="true"> / </span>';

    if ( is_category() ) {
        single_cat_title();
    } elseif ( is_tag() ) {
        single_tag_title();
    } elseif ( is_single() ) {
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            printf(
                '<a href="%s">%s</a>',
                esc_url( get_category_link( $categories[0]->term_id ) ),
                esc_html( $categories[0]->name )
            );
            echo '<span class="breadcrumb-separator" aria-hidden="true"> / </span>';
        }
        the_title();
    } elseif ( is_page() ) {
        the_title();
    } elseif ( is_search() ) {
        printf( esc_html__( 'Search Results for: %s', 'purelyst' ), get_search_query() );
    } elseif ( is_404() ) {
        esc_html_e( 'Page Not Found', 'purelyst' );
    }

    echo '</nav>';
}

/**
 * Display post navigation
 */
function purelyst_post_navigation() {
    $prev_post = get_previous_post();
    $next_post = get_next_post();

    if ( ! $prev_post && ! $next_post ) {
        return;
    }

    echo '<nav class="post-navigation" style="max-width: 720px; margin: 2rem auto; padding: 0 1.5rem; display: flex; justify-content: space-between; gap: 2rem;">';
    
    if ( $prev_post ) {
        printf(
            '<a href="%s" class="post-nav-link post-nav-prev" style="flex: 1; text-decoration: none;">
                <span class="post-nav-label" style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">%s</span>
                <span class="post-nav-title" style="display: block; font-size: 1rem; font-weight: 600; color: var(--color-text-primary); margin-top: 0.25rem;">%s</span>
            </a>',
            esc_url( get_permalink( $prev_post ) ),
            esc_html__( 'Previous', 'purelyst' ),
            esc_html( get_the_title( $prev_post ) )
        );
    }
    
    if ( $next_post ) {
        printf(
            '<a href="%s" class="post-nav-link post-nav-next" style="flex: 1; text-align: right; text-decoration: none;">
                <span class="post-nav-label" style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">%s</span>
                <span class="post-nav-title" style="display: block; font-size: 1rem; font-weight: 600; color: var(--color-text-primary); margin-top: 0.25rem;">%s</span>
            </a>',
            esc_url( get_permalink( $next_post ) ),
            esc_html__( 'Next', 'purelyst' ),
            esc_html( get_the_title( $next_post ) )
        );
    }
    
    echo '</nav>';
}
