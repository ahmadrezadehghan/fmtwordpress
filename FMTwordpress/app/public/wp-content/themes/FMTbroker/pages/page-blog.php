<?php
/**
 * index.php (or home.php)
 *
 * Combined template for both the blog‐card index and single‐post views.
 *  - If viewing a single post: shows “Sort By” sidebar, post content in center, and right sidebar.
 *  - Otherwise: shows “Sort By” sidebar, a vertical list of post cards (image on right) in center, and right sidebar.
 *
 * Place this in your (child) theme folder as index.php (or home.php if your theme requires it).
 */

get_header(); ?>

<style>
  /* ===== Color Palette & Typography ===== */
  :root {
    --primary-dark: #1673ca;
    --primary: #1694ca;
    --primary-light: #16cac4;
    --accent: #f5a623;
    --bg-dark: #212121;
    --bg-medium: #2a2a2a;
    --bg-light: #333333;
    --text-light: #e0e0e0;
    --text-medium: #cccccc;
    --shadow-color: rgba(0, 0, 0, 0.6);
    --radius: 8px;
    --transition: 0.2s ease;
  }

  html, body {
    margin: 0; padding: 0;
    background: var(--bg-dark);
    color: var(--text-light);
    font-family: 'Segoe UI', Tahoma, sans-serif;
    scroll-behavior: smooth;
  }
  a {
    color: var(--primary);
    text-decoration: none;
    transition: color var(--transition);
  }
  a:hover { color: var(--primary-light); }

  /* ===== Three‐Column Layout ===== */
  .container-three-col {
    display: grid;
    grid-template-columns: 1fr 3fr 1fr;
    gap: 2rem;
    min-height: calc(100vh - var(--header-height, 90px));
    padding: 2rem 1rem;
    background: var(--bg-dark);
    box-sizing: border-box;
  }
  @media (max-width: 1024px) {
    .container-three-col {
      grid-template-columns: 1fr 4fr;
    }
  }
  @media (max-width: 768px) {
    .container-three-col {
      grid-template-columns: 1fr;
    }
  }

  /* ===== Side Panels ===== */
