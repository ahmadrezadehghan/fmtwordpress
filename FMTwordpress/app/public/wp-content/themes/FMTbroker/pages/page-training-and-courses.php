<?php
/**
 * Template Name: Training & Courses
 */

get_header(); ?>

<style>
/* ===== Global ===== */
html,
body {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  background-color: #212121;
  color: #e0e0e0;
  font-family: sans-serif;
}

/* ===== Three‐Column Container ===== */
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

/* ===== Left & Right Panels ===== */
/* ===== Left & Right Panels ===== */
.left-panel,
.right-panel {
  /* marble + tinted overlay */
  background-image:
    linear-gradient(rgba(250,250,250,0.1), rgba(33,33,33,0.9)),
    url('<?php echo esc_url(get_template_directory_uri().'/assets/images/marble.png'); ?>');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-color: #2a2a2a;      /* fallback tint */
  background-blend-mode: overlay;

  padding: 1rem;
  border-radius: 8px;
  height: 100%;
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
  margin: 0;
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

/* ===== Center: Course Cards ===== */
.course-list-center {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  overflow-y: auto;
}
.course-item {
  display: flex;
  background-color: #2a2a2a;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.7);
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}
.course-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.9);
}
/* Left: text, Right: thumbnail */
.course-item .details {
  flex: 1;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.course-item h2 {
  margin: 0 0 0.5rem;
  font-size: 1.5rem;
  color: #ffffff;
}
.course-item h2 a {
  color: #1694ca;
  text-decoration: none;
  transition: color 0.2s;
}
.course-item h2 a:hover {
  color: #117a9e;
}
.course-item p {
  margin: 0 0 1rem;
  color: #cccccc;
  flex: 1;
}
.course-item .meta {
  font-size: 0.85rem;
  color: #888888;
  margin-bottom: 0.5rem;
}
.course-item .enroll-btn {
  align-self: flex-start;
  background-color: #1694ca;
  color: #ffffff;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  text-decoration: none;
  transition: background-color 0.2s;
}
.course-item .enroll-btn:hover {
  background-color: #117a9e;
}
.course-item .thumb {
  flex: 0 0 200px;
  background-size: cover;
  background-position: center;
}

/* ===== Pagination (if needed) ===== */
.course-pagination {
  text-align: center;
  margin-top: 2rem;
}
.course-pagination .page-numbers {
  display: inline-block;
  margin: 0 .25rem;
  padding: .5rem .75rem;
  background-color: #2a2a2a;
  color: #e0e0e0;
  border: 1px solid #444;
  border-radius: 4px;
  text-decoration: none;
}
.course-pagination .page-numbers.current {
  background-color: #1694ca;
  color: #ffffff;
  border-color: #1694ca;
}
.course-pagination .page-numbers:hover {
  background-color: #117a9e;
}

/* Utility transitions */
a {
  transition: color 0.2s;
}
</style>

<main class="container-three-col" role="main">

  <!-- Left Panel: Categories or Navigation -->
  <aside class="left-panel">
    <h3>Categories</h3>
    <ul>
      <li><a href="<?php echo home_url( '/training-and-courses/?cat=beginner' ); ?>">Beginner</a></li>
      <li><a href="<?php echo home_url( '/training-and-courses/?cat=intermediate' ); ?>">Intermediate</a></li>
      <li><a href="<?php echo home_url( '/training-and-courses/?cat=advanced' ); ?>">Advanced</a></li>
      <li><a href="<?php echo home_url( '/training-and-courses/?cat=certification' ); ?>">Certification</a></li>
      <li><a href="<?php echo home_url( '/training-and-courses/?cat=webinars' ); ?>">Webinars</a></li>
    </ul>
  </aside>

  <!-- Center Panel: Course Listings -->
  <section>
    <div class="course-list-center">
      <?php
      // Example array of courses
      $courses = [
        [
          'title'       => 'Forex Trading for Beginners',
          'date'        => 'Starts: July 10, 2025',
          'excerpt'     => 'Learn the fundamentals of Forex trading, including pips, lots, and basic chart analysis.',
          'thumbnail'   => get_template_directory_uri() . '/assets/images/forex-beginners.jpg',
          'link'        => home_url( '/course-detail/?id=0' ),
        ],
        [
          'title'       => 'Advanced Technical Analysis',
          'date'        => 'Starts: August 1, 2025',
          'excerpt'     => 'Deep dive into advanced chart patterns, Fibonacci retracements, and Elliott Wave theory.',
          'thumbnail'   => get_template_directory_uri() . '/assets/images/technical-analysis.jpg',
          'link'        => home_url( '/course-detail/?id=1' ),
        ],
        [
          'title'       => 'Cryptocurrency Trading 101',
          'date'        => 'Starts: July 20, 2025',
          'excerpt'     => 'Understand blockchain fundamentals and learn how to trade Bitcoin, Ethereum, and altcoins.',
          'thumbnail'   => get_template_directory_uri() . '/assets/images/crypto-trading.jpg',
          'link'        => home_url( '/course-detail/?id=2' ),
        ],
        [
          'title'       => 'Risk Management & Money Management',
          'date'        => 'Starts: September 5, 2025',
          'excerpt'     => 'Master risk-reward ratios, position sizing, and psychological aspects to protect your capital.',
          'thumbnail'   => get_template_directory_uri() . '/assets/images/risk-management.jpg',
          'link'        => home_url( '/course-detail/?id=3' ),
        ],
        [
          'title'       => 'Trading Certification Program',
          'date'        => 'Starts: October 15, 2025',
          'excerpt'     => 'Comprehensive course leading to an official trading certification recognized by top brokers.',
          'thumbnail'   => get_template_directory_uri() . '/assets/images/certification.jpg',
          'link'        => home_url( '/course-detail/?id=4' ),
        ],
      ];

      foreach ( $courses as $course ) :
      ?>
        <article class="course-item">
          <div class="thumb" style="background-image: url('<?php echo esc_url( $course['thumbnail'] ); ?>');"></div>
          <div class="details">
            <h2><a href="<?php echo esc_url( $course['link'] ); ?>"><?php echo esc_html( $course['title'] ); ?></a></h2>
            <div class="meta"><?php echo esc_html( $course['date'] ); ?></div>
            <p><?php echo esc_html( $course['excerpt'] ); ?></p>
            <a class="enroll-btn" href="<?php echo esc_url( $course['link'] ); ?>">Learn More</a>
          </div>
        </article>
      <?php endforeach; ?>

      <!-- Pagination (example) -->
      <div class="course-pagination">
        <a class="page-numbers" href="#">&laquo; Prev</a>
        <span class="page-numbers current">1</span>
        <a class="page-numbers" href="#">2</a>
        <a class="page-numbers" href="#">3</a>
        <a class="page-numbers" href="#">Next &raquo;</a>
      </div>
    </div>
  </section>

  <!-- Right Panel: Recent Posts & Tags -->
  <aside class="right-panel">
    <h3>Recent Posts</h3>
    <ul>
      <?php
      $recent_posts = wp_get_recent_posts( [
        'numberposts' => 5,
        'post_status' => 'publish',
      ] );
      foreach ( $recent_posts as $p ) {
        $title = esc_html( $p['post_title'] );
        $link  = get_permalink( $p['ID'] );
        echo "<li><a href='" . esc_url( $link ) . "'>{$title}</a></li>";
      }
      ?>
    </ul>

    <h3>Tags</h3>
    <div>
      <?php
      $tag = get_term_by( 'name', 'Training', 'post_tag' );
      if ( $tag ) {
        $tag_link = get_tag_link( $tag->term_id );
        echo '<a href="' . esc_url( $tag_link ) . '" style="color:#e0e0e0; text-decoration:none;">Training</a>';
      } else {
        wp_tag_cloud( [
          'smallest'  => 12,
          'largest'   => 12,
          'unit'      => 'px',
          'format'    => 'flat',
          'separator' => ' ',
        ] );
      }
      ?>
    </div>
  </aside>

</main>

<?php get_footer(); ?>
