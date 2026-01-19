<?php
/**
 * Search form template
 *
 * @package Purelyst
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$unique_id = wp_unique_id( 'search-form-' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="<?php echo esc_attr( $unique_id ); ?>">
        <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'purelyst' ); ?></span>
    </label>
    <input 
        type="search" 
        id="<?php echo esc_attr( $unique_id ); ?>" 
        class="search-field" 
        placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'purelyst' ); ?>" 
        value="<?php echo get_search_query(); ?>" 
        name="s" 
        autocomplete="off"
    >
    <button type="submit" class="search-submit">
        <span class="material-symbols-outlined" aria-hidden="true">search</span>
        <?php echo esc_html_x( 'Search', 'submit button', 'purelyst' ); ?>
    </button>
</form>
