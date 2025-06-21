<?php
/**
 * Combined template for both the blog index (card list) and single-post views.
 *
 * Place this file as /wp-content/themes/FMTbroker/index.php (or home.php).
 */

get_header(); ?>

<style>
/* ===== Global ===== */
html, body {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  background-color: #212121;
  color: #e0e0e0;
  font-family: sans-serif;
  scroll-behavior: smooth;
}

/* ===== Three-Column Container ===== */
.container-three-col {
  display: grid;
  grid-template-columns: 1fr 3fr 1fr;
  gap: 2rem;
  width: 100%;
  min-height: calc(100vh - var(--header-height, 90px));
  margin: 0 auto;
  padding: 2rem 1rem;
  box-sizing: border-box;
  background-color: #212121;
}

/* ===== Left & Right Panels (always visible) ===== */
/* ===== Left & Right Panels (always visible) ===== */
.left-panel,
.right-panel {
  /* marble‐plus‐tint background */
  background-image:
    linear-gradient(rgba(250,250,250,0.1), rgba(33,33,33,0.9)),
    url('<?php echo esc_url(get_template_directory_uri().'/assets/images/marble.png'); ?>');
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  background-color: #2a2a2a;            /* fallback tint */
  background-blend-mode: overlay;      /* tint over marble */

  padding: 1rem;
  border-radius: 8px;
  position: sticky;
  top: var(--header-height, 90px);
  height: calc(100vh - var(--header-height, 90px) - 2rem);
  overflow-y: auto;
}

.left-panel h3,
.right-panel h3 {
  margin-top: 0;
  color: #1694ca;
  font-size: 1.25rem;
}
.left-panel ul,
.right-panel ul {
  list-style: none;
  padding: 0;
  margin: 0 0 1rem 0;
}
.left-panel li a,
.right-panel li a {
  color: #e0e0e0;
  text-decoration: none;
  line-height: 1.5;
}
.left-panel li a:hover,
.right-panel li a:hover {
  color: #1694ca;
}

