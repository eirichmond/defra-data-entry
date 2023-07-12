<?php 
$class = new Defra_Data_Entry_Public('DEFRA_DATA_ENTRY','DEFRA_DATA_ENTRY_VERSION');
get_header();
?>

<?php do_action('before_main_content'); ?>

    <h1 class="entry-title"><?php the_title(); ?></h1>

<?php do_action('after_main_content'); ?>


<?php get_footer(); ?>