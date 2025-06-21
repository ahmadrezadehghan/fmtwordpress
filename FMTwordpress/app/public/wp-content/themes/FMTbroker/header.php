<?php
/**
 * The header for our theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// THIS line must be present and *only* this
get_template_part( 'components/header' );
?>

<div id="content" class="site-content container mx-auto p-4">