/* ===== Center: Blog List ===== */
.blog-list-center {
  overflow-y: auto;
  max-height: calc(100vh - var(--header-height, 90px) - 2rem);
  display: flex;
  flex-direction: column;
  gap: 2rem;
}
.blog-item {
  display: flex;
  flex-wrap: wrap;
  background-color: #2a2a2a;
  box-shadow: 0 2px 8px rgba(0,0,0,0.7);
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
}
.blog-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.9);
}
/* Excerpt first, image on the right */
.blog-item .excerpt {
  flex: 1;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.blog-item h2 {
  margin: 0 0 0.5rem;
  font-size: 1.25rem;
  color: #ffffff;
}
.blog-item h2 a {
  color: #1694ca;
  text-decoration: none;
  transition: color 0.2s;
}
.blog-item h2 a:hover {
  color: #117a9e;
}
.blog-item p {
  margin: 0 0 1rem;
  color: #cccccc;
  flex: 1;
}
.blog-item .meta {
  font-size: 0.85rem;
  color: #888888;
}
.blog-item .post-stats {
  margin-top: 0.5rem;
  font-size: 0.85rem;
  color: #cccccc;
}
/* Thumbnail on the right */
.blog-item .thumb {
  flex: 0 0 200px;
  height: 100%;
  background-size: cover;
  background-position: center;
}

/* ===== Center: Single Post ===== */
.single-content {
  background-color: #ffffff; /* white background */
  color: #000000;            /* black text */
  padding: 2rem;
  border-radius: 8px;
  overflow-y: auto;
  max-height: calc(100vh - var(--header-height, 90px) - 2rem);
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}
.single-content .back-to-blog {
  font-size: 1rem;
}
.single-content .back-to-blog a {
  color: #1694ca;
  text-decoration: none;
  transition: color 0.2s;
}
.single-content .back-to-blog a:hover {
  color: #117a9e;
}
.single-content h2.post-title {
  margin: 0 0 1rem;
  font-size: 2rem;
  color: #000000; /* ensure title is black */
}
.single-content .post-meta {
  font-size: 0.85rem;
  color: #555555; /* dark gray for meta */
  margin-bottom: 1.5rem;
}
.single-content .featured-image {
  width: 100%;
  margin-bottom: 1.5rem;
}
.single-content .post-body {
  line-height: 1.6;
}
/* Assign IDs to headings if missing */
.single-content .post-body h1,
.single-content .post-body h2,
.single-content .post-body h3,
.single-content .post-body h4,
.single-content .post-body h5 {
  scroll-margin-top: 100px; /* space for sticky panels */
}

/* ===== New: Dark-Footer Container for Interactions/Comments ===== */
.post-footer-container {
  background-color: #2a2a2a;
  padding: 1.5rem;
  border-radius: 8px;
  margin-top: 1.5rem;
  color: #e0e0e0;
}
.post-footer-container h3 {
  margin: 0 0 1rem;
  color: #1694ca;
  font-size: 1.25rem;
}

/* ===== Post Interactions (Likes/Dislikes/Comments/Views) ===== */
.post-interactions {
  display: flex;
  justify-content: space-around;
  align-items: center;
  border-top: 1px solid #555555;
  padding-top: 1rem;
  margin-bottom: 1.5rem;
}
.post-interactions button,
.post-interactions .stat {
  display: flex;
  align-items: center;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1rem;
  color: inherit;
  transition: color 0.2s;
}
.post-interactions button img,
.post-interactions .stat img {
  width: 1.5rem;
  height: 1.5rem;
  margin-right: 0.25rem;
}

/* 1) Make every icon white by default */
.post-interactions img {
  /* brightness(0)→black, invert(1)→white */
  filter: brightness(0) invert(1);
}

/* 2) Like button active → green */
.post-interactions button.like.active img {
  /* invert→white, sepia→reddish, saturate→increase, hue-rotate→green shift, brightness→keep bright */
  filter: invert(0.8) sepia(1) saturate(500) hue-rotate(50deg) brightness(1);
}

/* 3) Dislike button active → red */
.post-interactions button.dislike.active img {
  filter: invert(0.2) sepia(1) saturate(500) hue-rotate(330deg) brightness(1);
}

/* 4) View icon (wrapper .views) → blue */
.post-interactions .stat.views img {
  filter: invert(0.2) sepia(1) saturate(500) hue-rotate(200deg) brightness(1);
}

/* 5) Comment icon (wrapper .message) → purple */
.post-interactions .stat.message img {
  filter: invert(0.7) sepia(1) saturate(500) hue-rotate(290deg) brightness(0.9);
}

/* ===== Comments List (Dark Style) ===== */
.comments-area-dark {
  border-top: 1px solid #555555;
  padding-top: 1rem;
  margin-bottom: 1.5rem;
}
.comments-area-dark h3.comments-title {
  margin-bottom: 1rem;
  color: #1694ca;
  font-size: 1.25rem;
}
.comment-list-dark {
  list-style: none;
  padding: 0;
  margin: 0;
}
/* Each comment row: avatar | content | actions */
.comment-list-dark li {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  border-bottom: 1px solid #555555;
  padding: 0.75rem 0;
}
.comment-list-dark li .comment-avatar {
  margin-right: 1rem;
}
.comment-list-dark li .comment-avatar img {
  border-radius: 50%;
  width: 48px;
  height: 48px;
}
.comment-list-dark li .comment-main {
  flex: 1;
}
.comment-list-dark li .comment-author {
  font-weight: bold;
  color: #1694ca;
}
.comment-list-dark li .comment-meta {
  font-size: 0.85rem;
  color: #888888;
  margin-bottom: 0.5rem;
}
.comment-list-dark li .comment-content {
  color: #e0e0e0;
  line-height: 1.5;
}
/* Right‐side comment actions in a row */
.comment-list-dark li .comment-actions {
  display: flex;
  align-items: center;
  margin-left: 1rem;
}
.comment-list-dark li .comment-actions button {
  background: none;
  border: none;
  cursor: pointer;
  color: inherit;
  padding: 0.25rem;
  margin-right: 1rem;
  transition: color 0.2s;
}
.comment-list-dark li .comment-actions button img {
  width: 1.25rem;
  height: 1.25rem;
}
/* 1) Make every comment-icon white by default */
.comment-list-dark li .comment-actions button img {
  filter: brightness(0) invert(1);
}
/* 2) Comment-like active → green */
.comment-list-dark li .comment-actions button.comment-like.active img {
  filter: invert(0.8) sepia(1) saturate(500) hue-rotate(50deg) brightness(1);
}
/* 3) Comment-dislike active → red */
.comment-list-dark li .comment-actions button.comment-dislike.active img {
  filter: invert(0.2) sepia(1) saturate(500) hue-rotate(330deg) brightness(1);
}
/* Show the count next to comment like/dislike */
.comment-list-dark li .comment-actions .count {
  margin-left: 0.25rem;
  font-size: 0.85rem;
  color: #e0e0e0;
}

/* ===== Reply + Total Comments ===== */
/* ===== Reply + Total Comments ===== */
.comment-list-dark li .comment-actions .comment-reply,
.comment-list-dark li .comment-actions .user-total-comments {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-right: 0.5rem;
  font-size: 0.65rem; /* overall smaller font */
  width: 4rem;
  text-align: center;
}

/* Icon sizing remains unchanged */
.comment-list-dark li .comment-actions .comment-reply img{
  width: 1.7rem;
  height: 1.2rem;
  margin-bottom: 0.25rem;
  filter: brightness(0) invert(1);

}
.comment-list-dark li .comment-actions .user-total-comments .label {
  width: 3rem;
  height: 1.25rem;
  margin-top: 0.4rem;
  margin-bottom: 0.2rem;
  filter: brightness(0) invert(1);
}

/* Limit “Total Comments” to 2 lines and reduce font size further */
.comment-list-dark li .comment-actions .user-total-comments .label {
  font-size: 0.6rem;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  line-height: 1.1;
  word-break: break-word;
}

/* ===== Comment Form (Dark Style) ===== */
.comment-form-dark {
  border-top: 1px solid #555555;
  padding-top: 1rem;
}
.comment-form-dark h3 {
  margin-bottom: 1rem;
  color: #1694ca;
  font-size: 1.25rem;
}
.comment-form-dark form label {
  display: block;
  margin-bottom: 0.5rem;
  color: #e0e0e0;
  font-weight: 600;
}
.comment-form-dark form input[type="text"],
.comment-form-dark form input[type="email"],
.comment-form-dark form textarea {
  width: 100%;
  padding: 0.5rem;
  background-color: #3a3a3a;
  border: 1px solid #555555;
  border-radius: 4px;
  margin-bottom: 1rem;
  color: #ffffff;
}
.comment-form-dark form input[type="submit"] {
  background-color: #1694ca;
  color: #ffffff;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.2s;
}
.comment-form-dark form input[type="submit"]:hover {
  background-color: #117a9e;
}

/* ===== Right-Panel TOC (Fast Access) ===== */
#toc {
  margin: 0;
  padding: 0;
}
#toc li {
  list-style: none;
  margin: 0.25rem 0;
  position: relative; /* for indicator positioning */
}
#toc li a {
  color: #e0e0e0;
  text-decoration: none;
  display: block;
  padding: 0.25rem 0.5rem 0.25rem 1.5rem; /* left-padding for indicator */
  border-radius: 4px;
  transition: color 0.2s, background-color 0.2s;
}
/* Remove any old per-item dots */
#toc li a::before {
  content: none;
}
/* Single moving blue dot */
.toc-container {
  position: relative;
}
#toc-indicator {
  position: absolute;
  left: 8px;              /* same left offset as old dots */
  width: 8px;
  height: 8px;
  background-color: #00bfff;
  border-radius: 50%;
  transition: top 0.25s ease; /* smooth movement */
  pointer-events: none;
  opacity: 0.8;
  transform: translateY(-50%); /* vertical center alignment */
  display: none; /* hidden until positioned */
}
/* Active heading highlight */
#toc li.active > a {
  color: #ffffff !important;
  background-color: rgba(63, 0, 125, 0.3);
}
/* Indentation & font sizes for levels */
#toc li .toc-h1 { font-size: 1.1rem; margin-left: 0; }
#toc li .toc-h2 { font-size: 1rem; margin-left: 1rem; }
#toc li .toc-h3 { font-size: 0.9rem; margin-left: 2rem; }
#toc li .toc-h4 { font-size: 0.8rem; margin-left: 3rem; }
#toc li .toc-h5 { font-size: 0.7rem; margin-left: 4rem; }

