<?php
if (function_exists('the_custom_logo')) {
  the_custom_logo();
} else {
  ?><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a><?php
}
?>