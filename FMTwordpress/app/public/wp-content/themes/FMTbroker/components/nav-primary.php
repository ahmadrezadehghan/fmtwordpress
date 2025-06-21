<?php
// Component: nav-primary.php
wp_nav_menu([
  'theme_location' => 'primary',
  'container'      => false,
  'menu_class'     => 'nav-menu',
  'fallback_cb'    => false,
  'depth'          => 2,
  'link_before'    => '<span>',
  'link_after'     => '</span>',
]);
?>