/* ===== Pagination ===== */
.blog-pagination {
  text-align: center;
  margin-top: 2rem;
}
.blog-pagination .page-numbers {
  display: inline-block;
  margin: 0 .25rem;
  padding: .5rem .75rem;
  background-color: #2a2a2a;
  color: #e0e0e0;
  border: 1px solid #444;
  border-radius: 4px;
  text-decoration: none;
}
.blog-pagination .page-numbers.current {
  background-color: #1694ca;
  color: #ffffff;
  border-color: #1694ca;
}
.blog-pagination .page-numbers:hover {
  background-color: #117a9e;
}
/* Utility transitions */
a {
  transition: color 0.2s, background-color 0.2s;
}
</style>

<main class="container-three-col" role="main">

  <!-- Left Panel: Sort By + Recent/Tags (sticky) -->
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
      $current_sort = isset( $_GET['sort'] ) ? sanitize_key( $_GET['sort'] ) : 'latest';

      // Link base: Posts page or home
      $blog_page_id = get_option( 'page_for_posts' );
      if ( $blog_page_id ) {
        $base_url = get_permalink( $blog_page_id );
      } else {
        $base_url = home_url( '/' );
      }

      foreach ( $tabs as $key => $label ) {
        $active = ( $current_sort === $key ) ? 'style="color:#1694ca;font-weight:bold;"' : '';
        $url    = add_query_arg( 'sort', $key, $base_url );
        echo "<li><a href='" . esc_url( $url ) . "' {$active}>{$label}</a></li>";
      }
      ?>
    </ul>

    <!-- Moved from right-panel: Recent Posts, etc. -->
    <h3>Recent Posts</h3>
    <ul>
      <?php
      $recent_posts = wp_get_recent_posts([
        'numberposts' => 5,
        'post_status' => 'publish',
      ]);
      foreach ( $recent_posts as $p ) {
        $title = esc_html( $p['post_title'] );
        $link  = get_permalink( $p['ID'] );
        echo "<li><a href='" . esc_url( $link ) . "'>{$title}</a></li>";
      }
      // Hard-coded fallback items if needed:
      echo '<li><a href="#">Everything You Should Know About Forex 2025</a></li>';
      echo '<li><a href="#">Hello world!</a></li>';
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
      $tag = get_term_by( 'name', 'فارکس', 'post_tag' );
      if ( $tag ) {
        $tag_link = get_tag_link( $tag->term_id );
        echo '<a href="' . esc_url( $tag_link ) . '" style="color:#e0e0e0; text-decoration:none;">فارکس</a>';
      }
      ?>
    </div>
  </aside>

  <!-- Center Panel: conditional content -->
  <section>
    <?php if ( is_single() ) : ?>
      <!-- ===== Single-Post View ===== -->
      <div class="single-content">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php
            $blog_page_id = get_option( 'page_for_posts' );
            if ( $blog_page_id ) {
              $blog_url   = get_permalink( $blog_page_id );
              $blog_title = get_the_title( $blog_page_id );
            } else {
              $blog_url   = home_url( '/' );
              $blog_title = 'Blog';
            }
          ?>
          <div class="back-to-blog">
            <a href="<?php echo esc_url( $blog_url ); ?>">← <?php echo esc_html( $blog_title ); ?></a>
          </div>

          <h2 class="post-title"><?php the_title(); ?></h2>

          <div class="post-meta">
            <?php echo get_the_date( 'F j, Y' ); ?> by <?php the_author(); ?>
          </div>

          <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image">
              <?php the_post_thumbnail( 'large', [ 'style' => 'width:100%; height:auto;' ] ); ?>
            </div>
          <?php endif; ?>

          <div class="post-body">
            <?php the_content(); ?>
          </div>

        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>

      <!-- ===== New: Dark Footer Container with Interactions + Comments + Form ===== -->
      <div class="post-footer-container">
        <?php
          $post_id = get_the_ID();

          // 1) Increment view count on page load
          $view_count = (int) get_post_meta( $post_id, 'view_count', true );
          $view_count++;
          update_post_meta( $post_id, 'view_count', $view_count );

          // 2) Fetch like/dislike counts
          $like_count    = (int) get_post_meta( $post_id, 'like_count', true );
          $dislike_count = (int) get_post_meta( $post_id, 'dislike_count', true );

          // 3) Fetch approved comments
          $approved_comments = get_comments([
            'post_id' => $post_id,
            'status'  => 'approve',
          ]);
          $comment_count = count( $approved_comments );
        ?>

        <div class="post-interactions">
          <!-- Like Button -->
          <button class="like" data-post="<?php echo $post_id; ?>">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/thumbs_up1.png' ); ?>" alt="Like">
            <span class="count"><?php echo esc_html( $like_count ); ?></span>
          </button>

          <!-- Dislike Button -->
          <button class="dislike" data-post="<?php echo $post_id; ?>">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/thumbs_down1.png' ); ?>" alt="Dislike">
            <span class="count"><?php echo esc_html( $dislike_count ); ?></span>
          </button>

          <!-- Comment Count (purple if > 0) -->
          <?php $comment_class = $comment_count > 0 ? 'message' : ''; ?>
          <div class="stat <?php echo $comment_class; ?>">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/comment3.png' ); ?>" alt="Comments">
            <span><?php echo esc_html( $comment_count ); ?></span>
          </div>

          <!-- View Count (blue) -->
          <div class="stat views">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/view1.png' ); ?>" alt="Views">
            <span><?php echo esc_html( $view_count ); ?></span>
          </div>
        </div>

        <?php if ( $comment_count ) : ?>
          <div class="comments-area-dark">
            <h3 class="comments-title">
              <?php
                echo esc_html( $comment_count ) . ' Comment' . ( $comment_count > 1 ? 's' : '' );
              ?>
            </h3>

            <ul class="comment-list-dark">
              <?php
                foreach ( $approved_comments as $comment ) :
                  $comment_id     = $comment->comment_ID;
                  $author_name    = esc_html( $comment->comment_author );
                  $author_email   = $comment->comment_author_email;
                  $comment_date   = esc_html( get_comment_date( '', $comment ) );
                  $content        = esc_html( $comment->comment_content );

                  // Per-comment like/dislike
                  $c_like_count     = (int) get_comment_meta( $comment_id, 'like_count', true );
                  $c_dislike_count  = (int) get_comment_meta( $comment_id, 'dislike_count', true );

                  // Count this author’s total approved comments
                  $author_count = count( get_comments([
                    'post_id'      => $post_id,
                    'status'       => 'approve',
                    'author_email' => $author_email,
                  ]) );

                  // Set global $comment for reply link
                  $GLOBALS['comment'] = $comment;
              ?>
                <li id="comment-<?php echo esc_attr( $comment_id ); ?>">
                  <div class="comment-avatar">
                    <?php echo get_avatar( $comment, 48 ); ?>
                  </div>

                  <div class="comment-main">
                    <div class="comment-author"><?php echo $author_name; ?></div>
                    <div class="comment-meta"><?php echo $comment_date; ?></div>
                    <div class="comment-content"><?php echo $content; ?></div>
                  </div>

                  <div class="comment-actions">
                    <!-- Like Comment -->
                    <button class="comment-like" data-comment="<?php echo esc_attr( $comment_id ); ?>">
                      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/thumbs_up1.png' ); ?>" alt="Like Comment">
                      <span class="count"><?php echo esc_html( $c_like_count ); ?></span>
                    </button>

                    <!-- Dislike Comment -->
                    <button class="comment-dislike" data-comment="<?php echo esc_attr( $comment_id ); ?>">
                      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/thumbs_down1.png' ); ?>" alt="Dislike Comment">
                      <span class="count"><?php echo esc_html( $c_dislike_count ); ?></span>
                    </button>

                    <!-- Reply: icon above, text below -->
                    <div class="comment-reply">
                      <?php
                        comment_reply_link( array(
                          'depth'       => 1,
                          'max_depth'   => get_option( 'thread_comments_depth', 5 ),
                          'reply_text'  => '<img src="' . get_template_directory_uri() . '/assets/images/reply.png" alt="Reply Icon">',
                          'before'      => '',
                          'after'       => '',
                          'add_below'   => 'comment-' . $comment_id,
                        ) );
                      ?>
                      <span class="reply-text">Reply</span>
                    </div>

                    <!-- Total Comments by this author: text above, count below -->
                    <div class="user-total-comments">
                      <span class="label">Total Comments</span>
                      <span class="count"><?php echo intval( $author_count ); ?></span>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <?php if ( comments_open() ) : ?>
          <div class="comment-form-dark">
            <h3>Leave a Comment</h3>
            <?php
              comment_form( array(
                'title_reply'          => '',
                'comment_notes_before' => '',
                'comment_notes_after'  => '',
                'label_submit'         => 'Post Comment',
                'class_submit'         => 'submit-button',
                'comment_field'        =>
                  '<p><label for="comment" style="color:#e0e0e0; font-weight:600;">Comment</label><br />' .
                  '<textarea id="comment" name="comment" rows="4" required style="width:100%; padding:0.5rem; background-color:#3a3a3a; border:1px solid #555555; border-radius:4px; color:#ffffff;"></textarea></p>',
                'fields'               => array(
                  'author' => '<p><label for="author" style="color:#e0e0e0; font-weight:600;">Name <span class="required">*</span></label><br />' .
                              '<input id="author" name="author" type="text" required style="width:100%; padding:0.5rem; background-color:#3a3a3a; border:1px solid #555555; border-radius:4px; color:#ffffff;"></p>',
                  'email'  => '<p><label for="email" style="color:#e0e0e0; font-weight:600;">Email <span class="required">*</span></label><br />' .
                              '<input id="email" name="email" type="email" required style="width:100%; padding:0.5rem; background-color:#3a3a3a; border:1px solid #555555; border-radius:4px; color:#ffffff;"></p>',
                ),
              ) );
            ?>
          </div>
        <?php endif; ?>
      </div>

    <?php else : ?>
      <!-- ===== Blog-Card Index View ===== -->
      <div class="blog-list-center">
        <?php
        $paged = get_query_var( 'paged' ) ?: 1;
        $args  = [
          'post_type'      => 'post',
          'posts_per_page' => 10,
          'paged'          => $paged,
        ];

        switch ( $current_sort ) {
          case 'most_popular':
            $args['meta_key'] = 'view_count';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
            break;
          case 'forex':
            $args['category_name'] = 'forex';
            break;
          case 'crypto':
            $args['category_name'] = 'crypto';
            break;
          case 'recommended':
            $sticky = get_option( 'sticky_posts' );
            if ( ! empty( $sticky ) ) {
              $args['post__in'] = $sticky;
              $args['orderby']  = 'post__in';
            }
            break;
          case 'latest':
          default:
            $args['orderby'] = 'date';
            $args['order']   = 'DESC';
            break;
        }

        $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
          while ( $query->have_posts() ) : $query->the_post();
            $views = get_post_meta( get_the_ID(), 'view_count', true ) ?: 0;
            $likes = get_post_meta( get_the_ID(), 'like_count', true ) ?: 0;
            $thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ?: get_template_directory_uri() . '/assets/images/placeholder.png';
        ?>
          <article <?php post_class('blog-item'); ?> onclick="location.href='<?php the_permalink(); ?>';">
            <div class="excerpt">
              <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <p><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
              <div class="meta"><?php echo get_the_date(); ?> by <?php the_author(); ?></div>
              <div class="post-stats">
                <span>Views: <?php echo $views; ?></span> | <span>Likes: <?php echo $likes; ?></span>
              </div>
            </div>
            <div class="thumb" style="background-image:url('<?php echo esc_url( $thumb ); ?>')"></div>
          </article>
        <?php
          endwhile;
          wp_reset_postdata();
        else :
          echo '<p>No posts found.</p>';
        endif;
        ?>

        <!-- Pagination -->
        <?php if ( $query->max_num_pages > 1 ) : ?>
          <nav class="blog-pagination">
            <?php echo paginate_links([
              'total'     => $query->max_num_pages,
              'current'   => $paged,
              'mid_size'  => 1,
              'prev_text' => '«',
              'next_text' => '»',
            ]); ?>
          </nav>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- Right Panel: Fast Access (TOC) + Anything else you want (sticky) -->
  <aside class="right-panel">
    <h3>Fast Access</h3>
    <div class="toc-container">
      <ul id="toc">
        <!-- Table of Contents will be injected here via JavaScript -->
      </ul>
      <div id="toc-indicator"></div>
    </div>
  </aside>

