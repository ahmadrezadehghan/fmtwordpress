<?php
// Template: search.php
?>
<?php get_header(); ?><main class="container"><h1><?php printf(__('Search Results for: %s','fmtbroker-pro'), get_search_query()); ?></h1><?php if(have_posts()): while(have_posts()): the_post(); get_template_part('template-parts/content'); endwhile; the_posts_pagination(); else: ?><p><?php esc_html_e('No results found.','fmtbroker-pro'); ?></p><?php endif; ?></main><?php get_footer(); ?>