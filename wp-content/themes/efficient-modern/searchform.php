<?php
/**
 * The searchform template
 *
 * @package Efficient_Modern
 * @since 1.0.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="search-input" class="screen-reader-text">
        <?php esc_html_e( 'Search for:', 'efficient-modern' ); ?>
    </label>
    <input type="search" 
           id="search-input"
           class="search-field" 
           placeholder="<?php echo esc_attr_x( 'Search products, services...', 'placeholder', 'efficient-modern' ); ?>" 
           value="<?php echo get_search_query(); ?>" 
           name="s" 
           required />
    <button type="submit" class="search-submit">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span class="screen-reader-text"><?php esc_html_e( 'Search', 'efficient-modern' ); ?></span>
    </button>
</form>