</main>

<script>
/* === TOC generation (unchanged) === */
document.addEventListener('DOMContentLoaded', function() {
  if (!document.querySelector('.single-content')) return;

  const postBody = document.querySelector('.single-content .post-body');
  const headings = postBody.querySelectorAll('h1, h2, h3, h4, h5');
  const toc = document.getElementById('toc');

  if (!headings.length) {
    toc.innerHTML = '<li><em>No headings found.</em></li>';
    return;
  }

  headings.forEach((heading, index) => {
    if (!heading.id) {
      const slug = heading.textContent.trim()
        .toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]/g, '');
      heading.id = slug || 'heading-' + index;
    }
    const level = parseInt(heading.tagName.substring(1), 10);
    const li = document.createElement('li');
    const a = document.createElement('a');
    a.textContent = heading.textContent;
    a.href = '#' + heading.id;
    a.classList.add('toc-h' + level);
    li.appendChild(a);
    toc.appendChild(li);
  });

  const indicator = document.getElementById('toc-indicator');
  indicator.style.display = 'none';

  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.25
  };

  const callback = (entries) => {
    entries.forEach(entry => {
      const id = entry.target.id;
      const tocLink = toc.querySelector('a[href="#' + id + '"]');
      const listItem = tocLink.parentElement;
      if (entry.isIntersecting) {
        listItem.classList.add('active');
        const linkRect = tocLink.getBoundingClientRect();
        const containerRect = toc.getBoundingClientRect();
        const offsetWithinUL = linkRect.top - containerRect.top + (linkRect.height / 2);
        indicator.style.display = 'block';
        indicator.style.top = offsetWithinUL + 'px';
      } else {
        listItem.classList.remove('active');
      }
    });
  };

  const observer = new IntersectionObserver(callback, observerOptions);
  headings.forEach((heading) => observer.observe(heading));
});

