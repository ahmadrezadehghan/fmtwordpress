<?php
/**
 * Template Name: Contact
 */
get_header(); ?>
<main class="container page-contact">
  <?php while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; ?>
</main>
<?php get_footer(); ?>