/* ===== Side Panels ===== */
.left-panel, .right-panel {
  /* marble + tinted overlay exactly as in Support/About */
  background-image:
    linear-gradient(rgba(250,250,250,0.1), rgba(33,33,33,0.9)),
    url('<?php echo esc_url(get_template_directory_uri().'/assets/images/marble.png'); ?>');
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  background-color: var(--bg-medium);      /* fallback color */
  background-blend-mode: overlay;           /* tint over marble */

  padding: 1rem;
  border-radius: var(--radius);
  box-shadow: 0 2px 8px var(--shadow-color);
  overflow-y: auto;
}

  .left-panel h3, .right-panel h3 {
    margin-top: 0;
    color: var(--primary);
    font-size: 1.25rem;
  }
  .left-panel ul, .right-panel ul {
    list-style: none; padding: 0; margin: 1rem 0 0;
  }
  .left-panel li a, .right-panel li a {
    display: block;
    padding: .25rem 0;
    color: var(--text-light);
    line-height: 1.5;
    transition: color var(--transition);
  }
  .left-panel li a:hover, .right-panel li a:hover {
    color: var(--primary-light);
  }

  /* ===== Blog‐Card List (Center) ===== */
  .blog-list-center {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }
  .blog-item {
    display: flex;
    background: var(--bg-medium);
    border-radius: var(--radius);
    box-shadow: 0 2px 8px var(--shadow-color);
    overflow: hidden;
    transition: transform var(--transition), box-shadow var(--transition);
    cursor: pointer;
  }
  .blog-item:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 4px 16px var(--shadow-color);
  }
  .blog-item .excerpt {
    flex: 1;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .blog-item h2 {
    margin: 0 0 .75rem;
    font-size: 1.5rem;
    color: #fff;
  }
  .blog-item h2 a {
    color: var(--primary);
    transition: color var(--transition);
  }
  .blog-item h2 a:hover {
    color: var(--primary-dark);
  }
  .blog-item p {
    margin: 0 0 1rem;
    color: var(--text-medium);
    flex: 1;
  }
  .blog-item .meta, .blog-item .post-stats {
    font-size: .85rem;
    color: var(--text-medium);
  }
  .blog-item .post-stats {
    margin-top: .5rem;
  }
  .blog-item .thumb {
    flex: 0 0 200px;
    background-size: cover;
    background-position: center;
  }

  /* ===== Single Post View ===== */
  .single-content {
    background: var(--bg-medium);
    padding: 2rem;
    border-radius: var(--radius);
    box-shadow: 0 2px 8px var(--shadow-color);
  }
  .single-content .back-to-blog {
    margin-bottom: 1rem;
  }
  .single-content .back-to-blog a {
    color: var(--primary);
  }
  .single-content .back-to-blog a:hover {
    color: var(--primary-dark);
  }
  .single-content h2.post-title {
    margin: 0 0 1rem;
    font-size: 2rem;
    color: #fff;
  }
  .single-content .post-meta {
    font-size: .85rem;
    color: var(--text-medium);
    margin-bottom: 1.5rem;
  }
  .single-content .post-body {
    color: var(--text-medium);
    line-height: 1.6;
  }

  /* ===== Pagination ===== */
  .blog-pagination {
    text-align: center;
    margin-top: 2rem;
  }
  .blog-pagination .page-numbers {
    display: inline-block;
    margin: 0 .25rem;
    padding: .5rem .75rem;
    background: var(--bg-medium);
    color: var(--text-light);
    border: 1px solid #444;
    border-radius: var(--radius);
    transition: background var(--transition), color var(--transition);
  }
  .blog-pagination .page-numbers.current {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }
  .blog-pagination .page-numbers:hover {
    background: var(--primary-dark);
    color: #fff;
  }
</style>

<main class="container-three-col" role="main">

  <!-- Left Panel: Sort By -->
  <aside class="left-panel">
    <h3>Sort By</h3>
    <ul>
      <?php
      $tabs = [
        'latest'       => 'Latest',
        'most_popular' => 'Most Popular',
        'forex'        => 'Forex',
        'crypto'       => 'Crypto',
        'recommended'  => 'Recommended',
      ];
      $current_sort = sanitize_key( $_GET['sort'] ?? 'latest' );
      $base_url = get_option('page_for_posts')
        ? get_permalink(get_option('page_for_posts'))
        : home_url('/');
      foreach ( $tabs as $key => $label ) {
        $active = ($current_sort === $key) ? 'style="color:var(--primary);font-weight:700;"' : '';
        $url    = add_query_arg('sort', $key, $base_url);
        echo "<li><a href='" . esc_url($url) . "' {$active}>{$label}</a></li>";
      }
      ?>
    </ul>
  </aside>

  <!-- Center Panel -->
  <section>
    <?php if ( is_single() ) : ?>
      <div class="single-content">
        <?php
        while ( have_posts() ) : the_post();
          $blog_url   = get_option('page_for_posts')
            ? get_permalink(get_option('page_for_posts'))
            : home_url('/');
          $blog_title = get_option('page_for_posts')
            ? get_the_title(get_option('page_for_posts'))
            : 'Blog';
        ?>
          <div class="back-to-blog">
            <a href="<?php echo esc_url($blog_url); ?>">← <?php echo esc_html($blog_title); ?></a>
          </div>
          <h2 class="post-title"><?php the_title(); ?></h2>
          <div class="post-meta"><?php echo get_the_date(); ?> by <?php the_author(); ?></div>
          <div class="post-body"><?php the_content(); ?></div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <div class="blog-list-center">
        <?php
        $paged = get_query_var('paged') ?: 1;
        $args = ['post_type'=>'post','posts_per_page'=>10,'paged'=>$paged];
        switch ($current_sort) {
          case 'most_popular':
            $args['meta_key']='view_count';
            $args['orderby']='meta_value_num';
            $args['order']='DESC';
            break;
          case 'forex': $args['category_name']='forex'; break;
          case 'crypto': $args['category_name']='crypto'; break;
          case 'recommended':
            $sticky = get_option('sticky_posts');
            if ($sticky) { $args['post__in']=$sticky; $args['orderby']='post__in'; }
            break;
          default:
            $args['orderby']='date'; $args['order']='DESC';
        }
        $query = new WP_Query($args);
        if ($query->have_posts()):
          while ($query->have_posts()): $query->the_post();
            $views = get_post_meta(get_the_ID(),'view_count',true) ?: 0;
            $likes = get_post_meta(get_the_ID(),'like_count',true)  ?: 0;
            $thumb = get_the_post_thumbnail_url(get_the_ID(),'medium')
                     ?: get_template_directory_uri().'/assets/images/placeholder.png';
        ?>
          <article <?php post_class('blog-item'); ?> onclick="location.href='<?php the_permalink(); ?>'">
            <div class="excerpt">
              <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <p><?php echo wp_trim_words(get_the_excerpt(),20); ?></p>
              <div class="meta"><?php echo get_the_date(); ?> by <?php the_author(); ?></div>
              <div class="post-stats">Views: <?php echo $views; ?> | Likes: <?php echo $likes; ?></div>
            </div>
            <div class="thumb" style="background-image:url('<?php echo esc_url($thumb); ?>')"></div>
          </article>
        <?php
          endwhile;
          wp_reset_postdata();
        else:
          echo '<p>No posts found.</p>';
        endif;
        ?>

        <?php if ($query->max_num_pages>1): ?>
          <nav class="blog-pagination">
            <?php
            echo paginate_links([
              'total'=>$query->max_num_pages,
              'current'=>$paged,
              'mid_size'=>1,
              'prev_text'=>'«','next_text'=>'»',
            ]);
            ?>
          </nav>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- Right Panel -->
  <aside class="right-panel">
    <h3>Recent Posts</h3>
    <ul>
      <?php
      foreach ( wp_get_recent_posts(['numberposts'=>5,'post_status'=>'publish']) as $p ) {
        printf('<li><a href="%s">%s</a></li>',
          esc_url(get_permalink($p['ID'])),
          esc_html($p['post_title'])
        );
      }
      ?>
    </ul>
    <h3>Everything You Should Know About Forex 2025</h3>
    <ul>
      <li><a href="#">Elementor #45</a></li>
      <li><a href="#">Hello world!</a></li>
    </ul>
    <h3>Tags</h3>
    <div>
      <?php
      $tag = get_term_by('name','فارکس','post_tag');
      if ($tag) {
        printf('<a href="%s">%s</a>',
          esc_url(get_tag_link($tag->term_id)),
          esc_html($tag->name)
        );
      } else {
        wp_tag_cloud([
          'smallest'=>12,'largest'=>12,'unit'=>'px','format'=>'flat','separator'=>' ',
        ]);
      }
      ?>
    </div>
  </aside>

</main>

<?php get_footer(); ?>
