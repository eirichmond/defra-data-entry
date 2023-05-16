<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Defra_Data
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> class="h-full bg-gray-100">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <div class="container-sm">
        <?php the_custom_logo(); ?>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="bg-light">
      <div class="container-sm">
        <?php wp_nav_menu(
          array(
            'theme_location' => 'data-entry',
            'menu_id'        => 'navbarSupportedContent',
            'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0 collapse navbar-collapse',
            'container' => 'nav',
            'container_class' => 'navbar navbar-expand-lg bg-body-tertiary',
            'depth' => 10,
            'walker' => new WP_Bootstrap_Nav_Walker()
          )
        ); ?>
      </div>
    </div>

    <div class="data-entry-main-container">
	      <div class="mt-2">
            <div class="container-sm">

		
			