/* === Like/Dislike button behavior (front-end only) === */
document.addEventListener('DOMContentLoaded', function() {
  // Post-level like/dislike
  const likeBtn    = document.querySelector('.post-interactions .like');
  const dislikeBtn = document.querySelector('.post-interactions .dislike');

  function toggleLike(isLike, countSpan, otherSpan, btn, otherBtn) {
    let count     = parseInt(countSpan.textContent, 10);
    let otherCount= parseInt(otherSpan.textContent, 10);

    if (btn.classList.contains('active')) {
      btn.classList.remove('active');
      countSpan.textContent = count - 1;
    } else {
      btn.classList.add('active');
      countSpan.textContent = count + 1;
      if (otherBtn.classList.contains('active')) {
        otherBtn.classList.remove('active');
        otherSpan.textContent = otherCount - 1;
      }
    }
  }

  if (likeBtn && dislikeBtn) {
    const likeCountSpan    = likeBtn.querySelector('.count');
    const dislikeCountSpan = dislikeBtn.querySelector('.count');

    likeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      toggleLike(true, likeCountSpan, dislikeCountSpan, likeBtn, dislikeBtn);
      // TODO: AJAX to persist post like
    });
    dislikeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      toggleLike(false, dislikeCountSpan, likeCountSpan, dislikeBtn, likeBtn);
      // TODO: AJAX to persist post dislike
    });
  }

  // Comment-level like/dislike
  document.querySelectorAll('.comment-list-dark li').forEach(li => {
    const btnLike    = li.querySelector('.comment-like');
    const btnDislike = li.querySelector('.comment-dislike');

    if (btnLike && btnDislike) {
      const countLikeSpan    = btnLike.querySelector('.count');
      const countDislikeSpan = btnDislike.querySelector('.count');

      btnLike.addEventListener('click', function(e) {
        e.preventDefault();
        let count     = parseInt(countLikeSpan.textContent, 10);
        let otherCount= parseInt(countDislikeSpan.textContent, 10);
        if (btnLike.classList.contains('active')) {
          btnLike.classList.remove('active');
          countLikeSpan.textContent = count - 1;
        } else {
          btnLike.classList.add('active');
          countLikeSpan.textContent = count + 1;
          if (btnDislike.classList.contains('active')) {
            btnDislike.classList.remove('active');
            countDislikeSpan.textContent = otherCount - 1;
          }
        }
        // TODO: AJAX to persist comment like
      });
      btnDislike.addEventListener('click', function(e) {
        e.preventDefault();
        let count     = parseInt(countDislikeSpan.textContent, 10);
        let otherCount= parseInt(countLikeSpan.textContent, 10);
        if (btnDislike.classList.contains('active')) {
          btnDislike.classList.remove('active');
          countDislikeSpan.textContent = count - 1;
        } else {
          btnDislike.classList.add('active');
          countDislikeSpan.textContent = count + 1;
          if (btnLike.classList.contains('active')) {
            btnLike.classList.remove('active');
            countLikeSpan.textContent = otherCount - 1;
          }
        }
        // TODO: AJAX to persist comment dislike
      });
    }
  });
});
</script>

<?php get_footer(); ?>
