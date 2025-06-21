<?php
// Template: archive.php
?>
<?php get_header(); ?><main class="container"><h1><?php the_archive_title(); ?></h1><?php if(have_posts()): while(have_posts()): the_post(); get_template_part('template-parts/content'); endwhile; the_posts_pagination(); else:?><p><?php esc_html_e('No posts found.','fmtbroker-pro'); ?></p><?php endif; ?></main><?php get_footer(); ?>8
