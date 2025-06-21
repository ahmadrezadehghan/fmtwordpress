<?php
/**
 * Component: Header
 *
 * Outputs a modern glassmorphic header with logo/site title, nav, search, auth, and mobile toggle.
 * Implements proper <ul> around menu items for styling.
 */
?>
<header id="masthead" class="site-header">
  <div class="header-inner">
    <!-- Logo or Site Title -->
    <div class="site-branding">
      <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <?php
          $name = get_bloginfo('name');
          $formatted = str_ireplace(['fmt', 'broker'], ['FMT', 'broker'], $name);
        ?>
        <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-title"><?php echo esc_html( $formatted ); ?></a>
      <?php endif; ?>
    </div>

    <!-- Navigation and Search for Desktop -->
    <div class="nav-search-wrap">
      <nav id="site-navigation" class="main-navigation">
        <?php
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'nav-menu flex gap-8',
            // Use default <ul> wrapper
          ));
        ?>
      </nav>

      <form role="search" method="get" class="header-search" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="search" name="s" placeholder="Search symbols, news..." value="<?php echo get_search_query(); ?>" />
        <button type="submit">Go</button>
      </form>
    </div>

    <!-- Auth Buttons and Mobile Toggle -->
    <div class="header-actions">
      <a href="<?php echo wp_login_url(); ?>" class="sign-in">Sign In</a>
      <a href="<?php echo wp_registration_url(); ?>" class="btn btn-join">Join Free</a>
      <button class="mobile-menu-toggle" aria-controls="site-navigation" aria-expanded="false">
        <svg class="hamburger" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 6H20M4 12H20M4 18H20" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Navigation Panel -->
  <div class="mobile-nav-panel">
    <nav class="mobile-menu">
      <?php
        wp_nav_menu(array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'mobile-nav-list flex flex-col gap-4',
        ));
      ?>
    </nav>
    <div class="auth-links">
      <a href="<?php echo wp_login_url(); ?>">Sign In</a>
      <a href="<?php echo wp_registration_url(); ?>" class="btn btn-join">Join Free</a>
    </div>
  </div>
</header>
