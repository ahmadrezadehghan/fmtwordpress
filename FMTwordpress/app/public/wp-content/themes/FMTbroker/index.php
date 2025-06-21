<?php
// Template: index.php
?>
<?php get_header(); ?>
<main class="site-main container">
<?php if (have_posts()) : while (have_posts()) : the_post(); get_template_part('template-parts/content'); endwhile; the_posts_pagination(); else: get_template_part('template-parts/404'); endif; ?>
</main><?php get_sidebar(); ?><?php get_footer(); ?>