<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if (is_singular()) : ?>
  <h1><?php the_title(); ?></h1>
  <?php the_content(); ?>
<?php else : ?>
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <?php the_excerpt(); ?>
<?php endif; ?>
</article>