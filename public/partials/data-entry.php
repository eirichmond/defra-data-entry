<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://squareone.software
 * @since      1.0.0
 *
 * @package    Defra_Data_Entry
 * @subpackage Defra_Data_Entry/public/partials
 */
?>

<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
$class->defra_get_header('data-entry');
//get_header();
?>

<?php do_action('before_main_content'); ?>

<h1 class="entry-title"><?php the_title(); ?></h1>

    <p>Nothing to see here.</p>


<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>