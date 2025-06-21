<?php
/**
 * page.php
 * Fallback for all other static pages (excluding Front and Posts pages).
 */

get_header();

// Charts page?
if ( is_page( 'charts' ) ) {
    require get_template_directory() . '/pages/page-chart.php';
    get_footer();
    exit;
}

// About page?
if ( is_page( 'About Us' ) ) {
    require get_template_directory() . '/pages/page-about.php';
    get_footer();
    exit;
}

// Help & Support page?
if ( is_page( 'Help & Support' ) ) {
    require get_template_directory() . '/pages/page-support-team.php';
    get_footer();
    exit;
}

// Financial Calendar page?
if ( is_page( 'Financial Calendar' ) ) {
    require get_template_directory() . '/pages/page-financial-calendar.php';
    get_footer();
    exit;
}

// Financial News page?
if ( is_page( 'Financial News' ) ) {
    require get_template_directory() . '/pages/page-financial-news.php';
    get_footer();
    exit;
}
if ( is_page( 'News Detail' ) ) {
  require get_template_directory() . '/pages/news-detail.php';
  get_footer();
  exit;
}
if ( is_page( 'Training & Courses' ) ) {
  require get_template_directory() . '/pages/page-training-and-courses.php';
  get_footer();
  exit;
}
if ( is_page( 'Course Detail' ) ) {
  require get_template_directory() . '/pages/course-detail.php';
  get_footer();
  exit;
}
if ( is_page( 'User Profile' ) ) {
  require get_template_directory() . '/pages/profile.php';
  get_footer();
  exit;
}
if ( is_page( 'Partner Area' ) ) {
  require get_template_directory() . '/pages/Partner_Area.php';
  get_footer();
  exit;
}
?>
<main id="primary" class="site-main container mx-auto p-4">
  <?php
  while ( have_posts() ) :
    the_post();
    get_template_part( 'template-parts/content', 'page' );
  endwhile;
  ?>
</main>
<?php
get_footer();
