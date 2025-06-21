<?php
// Theme setup and support
function fmt_pro_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    register_nav_menus([
        'primary' => __('Primary Menu', 'fmtbroker-pro'),
        'footer'  => __('Footer Menu', 'fmtbroker-pro'),
    ]);
    add_theme_support('html5', ['search-form','gallery','caption','comment-form','comment-list']);
}
add_action('after_setup_theme', 'fmt_pro_setup');
function fmtbroker_enqueue_styles() {
    // Main theme stylesheet
    wp_enqueue_style( 'fmtbroker-style', get_stylesheet_uri() );

    // Custom overrides
    wp_enqueue_style(
      'fmtbroker-custom',
      get_template_directory_uri() . '/assets/css/custom.css',
      array( 'fmtbroker-style' ),
      filemtime( get_template_directory() . '/assets/css/custom.css' )
    );
  }
  add_action( 'wp_enqueue_scripts', 'fmtbroker_enqueue_styles' );

// Register widget areas
function fmt_pro_widgets() {
    register_sidebar([
        'name' => __('Sidebar', 'fmtbroker-pro'),
        'id'   => 'sidebar-1',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'fmt_pro_widgets');

// Custom post type for Financial News
function fmt_pro_cpt_news() {
    register_post_type('financial_news', [
        'label' => __('Financial News', 'fmtbroker-pro'),
        'public' => true,
        'has_archive' => true,
        'supports' => ['title','editor','thumbnail','excerpt'],
        'menu_icon' => 'dashicons-media-document',
    ]);
}
add_action('init', 'fmt_pro_cpt_news');
?>
