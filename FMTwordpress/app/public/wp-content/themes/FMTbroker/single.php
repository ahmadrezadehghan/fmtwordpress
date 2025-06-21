<?php
/* DEBUG: which template is loading? */
echo '<!-- Using template: single.php -->';
get_header();
require get_template_directory() . '/pages/page-blog_single.php';
get_footer();
