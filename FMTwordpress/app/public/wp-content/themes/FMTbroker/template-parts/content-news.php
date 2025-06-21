<article id="news-<?php the_ID(); ?>" <?php post_class('news-item'); ?>>
  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <div class="news-excerpt"><?php the_excerpt(); ?></div>
</article>