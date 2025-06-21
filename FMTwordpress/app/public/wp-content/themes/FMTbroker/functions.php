<?php
require get_template_directory() . '/inc/setup.php';

/**
 * Disable the admin bar on the front‐end.
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Enqueue theme styles/scripts.
 */
function fmt_pro_enqueue() {
    wp_enqueue_style( 'fmt-pro-style',  get_stylesheet_uri(), [], '1.0' );
    wp_enqueue_style( 'fmt-pro-custom', get_template_directory_uri() . '/assets/css/custom.css', [], '1.0' );
    wp_enqueue_script( 'fmt-pro-main', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'fmt_pro_enqueue' );
?>
